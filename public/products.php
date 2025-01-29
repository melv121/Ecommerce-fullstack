<?php
require_once '../config/database.php';
require_once '../controllers/ProductController.php';
session_start();

// Configuration de la pagination
$total_products = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$products_per_page = ceil($total_products / 3);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = min(3, max(1, $page));

$offset = ($page - 1) * $products_per_page;

// Récupérer les produits comme dans index.php
$products = getAllProducts($products_per_page, $offset);
foreach ($products as &$product) {
    if (!empty($product['promotion_price']) && 
        strtotime($product['promotion_start']) <= time() && 
        strtotime($product['promotion_end']) >= time()) {
        $product['is_promotion'] = true;
    } else {
        $product['is_promotion'] = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Fishing-Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            flex: 1;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <main class="container mt-5">
        <h2>Our Products - Page <?= $page ?> sur 3</h2>
        <?php if (empty($products)): ?>
            <p>No products available.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <?php if ($product['has_promotion']): ?>
                                    <p class="card-text">
                                        <span class="text-danger fw-bold">
                                            <?= number_format($product['price'], 2) ?> €
                                        </span>
                                        <del class="text-muted ms-2">
                                            <?= number_format($product['original_price'], 2) ?> €
                                        </del>
                                        <span class="badge bg-danger ms-2">
                                            -<?= $product['reduction'] ?>%
                                        </span>
                                    </p>
                                <?php else: ?>
                                    <p class="card-text"><?= number_format($product['price'], 2) ?> €</p>
                                <?php endif; ?>
                                <form action="/ecommerce/public/cart.php" method="post" class="mt-auto">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-shopping-cart"></i> Ajouter au panier
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <!-- Pagination à 3 pages -->
        <nav aria-label="Navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Précédent</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < 3): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
