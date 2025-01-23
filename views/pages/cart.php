<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../../includes/navbar.php'; ?>
    <header class="container mt-5">
        <h1>Your Cart</h1>
    </header>
    <main class="container mt-5">
        <section id="cart-items">
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $cartItems = isset($_SESSION['cartItems']) ? $_SESSION['cartItems'] : [];
            if (empty($cartItems)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                                    <p class="card-text">Quantity: <?php echo $item['quantity']; ?></p>
                                    <?php if (isset($item['is_promotion']) && $item['is_promotion']): ?>
                                        <p class="card-text"><span class="text-danger">Promotion: $<?php echo number_format($item['price'], 2); ?></span> 
                                        <del>$<?php echo isset($item['original_price']) ? number_format($item['original_price'], 2) : ''; ?></del></p>
                                    <?php else: ?>
                                        <p class="card-text">Price: $<?php echo number_format($item['price'], 2); ?></p>
                                    <?php endif; ?>
                                    <form action="/ecommerce/public/cart.php" method="post" class="mt-auto">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" name="remove" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4">
                    <h4>Total: $<?php echo number_format(array_sum(array_map(function($item) {
                        return $item['price'] * $item['quantity'];
                    }, $cartItems)), 2); ?></h4>
                    <form action="/ecommerce/public/pay.php" method="post">
                        <button type="submit" class="btn btn-success">Pay</button>
                    </form>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>