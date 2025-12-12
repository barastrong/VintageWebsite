<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    require_once 'db.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    // Menggunakan user_id dari input, atau fallback (sebaiknya gunakan session/token di production)
    $userId = $data['user_id'] ?? 1;
    $productId = $data['product_id'] ?? null;
    
    if (!$productId) {
        throw new Exception('Product ID is required');
    }
    
    // 1. Cek apakah user sudah pernah like produk ini
    $checkQuery = "SELECT id, likes_count FROM product_likes WHERE user_id = ? AND product_id = ?";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$userId, $productId]);
    $existingLike = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingLike) {
        // JIKA DATA ADA
        
        if ($existingLike['likes_count'] == 1) {
            // Skenario: User mau UNLIKE.
            // Sesuai permintaan: HAPUS (DELETE) datanya, bukan di-set ke 0.
            $deleteQuery = "DELETE FROM product_likes WHERE id = ?";
            $deleteStmt = $pdo->prepare($deleteQuery);
            $deleteStmt->execute([$existingLike['id']]);
            $liked = false;
        } else {
            // Skenario: Data ada tapi 0 (mungkin data lama/soft delete sebelumnya).
            // User mau LIKE kembali -> Update jadi 1.
            $updateQuery = "UPDATE product_likes SET likes_count = 1, updated_at = NOW() WHERE id = ?";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$existingLike['id']]);
            $liked = true;
        }
        
    } else {
        // JIKA DATA TIDAK ADA
        // Skenario: User mau LIKE -> Insert data baru
        $insertQuery = "INSERT INTO product_likes (user_id, product_id, likes_count, updated_at) VALUES (?, ?, 1, NOW())";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([$userId, $productId]);
        $liked = true;
    }
    
    // 2. Hitung total likes
    // Karena sekarang sistemnya delete, menghitung COUNT(id) sebenarnya lebih cepat daripada SUM,
    // tapi SUM tetap aman digunakan untuk kompatibilitas.
    $totalQuery = "SELECT COALESCE(SUM(likes_count), 0) as total FROM product_likes WHERE product_id = ?";
    $totalStmt = $pdo->prepare($totalQuery);
    $totalStmt->execute([$productId]);
    $total = $totalStmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'liked' => $liked,
        'total_likes' => (int)$total['total']
    ]);
    
} catch (Exception $e) {
    http_response_code(500); // Opsional: beri status code error
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>