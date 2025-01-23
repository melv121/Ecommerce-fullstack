<?php
session_start();

require_once __DIR__ . '/../controllers/ProductController.php';

$products = getAllArticles();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Fishing-Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <main class="container mt-5">
        <section id="product-list">
            <h2>Our Products</h2>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php 
                            $image_path = "/ecommerce/public/uploads/" . $product['image'];
                            if (isset($product['image']) && file_exists(__DIR__ . '/../uploads/' . $product['image'])): ?>
                                <img src="<?php echo htmlspecialchars($image_path); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php else: ?>
                                <img src="/ecommerce/public/image/computer.jpg" class="card-img-top" alt="Default Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <?php if ($product['is_promotion']): ?>
                                    <p class="card-text"><span class="text-danger">Promotion: $<?php echo number_format($product['promotion_price'], 2); ?></span> <del>$<?php echo number_format($product['price'], 2); ?></del></p>
                                <?php else: ?>
                                    <p class="card-text">Price: $<?php echo number_format($product['price'], 2); ?></p>
                                <?php endif; ?>
                                <form class="add-to-cart-form" action="/ecommerce/public/cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="ajax" value="1">
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
