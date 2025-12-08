<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

try {
    require_once 'db.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $cartId = $data['cart_id'] ?? 0;
    
    if ($cartId === 0) {
        throw new Exception('Cart ID is required');
    }
    
    // Update is_cart to 0
    $query = "UPDATE product_cart SET is_cart = 0, updated_at = NOW() WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $cartId]);
    
    // Delete the record
    $deleteQuery = "DELETE FROM product_cart WHERE id = :id AND is_cart = 0";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute(['id' => $cartId]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Item removed from cart'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
