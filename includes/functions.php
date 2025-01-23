<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/database.php';

function addToCart($productId) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
    header('Location: /ecommerce/public/cart.php');
    exit;
}

function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
    header('Location: /ecommerce/public/cart.php');
    exit;
}

function viewCart() {
    $database = new Database();
    $pdo = $database->getConnection();
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $products = [];
    if (!empty($cart)) {
        $ids = implode(',', array_keys($cart));
        $query = "SELECT * FROM articles WHERE id IN ($ids)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $cartItems = [];
    foreach ($products as $product) {
        $productId = $product['id'];
        if (isset($cartItems[$productId])) {
            $cartItems[$productId]['quantity'] += $cart[$productId];
        } else {
            $cartItems[$productId] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $cart[$productId]
            ];
        }
    }

    include __DIR__ . '/../views/pages/cart.php';
}
?>
