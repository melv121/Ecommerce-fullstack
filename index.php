<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /ecommerce/public/register.php');
    exit;
}
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
        .hero-section {
            background: url('/ecommerce/image2.jpg') no-repeat center center;
            background-size: cover;
            height: 500px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 3rem;
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
        <h1>Bienvenue dans notre Fishing-Store</h1>
    </div>
    <main class="container mt-5">
        <section id="intro">
            <div class="row">
                <div class="col-md-6">
                    <h2>À propos de nous</h2>
                    <p>Bienvenue chez Fishing-Store, votre boutique unique pour tous vos besoins en matière de pêche. Nous proposons une large gamme d'équipements de pêche, y compris des cannes, des moulinets, des leurres et des accessoires. Que vous soyez débutant ou pêcheur expérimenté, nous avons tout ce dont vous avez besoin pour rendre vos sorties de pêche réussies et agréables. Notre mission est de fournir des produits de haute qualité à des prix compétitifs, ainsi qu'un service client exceptionnel. Explorez notre collection et trouvez l'équipement parfait pour votre prochaine aventure de pêche.</p>
                </div>
            </div>
        </section>
        <section id="products" class="container mt-5">
            <div class="row">
                <?php
                require_once __DIR__ . '/controllers/ProductController.php';
                $products = getAllProducts();
                foreach ($products as &$product) {
                    if (!empty($product['promotion_price']) && strtotime($product['promotion_start']) <= time() && strtotime($product['promotion_end']) >= time()) {
                        $product['is_promotion'] = true;
                    } else {
                        $product['is_promotion'] = false;
                    }
                }
                if (empty($products)): ?>
                    <p>Aucun produit disponible.</p>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                                <div class="card">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                        <?php if ($product['is_promotion']): ?>
                                            <p class="card-text"><span class="text-danger">Promotion : $<?php echo number_format($product['promotion_price'], 2); ?></span> <del>$<?php echo number_format($product['price'], 2); ?></del></p>
                                        <?php else: ?>
                                            <p class="card-text">Prix : $<?php echo number_format($product['price'], 2); ?></p>
                                        <?php endif; ?>
                                        <form action="/ecommerce/public/cart.php" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>