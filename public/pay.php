<?php
session_start();
require_once __DIR__ . '/../config/database.php'; // Assurez-vous que ce fichier initialise $pdo
require_once __DIR__ . '/../includes/functions.php'; // Corrected path to the functions file
require_once __DIR__ . '/../controllers/ProductController.php'; // Inclure le ProductController
require_once __DIR__ . '/../models/Cart.php'; // Inclure le modèle Cart

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

// Si le formulaire de paiement est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Logique de traitement du paiement ici
    // Par exemple, vider le panier après le paiement
    unset($_SESSION['cart']);
    header('Location: /ecommerce/public/success.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay - Fishing-Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <main class="container mt-5">
        <h2>Pay for Your Order</h2>
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
            <form action="pay.php" method="post">
                <div class="form-group">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
                </div>
                <div class="form-group">
                    <label for="cardExpiry">Expiry Date</label>
                    <input type="text" class="form-control" id="cardExpiry" name="cardExpiry" required>
                </div>
                <div class="form-group">
                    <label for="cardCVC">CVC</label>
                    <input type="text" class="form-control" id="cardCVC" name="cardCVC" required>
                </div>
                <div class="form-group">
                    <label for="paymentMethod">Payment Method</label>
                    <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                        <option value="paypal">PayPal</option>
                        <option value="applepay">Apple Pay</option>
                        <option value="creditcard">Credit Card</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Pay Now</button>
            </form>
        <?php endif; ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
