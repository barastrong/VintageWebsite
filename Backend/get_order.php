<?php
// get_order.php (Nama file disesuaikan dari log error Anda)
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

$timeLimitMinutes = 5; 

try {
    
    $stmt = $pdo->prepare("
        SELECT 
            po.*, 
            p.image AS product_image,
            p.size AS product_size
        FROM product_order po
        JOIN product p ON po.product_id = p.id
        WHERE po.user_id = :userId 
          AND po.is_buy = 0 
          AND po.created_at >= DATE_SUB(NOW(), INTERVAL :time_limit MINUTE) 
        ORDER BY po.created_at DESC
    ");
    
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':time_limit', $timeLimitMinutes, PDO::PARAM_INT);
    
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $orders]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'General error: ' . $e->getMessage()]);
}
?>