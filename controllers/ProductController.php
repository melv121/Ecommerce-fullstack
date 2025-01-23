<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../models/Article.php'; // Corrected path to the Article class

// Initialize the database connection
function getConnection() {
    $database = new Database();
    return $database->getConnection();
}

function getAllProducts() {
    $conn = getConnection();
    $query = "SELECT id, name, description, price, promotion_price, promotion_start, promotion_end, image FROM articles";
    $result = $conn->query($query);
    $products = [];
    if ($result->rowCount() > 0) { // Updated to rowCount()
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($row['promotion_price']) && 
                isset($row['promotion_start']) && 
                isset($row['promotion_end']) && 
                strtotime($row['promotion_start']) <= time() && 
                strtotime($row['promotion_end']) >= time()) {
                $row['is_promotion'] = true;
            } else {
                $row['is_promotion'] = false;
            }
            $products[] = $row;
        }
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

// ...existing code...
?>