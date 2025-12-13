<?php
// history.php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');

require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$userId = $_GET['user_id'] ?? null;

if (!$userId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    exit;
}

try {
    // Pengurutan berdasarkan updated_at DESC sudah mencakup tanggal dan waktu (hingga detik)
    // untuk menampilkan yang terbaru di atas.
    $stmt = $pdo->prepare("
        SELECT 
            po.*, 
            p.image AS product_image,
            p.size AS product_size
        FROM product_order po
        JOIN product p ON po.product_id = p.id
        WHERE po.user_id = :userId AND po.is_buy = 1 
        ORDER BY po.updated_at ASC
    ");

    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
    $stmt->execute();
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $history]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'General error: ' . $e->getMessage()]);
}
?>