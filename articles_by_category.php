<?php
require_once __DIR__ . '/vendor/autoload.php';

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category_id = $_GET['category_id'] ?? 1; 

$sql = "SELECT * FROM articles WHERE category_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

$articles = [];
while ($row = $result->fetch_assoc()) {
    $articles[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles par Catégorie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
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
    <div class="container mt-5">
        <h1>Articles de la Catégorie <?php echo htmlspecialchars($category_id); ?></h1>
        <div class="row">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($article['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($article['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($article['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($article['description']); ?></p>
                                <p class="card-text"><strong><?php echo htmlspecialchars($article['price']); ?> €</strong></p>
                                <form action="add_to_cart.php" method="post">
                                    <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['id']); ?>">
                                    <input type="hidden" name="redirect_to_cart" value="1">
                                    <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>Aucun article trouvé pour cette catégorie.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
