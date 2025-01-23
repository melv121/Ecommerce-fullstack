<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/ecommerce/admin/">Administration</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/ecommerce/admin/users.php">Utilisateurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/ecommerce/">Retour au site</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <span class="nav-link">
                    <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>
                </span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/ecommerce/public/logout.php">Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>
