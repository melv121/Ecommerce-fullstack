<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../models/Article.php'; // Corrected path to the Article class

// Initialize the database connection
function getConnection() {
    $database = new Database();
    return $database->getConnection();
}

function getAllProducts($limit = null, $offset = 0) {
    $conn = getConnection();
    $query = "SELECT id, name, description, price, stock, reduction, image 
              FROM articles 
              ORDER BY id DESC";
    if ($limit !== null) {
        $query .= " LIMIT :limit OFFSET :offset";
    }
    
    $stmt = $conn->prepare($query);
    
    if ($limit !== null) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    $products = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Calcul du prix avec réduction
        if (!empty($row['reduction'])) {
            $row['has_promotion'] = true;
            $row['original_price'] = $row['price'];
            $row['price'] = $row['price'] * (1 - ($row['reduction'] / 100));
        } else {
            $row['has_promotion'] = false;
        }
        $products[] = $row;
    }
    return $products;
}

function getAllArticles() {
    $conn = getConnection();
    $query = "SELECT id, name, description, price, image FROM articles";
    $result = $conn->query($query);
    $articles = [];
    if ($result->rowCount() > 0) { // Updated to rowCount()
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = $row;
        }
    }
    return $articles;
}

function getPromotionalProducts() {
    $conn = getConnection();
    $query = "SELECT id, name, description, price, promotion_price, promotion_start, promotion_end, image FROM articles WHERE promotion_price IS NOT NULL AND promotion_start <= NOW() AND promotion_end >= NOW()";
    $result = $conn->query($query);
    $promotions = [];
    if ($result->rowCount() > 0) { // Updated to rowCount()
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $row['is_promotion'] = true;
            $promotions[] = $row;
        }
    }
    return $promotions;
}

function getProductById($id) {
    $conn = getConnection();
    $query = "SELECT id, name, description, price, promotion_price, promotion_start, promotion_end, image FROM articles WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(1, $id, PDO::PARAM_INT); // Updated to bindValue
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


?>