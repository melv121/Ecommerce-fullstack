<?php
require_once('config/database.php');

// Récupération des articles
$sql = "SELECT * FROM articles";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'template/header.php'; ?>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php 
                        $image_path = "uploads/" . $row['image'];
                        if($row['image'] && file_exists($image_path)): ?>
                            <img src="<?php echo $image_path; ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($row['name']); ?>"
                                 style="height: 200px; object-fit: contain;">
                        <?php else: ?>
                            <img src="img/computer.jpg" 
                                 class="card-img-top" 
                                 alt="Image par défaut"
                                 style="height: 200px; object-fit: contain;">
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <?php if($row['reduction'] > 0): ?>
                                <p class="card-text">
                                    <del class="text-muted"><?php echo number_format($row['price'], 2); ?> €</del>
                                    <strong class="text-danger">
                                        <?php echo number_format($row['price'] * (1 - $row['reduction']/100), 2); ?> €
                                    </strong>
                                    <span class="badge badge-danger">-<?php echo $row['reduction']; ?>%</span>
                                </p>
                            <?php else: ?>
                                <p class="card-text"><strong><?php echo number_format($row['price'], 2); ?> €</strong></p>
                            <?php endif; ?>
                            <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
                                Ajouter au panier
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include 'template/footer.php'; ?>
</body>
</html>
