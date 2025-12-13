<?php
// create_new_order.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$oldOrderId = $data['order_id'] ?? null;

if (!$userId || !$oldOrderId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'User ID and Old Order ID are required.']);
    exit;
}

define('ADDRESS', 'Timedoor Academy');
define('PAYMENT_METHOD', 'VISA');
define('PROTECTION_PRICE', 15000);
define('SHIPPING_PRICE', 20000);
$quantity = 1;
$currentSql = ''; // Diganti namanya untuk menghindari konflik

try {
    $pdo->beginTransaction();

    // 1. Ambil detail produk dari pesanan lama
    $currentSql = "SELECT product_id, name 
            FROM product_order
            WHERE id = :orderId AND user_id = :userId";
    $stmt = $pdo->prepare($currentSql);
    $stmt->bindParam(':orderId', $oldOrderId, PDO::PARAM_INT);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $oldOrder = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$oldOrder) {
        throw new Exception("Order not found or user mismatch for old order ID: " . $oldOrderId);
    }

    // 2. Ambil harga unit dari tabel 'product'
    $currentSql = "SELECT price FROM product WHERE id = :productId";
    $productStmt = $pdo->prepare($currentSql);
    $productStmt->bindParam(':productId', $oldOrder['product_id'], PDO::PARAM_INT);
    $productStmt->execute();
    $unitPriceResult = $productStmt->fetch(PDO::FETCH_ASSOC);

    if (!$unitPriceResult) {
        throw new Exception("Product unit price not found for product ID: " . $oldOrder['product_id']);
    }
    
    $unitPrice = (int)$unitPriceResult['price'];
    $linePrice = $unitPrice * $quantity;
    $grandPrice = $linePrice + PROTECTION_PRICE + SHIPPING_PRICE;


    // 3. Masukkan ke tabel product_order (INSERT)
    $currentSql = "INSERT INTO `product_order` 
            (user_id, product_id, name, address, payment_method, quantity, price, protection_price, shipping_price, grand_price, is_buy, created_at, updated_at)
            VALUES (:userId, :productId, :name, :address, :paymentMethod, :quantity, :price, :protectionPrice, :shippingPrice, :grandPrice, 0, NOW(), NOW())";
    
    $orderStmt = $pdo->prepare($currentSql);
    
    $orderStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $orderStmt->bindParam(':productId', $oldOrder['product_id'], PDO::PARAM_INT);
    $orderStmt->bindParam(':name', $oldOrder['name']);
    
    // Ganti bindParam dengan bindValue untuk konstanta/variabel yang nilainya tidak berubah
    $orderStmt->bindValue(':address', ADDRESS); 
    $orderStmt->bindValue(':paymentMethod', PAYMENT_METHOD);

    $orderStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $orderStmt->bindParam(':price', $linePrice, PDO::PARAM_INT);
    $orderStmt->bindValue(':protectionPrice', PROTECTION_PRICE, PDO::PARAM_INT); 
    $orderStmt->bindValue(':shippingPrice', SHIPPING_PRICE, PDO::PARAM_INT);
    $orderStmt->bindParam(':grandPrice', $grandPrice, PDO::PARAM_INT);

    $orderStmt->execute();
    
    $newOrderId = $pdo->lastInsertId();

    $pdo->commit();
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'New order created from history.', 'new_order_id' => $newOrderId]);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'SQL Error: ' . $e->getMessage() . ' | Query: ' . $currentSql]);
    
} catch (Exception $e) {
     if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'General Error: ' . $e->getMessage()]);
}