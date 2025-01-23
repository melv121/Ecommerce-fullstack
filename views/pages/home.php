<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Fishing-Store</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../../includes/navbar.php'; ?>
    <section id="product-list">
        <h2>Featured Products</h2>
        <div class="products">
            <?php
            require_once __DIR__ . '/../../models/Article.php';
            $products = Article::getAll();
            foreach ($products as $product): ?>
                <div class="product-item">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <img src="/ecommerce/public/image/computer.jpg" alt="Default Image">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <?php if (isset($product['is_promotion']) && $product['is_promotion']): ?>
                        <p class="card-text"><span class="text-danger">Promotion: $<?php echo number_format($product['promotion_price'], 2); ?></span> <del>$<?php echo number_format($product['price'], 2); ?></del></p>
                    <?php else: ?>
                        <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
                    <?php endif; ?>
                    <form class="add-to-cart-form mt-auto" action="/ecommerce/public/cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="ajax" value="1">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <script src="public/js/main.js"></script>
    <script>
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(cartCount => {
                    document.querySelector('.cart-count').textContent = cartCount;
                });
            });
        });
    </script>
</body>
</html>
