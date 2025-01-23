<?php
session_start();
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Initialize the database connection
$conn = (new Database())->getConnection();

// Fetch all articles to display on the home page
$articles = getAllArticles();
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
        <section id="intro">
            <div class="row">
                <div class="col-md-6">
                    <h2>À propos de nous</h2>
                    <p>Bienvenue chez Fishing-Store, votre boutique unique pour tous vos besoins en matière de pêche. Nous proposons une large gamme d'équipements de pêche, y compris des cannes, des moulinets, des leurres et des accessoires. Que vous soyez débutant ou pêcheur expérimenté, nous avons tout ce dont vous avez besoin pour rendre vos sorties de pêche réussies et agréables. Notre mission est de fournir des produits de haute qualité à des prix compétitifs, ainsi qu'un service client exceptionnel. Explorez notre collection et trouvez l'équipement parfait pour votre prochaine aventure de pêche.</p>
                </div>
            </div>
        </section>
        <h2>Nos produits</h2>
        <?php if (empty($articles)): ?>
            <p>Aucun produit disponible.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card">
                            <?php if (!empty($article['image'])): ?>
                                <img src="<?php echo htmlspecialchars($article['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($article['name']); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($article['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($article['description']); ?></p>
                                <p class="card-text">Prix : $<?php echo number_format($article['price'], 2); ?></p>
                                <form action="/ecommerce/public/cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $article['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
