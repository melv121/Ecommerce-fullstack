<?php
require_once __DIR__ . 'includes/database.php';
require_once __DIR__ . 'models/Article.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
<header>
        <h1>Products</h1>
    </header>
    <main>
        <section id="products" class="container mt-5">
            <div class="row">
                <?php
                $products = Article::getAll();
                foreach ($products as &$product) {
                    if (!empty($product['promotion_price']) && strtotime($product['promotion_start']) <= time() && strtotime($product['promotion_end']) >= time()) {
                        $product['is_promotion'] = true;
                    } else {
                        $product['is_promotion'] = false;
                    }
                }
                if (empty($products)): ?>
                    <p>No products available.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                    <?php if ($product['is_promotion']): ?>
                                        <div class="price-block">
                                            <span class="text-danger font-weight-bold">
                                                Prix promotion : <?php echo number_format($product['promotion_price'], 2); ?>€
                                            </span>
                                            <br>
                                            <span class="text-muted">
                                                <del>Prix normal : <?php echo number_format($product['price'], 2); ?>€</del>
                                            </span>
                                            <br>
                                            <span class="badge badge-danger">
                                                Promotion jusqu'au <?php echo date('d/m/Y', strtotime($product['promotion_end'])); ?>
                                            </span>
                                        </div>
                                    <?php else: ?>
                                        <p class="card-text">Prix : <?php echo number_format($product['price'], 2); ?>€</p>
                                    <?php endif; ?>
                                    <form action="/ecommerce/public/cart.php" method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>