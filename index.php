<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /ecommerce/public/register.php');
    exit;
}


$sql = "SELECT * FROM articles ORDER BY id DESC";
$stmt = $pdo->query($sql);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Fishop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
    <style>
        .hero-section {
            background: url('/ecommerce/image2.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            width: 100%;
            margin: 0;
            padding: 0;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 4rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
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
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <div class="hero-section">
        <h1>Bienvenue chez Fishop</h1>
    </div>
    <main class="container mt-5">
        <section id="intro">
            <div class="row">
                <div class="col-md-6">
                    <h2>À propos de nous</h2>
                    <p>Bienvenue chez Fishop, votre boutique unique pour tous vos besoins en matière de pêche. Nous proposons une large gamme d'équipements de pêche, y compris des cannes, des moulinets, des leurres et des accessoires. Que vous soyez débutant ou pêcheur expérimenté, nous avons tout ce dont vous avez besoin pour rendre vos sorties de pêche réussies et agréables. Notre mission est de fournir des produits de haute qualité à des prix compétitifs, ainsi qu'un service client exceptionnel. Explorez notre collection et trouvez l'équipement parfait pour votre prochaine aventure de pêche.</p>
                </div>
            </div>
        </section>
        <section id="categories" class="container mt-5">
            <div class="row">
                
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="images/electronics.jpg" class="card-img-top" alt="Électronique">
                        <div class="card-body">
                            <h5 class="card-title">Électronique</h5>
                            <p class="card-text">Découvrez nos produits électroniques</p>
                            <a href="articles_by_category.php?category_id=1" class="btn btn-primary">Voir les produits</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="images/clothing.jpg" class="card-img-top" alt="Vêtements">
                        <div class="card-body">
                            <h5 class="card-title">Vêtements</h5>
                            <p class="card-text">Notre collection de vêtements</p>
                            <a href="articles_by_category.php?category_id=2" class="btn btn-primary">Voir les produits</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="images/books.jpg" class="card-img-top" alt="Livres">
                        <div class="card-body">
                            <h5 class="card-title">Livres</h5>
                            <p class="card-text">Explorez notre bibliothèque</p>
                            <a href="articles_by_category.php?category_id=3" class="btn btn-primary">Voir les produits</a>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="images/sports.jpg" class="card-img-top" alt="Sports">
                        <div class="card-body">
                            <h5 class="card-title">Sports & Loisirs</h5>
                            <p class="card-text">Équipements sportifs et loisirs</p>
                            <a href="articles_by_category.php?category_id=4" class="btn btn-primary">Voir les produits</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>