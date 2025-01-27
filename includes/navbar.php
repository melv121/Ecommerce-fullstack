<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <span class="navbar-brand">Fishing-Store</span>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/ecommerce/index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/ecommerce/public/products.php">Produits</a>
            </li>
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown">
                    Administration
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/ecommerce/admin/users.php">Gestion des utilisateurs</a>
                    <a class="dropdown-item" href="/ecommerce/admin/">Tableau de bord</a>
                </div>
            </li>
            <?php endif; ?>
        </ul>

        
        <form class="form-inline my-2 my-lg-0 mr-3">
            <div class="input-group">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                <input class="form-control" type="search" placeholder="Rechercher..." aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/ecommerce/views/pages/cart.php">
                        <i class="fas fa-shopping-cart"></i> Cart <span class="cart-count"><?php echo isset($_SESSION['cartItems']) ? count($_SESSION['cartItems']) : 0; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <span class="nav-link">
                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ecommerce/public/logout.php">Déconnexion</a>
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
</nav>