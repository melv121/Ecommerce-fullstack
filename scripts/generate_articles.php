<?php
require_once __DIR__ . '/../config/database.php';

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function generateRandomPrice() {
    return rand(100, 10000) / 100;
}

function generateRandomDate() {
    $timestamp = rand(strtotime("2022-01-01"), strtotime("2023-12-31"));
    return date("Y-m-d", $timestamp);
}

function insertRandomArticles($numArticles = 10) {
    global $conn;
    for ($i = 0; $i < $numArticles; $i++) {
        $name = generateRandomString(10);
        $description = generateRandomString(50);
        $price = generateRandomPrice();
        $promotion_price = rand(0, 1) ? generateRandomPrice() : null;
        $promotion_start = $promotion_price ? generateRandomDate() : null;
        $promotion_end = $promotion_price ? generateRandomDate() : null;
        $image = 'https://via.placeholder.com/150';

        $query = "INSERT INTO articles (name, description, price, promotion_price, promotion_start, promotion_end, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssddsss', $name, $description, $price, $promotion_price, $promotion_start, $promotion_end, $image);
        $stmt->execute();
    }
}

insertRandomArticles(20); // Générer 20 articles aléatoires
echo "20 articles have been inserted into the database.";
?>
