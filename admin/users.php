<?php
require_once __DIR__ . '/../includes/database.php';

try {
    // Créer une instance de la classe Database
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
        throw new Exception("Connection failed: Database connection is null");
    }

    // Fetch users
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt;

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Gestion des utilisateurs</h1>
        
        <div class="mb-3">
            <a href="user-add.php" class="btn btn-success">Ajouter un utilisateur</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <a href="user-edit.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">Modifier</a>
                            <a href="user-delete.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
} catch (Exception $e) {
    error_log($e->getMessage());
    echo '<div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer plus tard.</div>';
} finally {
    // Clean up - No need to close connection with PDO
    $conn = null;
}
?>
