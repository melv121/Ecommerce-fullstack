
<div class="card-body">
    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
    <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
    <?php if (!empty($product['reduction']) && 
              $product['promotion_start'] <= date('Y-m-d') && 
              $product['promotion_end'] >= date('Y-m-d')): ?>
        <p class="card-text">
            <del class="text-danger"><?= number_format($product['price'], 2) ?> €</del>
            <strong class="text-success">
                <?= number_format($product['price'] * (1 - $product['reduction']/100), 2) ?> €
            </strong>
            <span class="badge badge-danger">-<?= $product['reduction'] ?>%</span>
        </p>
    <?php else: ?>
        <p class="card-text">Prix: <?php echo number_format($product['price'], 2); ?> €</p>
    <?php endif; ?>
    
</div>
