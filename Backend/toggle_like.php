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
    $userId = $data['user_id'] ?? 1;
    $productId = $data['product_id'] ?? null;
    
    if (!$productId) {
        throw new Exception('Product ID is required');
    }
    
    // Check if like exists
    $checkQuery = "SELECT id, likes_count FROM product_likes WHERE user_id = ? AND product_id = ?";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$userId, $productId]);
    $existingLike = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingLike) {
        // Toggle: if likes_count is 1, set to 0, if 0 set to 1
        $newCount = $existingLike['likes_count'] == 1 ? 0 : 1;
        $updateQuery = "UPDATE product_likes SET likes_count = ?, updated_at = NOW() WHERE id = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$newCount, $existingLike['id']]);
        $liked = $newCount == 1;
    } else {
        // Insert new like
        $insertQuery = "INSERT INTO product_likes (user_id, product_id, likes_count, updated_at) VALUES (?, ?, 1, NOW())";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([$userId, $productId]);
        $liked = true;
    }
    
    // Get total likes for this product
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
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
