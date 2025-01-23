<ul class="navbar-nav ml-auto">
    <?php if(isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1): ?>
        <li class="nav-item">
            <a class="nav-link" href="admin/dashboard.php">Admin</a>
        </li>
    <?php endif; ?>
</ul>
