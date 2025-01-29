<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/check_admin.php';

// Configuration de la pagination
$articles_par_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $articles_par_page;

// Compter le nombre total d'articles
$total = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$nombre_de_pages = ceil($total / $articles_par_page);

// Récupérer les articles de la page courante
$sql = "SELECT * FROM articles ORDER BY id DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $articles_par_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Articles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-4">
        <h2>Gestion des Articles</h2>
        
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= $article['id'] ?></td>
                    <td><?= htmlspecialchars($article['name']) ?></td>
                    <td><?= number_format($article['price'], 2) ?> €</td>
                    <td><?= $article['stock'] ?? '0' ?></td>
                    <td><?= htmlspecialchars(substr($article['description'] ?? '', 0, 50)) ?>...</td>
                    <td>
                        <a href="edit_article.php?id=<?= $article['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Précédent</a>
                    </li>
                <?php endif; ?>

                <?php for($i = 1; $i <= $nombre_de_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if($page < $nombre_de_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
