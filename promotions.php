<?php
require_once 'config/database.php';
require_once 'controllers/ProductController.php';

$promotions = getActivePromotions();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Promotions - Notre E-commerce</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-4">
        <h1>Nos Promotions</h1>
        <div class="row">
            <?php foreach ($promotions as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if ($article['image']): ?>
                            <img src="<?= htmlspecialchars($article['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($article['name']) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($article['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($article['description']) ?></p>
                            <div class="price-section">
                                <del class="text-muted"><?= number_format($article['price'], 2) ?>€</del>
                                <span class="text-danger font-weight-bold">
                                    <?= number_format($article['discounted_price'], 2) ?>€
                                </span>
                                <span class="badge badge-danger">-<?= $article['reduction'] ?>%</span>
                            </div>
                            <form action="add_to_cart.php" method="post" class="mt-2">
                                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
