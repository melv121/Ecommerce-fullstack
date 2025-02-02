<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['product_id'] ?? null;

    if ($article_id === null) {
        die("Product ID is missing.");
    }

    
    if (isset($_SESSION['cart'][$article_id])) {
        unset($_SESSION['cart'][$article_id]);
    }

   
    header('Location: /ecommerce/public/cart.php');
    exit;
} else {
    die("Invalid request method.");
}
?>
