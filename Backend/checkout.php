<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');
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

define('ADDRESS', 'Timedoor Academy');
define('PAYMENT_METHOD', 'VISA');
define('PROTECTION_PRICE', 15000);
define('SHIPPING_PRICE', 20000);

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        SELECT 
            c.id AS cart_id, 
            c.product_id, 
            c.name, 
            c.quantity, 
            p.price AS unit_price  
        FROM product_cart c
        JOIN product p ON c.product_id = p.id
        WHERE c.user_id = ? AND c.is_cart = 1
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($cartItems)) {
        $pdo->commit(); 
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Cart is empty. No order placed.']);
        exit;
    }

    $cartIdsToDelete = [];

    foreach ($cartItems as $item) {
        // Menggunakan alias unit_price dari p.price
        $unitPrice = (int)$item['unit_price']; 
        
        if ($unitPrice <= 0) {
            throw new Exception("Product ID " . $item['product_id'] . " has invalid price.");
        }

        $cartIdsToDelete[] = $item['cart_id'];
        
        $linePrice = $unitPrice * (int)$item['quantity'];
        $grandPrice = $linePrice + PROTECTION_PRICE + SHIPPING_PRICE;

        // Menggunakan product_order untuk INSERT
        $sql = "INSERT INTO `product_order` (user_id, product_id, name, address, payment_method, quantity, price, protection_price, shipping_price, grand_price, is_buy, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";
        
        $orderStmt = $pdo->prepare($sql);
        $orderStmt->execute([
            $userId,
            $item['product_id'],
            $item['name'],
            ADDRESS,
            PAYMENT_METHOD,
            $item['quantity'],
            $linePrice,
            PROTECTION_PRICE,
            SHIPPING_PRICE,
            $grandPrice,
        ]);
    }
    
    $placeholders = implode(',', array_fill(0, count($cartIdsToDelete), '?'));
    // Menggunakan cart untuk DELETE (sesuai dengan yang Anda berikan di kode terakhir)
    $deleteStmt = $pdo->prepare("DELETE FROM product_cart WHERE id IN ($placeholders)"); 
    $deleteStmt->execute($cartIdsToDelete);

    $pdo->commit();
    
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Order successfully placed and cart items cleared.', 'order_count' => count($cartItems)]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Order failed: ' . $e->getMessage()]);
}
?>