<?php
session_start();
require_once __DIR__ . '/../config/database.php'; 
require_once __DIR__ . '/../includes/functions.php'; 
require_once __DIR__ . '/../controllers/ProductController.php'; 
require_once __DIR__ . '/../models/Cart.php'; 

$cart = $_SESSION['cart'] ?? [];
$products = [];
$total_price = 0;

foreach ($cart as $article_id => $quantity) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->execute([$article_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product) {
        $product['quantity'] = $quantity;
        $product['total_price'] = $product['price'] * $quantity;
        $total_price += $product['total_price'];
        $products[] = $product;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Fishing-Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <main class="container mt-5">
        <h2>Your Cart</h2>
        <?php if (empty($products)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="card-text">Price: <?php echo number_format($product['price'], 2); ?> €</p>
                                <p class="card-text">Quantity: <?php echo htmlspecialchars($product['quantity']); ?></p>
                                <p class="card-text">Total: <?php echo number_format($product['total_price'], 2); ?> €</p>
                                <form action="/ecommerce/public/remove_from_cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <h3>Total Price: <?php echo number_format($total_price, 2); ?> €</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="/ecommerce/public/pay.php" class="btn btn-success">Payer</a>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

