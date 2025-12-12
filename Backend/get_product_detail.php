<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

try {
    require_once 'db.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }
    
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($productId === 0) {
        throw new Exception('Product ID is required');
    }
    
    $query = "SELECT 
                p.id,
                p.name,
                p.image,
                p.description,
                p.size,
                p.price,
                p.created_at,
                p.user_id,
                pc.name as condition_name,
                pcat.name as category_name,
                pl.name as location_name,
                pcol.name as color_name,
                u.username as seller_name,
                COALESCE(SUM(likes.likes_count), 0) as total_likes,
                COALESCE(AVG(pr.rating), 0) as avg_rating,
                COUNT(DISTINCT pr.id) as rating_count
              FROM product p
              LEFT JOIN product_condition pc ON p.condition_id = pc.id
              LEFT JOIN product_category pcat ON p.category_id = pcat.id
              LEFT JOIN product_location pl ON p.location_id = pl.id
              LEFT JOIN product_color pcol ON p.color_id = pcol.id
              LEFT JOIN users u ON p.user_id = u.id
              LEFT JOIN product_likes likes ON p.id = likes.product_id
              LEFT JOIN product_rating pr ON p.id = pr.product_id
              WHERE p.id = :id
              GROUP BY p.id, p.name, p.image, p.description, p.size, p.price, p.created_at, p.user_id, pc.name, pcat.name, pl.name, pcol.name, u.username";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $productId]);
    
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        throw new Exception('Product not found');
    }
    
    // Log rating data for debugging
    $ratingQuery = "SELECT pr.id, pr.rating, pr.user_id, u.username as user_name 
                    FROM product_rating pr
                    LEFT JOIN users u ON pr.user_id = u.id
                    WHERE pr.product_id = :id";
    $ratingStmt = $pdo->prepare($ratingQuery);
    $ratingStmt->execute(['id' => $productId]);
    $ratings = $ratingStmt->fetchAll(PDO::FETCH_ASSOC);
    
    error_log('Product ID: ' . $productId);
    error_log('Ratings found: ' . count($ratings));
    error_log('Ratings data: ' . json_encode($ratings));
    error_log('Avg rating from query: ' . $product['avg_rating']);
    error_log('Rating count from query: ' . $product['rating_count']);
    
    $formattedProduct = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => number_format($product['price'], 0, ',', '.'),
        'size' => $product['size'] ? $product['size'] : 'One Size',
        'condition' => $product['condition_name'] ? $product['condition_name'] : 'N/A',
        'location' => $product['location_name'] ? $product['location_name'] : 'N/A',
        'description' => $product['description'] ? $product['description'] : 'No description available',
        'category' => $product['category_name'] ? $product['category_name'] : 'N/A',
        'color' => $product['color_name'] ? $product['color_name'] : 'N/A',
        'uploaded' => date('d M Y', strtotime($product['created_at'])),
        'image' => $product['image'] ? $product['image'] : '#E8E8E8',
        'likes' => (int)$product['total_likes'],
        'rating' => (float)number_format((float)$product['avg_rating'], 1, '.', ''),
        'rating_count' => (int)$product['rating_count'],
        'seller_name' => $product['seller_name'] ? $product['seller_name'] : 'Unknown Seller',
        'ratings_detail' => $ratings
    ];
    
    echo json_encode([
        'success' => true,
        'data' => $formattedProduct
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
