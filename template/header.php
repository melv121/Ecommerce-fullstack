<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCommerce</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/ecommerce">eCommerce</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/ecommerce">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ecommerce/products.php">Produits</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <?php if(isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <span class="nav-link">
                                <i class="fas fa-user"></i> 
                                Bonjour, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/ecommerce/cart.php">
                                <i class="fas fa-shopping-cart"></i> Panier
                            </a>
                        </li>
                        <?php if($_SESSION['user']['is_admin'] == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/ecommerce/admin/dashboard.php">Admin</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/ecommerce/logout.php">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/ecommerce/login.php">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
