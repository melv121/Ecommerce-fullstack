<?php
require_once('config/database.php');

// Pagination logic
$limit = 12; // Number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Category filter
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// Search filter
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch products with limit, offset, category, and search filters
$sql = "SELECT * FROM articles WHERE 1";
if ($category_id > 0) {
    $sql .= " AND category_id = $category_id";
}
if (!empty($search)) {
    $sql .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
}
$sql .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Fetch total number of products
$total_sql = "SELECT COUNT(*) FROM articles WHERE 1";
if ($category_id > 0) {
    $total_sql .= " AND category_id = $category_id";
}
if (!empty($search)) {
    $total_sql .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
}
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_articles = $total_row[0];
$total_pages = ceil($total_articles / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'template/header.php'; ?>
</head>
<body>
    <div class="container mt-4">
        <!-- Category filter and search form -->
        <form method="GET" action="products.php" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="category_id" class="form-control">
                        <option value="0">Toutes les catégories</option>
                        <?php
                        $categories_sql = "SELECT * FROM categories";
                        $categories_result = $conn->query($categories_sql);
                        while ($category = $categories_result->fetch_assoc()): ?>
                            <option value="<?php echo $category['id']; ?>" <?php if ($category_id == $category['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </div>
        </form>

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
        
        <!-- Pagination arrows and numbers -->
        <div class="pagination">
            <?php if($page > 1): ?>
                <a href="?page=1&category_id=<?php echo $category_id; ?>&search=<?php echo htmlspecialchars($search); ?>" class="arrow">&laquo; Premier</a>
                <a href="?page=<?php echo $page - 1; ?>&category_id=<?php echo $category_id; ?>&search=<?php echo htmlspecialchars($search); ?>" class="arrow">Précédent</a>
            <?php endif; ?>

            <?php
            // Affichage des numéros de page
            $start = max(1, $page - 2);
            $end = min($total_pages, $page + 2);

            for($i = $start; $i <= $end; $i++): ?>
                <a href="?page=<?php echo $i; ?>&category_id=<?php echo $category_id; ?>&search=<?php echo htmlspecialchars($search); ?>" 
                   class="page-number <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&category_id=<?php echo $category_id; ?>&search=<?php echo htmlspecialchars($search); ?>" class="arrow">Suivant</a>
                <a href="?page=<?php echo $total_pages; ?>&category_id=<?php echo $category_id; ?>&search=<?php echo htmlspecialchars($search); ?>" class="arrow">Dernier &raquo;</a>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'template/footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
