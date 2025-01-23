<?php
require_once __DIR__ . '/../includes/database.php';

class Article {
    public static function getAll() {
        $db = (new Database())->getConnection();
        $query = "SELECT id, name, description, price, promotion_price, promotion_start, promotion_end, image FROM articles";
        $stmt = $db->query($query);
        return $stmt->fetchAll();
    }
}

class Product {
    public $id;
    public $name;
    public $description;
    public $price;
    public $promotion_price;
    public $promotion_start;
    public $promotion_end;
    public $image; // Add this line

    // ...existing code...
}
?>