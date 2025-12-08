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
    
    $userId = $data['user_id'] ?? 0;
    $productId = $data['product_id'] ?? 0;
    $productName = $data['product_name'] ?? '';
    $quantity = $data['quantity'] ?? 1;
    
    if ($userId === 0 || $productId === 0) {
        throw new Exception('User ID and Product ID are required');
    }
    
    // Check if product already in cart
    $checkQuery = "SELECT id, quantity FROM product_cart 
                   WHERE user_id = :user_id AND product_id = :product_id AND is_cart = 1";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existing) {
        // Update quantity
        $updateQuery = "UPDATE product_cart 
                        SET quantity = quantity + :quantity, updated_at = NOW() 
                        WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute(['quantity' => $quantity, 'id' => $existing['id']]);
    } else {
        // Insert new cart item
        $insertQuery = "INSERT INTO product_cart (product_id, user_id, name, quantity, is_cart, created_at, updated_at) 
                        VALUES (:product_id, :user_id, :name, :quantity, 1, NOW(), NOW())";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([
            'product_id' => $productId,
            'user_id' => $userId,
            'name' => $productName,
            'quantity' => $quantity
        ]);
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart successfully'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
