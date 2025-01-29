<?php
require_once 'config/database.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: /ecommerce/public/register.php');
    exit;
}

// Calcul pour avoir exactement 3 pages
$total_articles = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$articles_per_page = ceil($total_articles / 3); // Diviser le total en 3 pages égales
$pages_total = 3; // Forcer 3 pages
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = min($pages_total, max(1, $page)); // Limiter entre 1 et 3

$offset = ($page - 1) * $articles_per_page;

// Récupérer les articles de la page courante
$sql = "SELECT * FROM articles ORDER BY id DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $articles_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - Fishop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <div class="container mt-5">
        <h1>Nos Produits - Page <?= $page ?>/3</h1>
        
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($article['image_url'])): ?>
                            <img src="<?= htmlspecialchars($article['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($article['name']) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($article['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($article['description']) ?></p>
                            <p class="card-text"><strong><?= htmlspecialchars($article['price']) ?> €</strong></p>
                            <form action="add_to_cart.php" method="post">
                                <input type="hidden" name="article_id" value="<?= htmlspecialchars($article['id']); ?>">
                                <input type="hidden" name="redirect_to_cart" value="1">
                                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination fixe à 3 pages -->
        <nav aria-label="Navigation des pages" class="mt-4 mb-4">
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
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
