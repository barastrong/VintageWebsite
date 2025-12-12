<?php
// confirm_order.php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['user_id'] ?? null;

if (!$userId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    exit;
}

$timeLimitMinutes = 5; 

try {
    $stmt = $pdo->prepare("
        UPDATE product_order 
        SET is_buy = 1, updated_at = NOW() 
        WHERE user_id = :userId 
          AND is_buy = 0
          AND created_at >= DATE_SUB(NOW(), INTERVAL :time_limit MINUTE)
    ");
    
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':time_limit', $timeLimitMinutes, PDO::PARAM_INT);
    
    $stmt->execute();
    
    $rowCount = $stmt->rowCount();

    http_response_code(200);
    echo json_encode(['success' => true, 'message' => $rowCount . ' order item(s) confirmed.', 'updated_count' => $rowCount]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'General error: ' . $e->getMessage()]);
}
?>