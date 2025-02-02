<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'] ?? null;

    if ($article_id === null) {
        die("Article ID is missing.");
    }

   
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    
    if (!isset($_SESSION['cart'][$article_id])) {
        $_SESSION['cart'][$article_id] = 1;
    } else {
        $_SESSION['cart'][$article_id]++;
    }


    echo '<pre>';
    print_r($_SESSION['cart']);
    echo '</pre>';

   
    header('Location: /ecommerce/public/cart.php');
    exit;
} else {
    die("Invalid request method.");
}
?>
