<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

try {
    require_once 'db.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }
    
    $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
    $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
    
    if ($userId === 0 || $productId === 0) {
        throw new Exception('User ID and Product ID are required');
    }
    
    $query = "SELECT likes_count FROM product_likes 
              WHERE user_id = :user_id AND product_id = :product_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'liked' => $result && $result['likes_count'] > 0
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
