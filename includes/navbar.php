<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/ecommerce/index.php">Fishop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/ecommerce/index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ecommerce/products.php">Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ecommerce/public/cart.php">Panier</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if(isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <span class="nav-link">Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ecommerce/logout.php">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ecommerce/public/login.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ecommerce/public/register.php">Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>