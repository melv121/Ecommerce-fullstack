
<?php if (isset($_SESSION['username'])): ?>
    <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
<?php endif; ?>

