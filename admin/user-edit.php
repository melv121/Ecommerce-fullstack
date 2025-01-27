<?php
require_once __DIR__ . '/../includes/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);

        $sql = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':role' => $role,
            ':id' => $id
        ]);

        header('Location: users.php');
        exit;
    }

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Utilisateur non trouvé");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    
    <div class="container mt-4">
        <h1>Modifier l'utilisateur</h1>
        
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            
            <div class="form-group">
                <label>Nom d'utilisateur</label>
                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Rôle</label>
                <select class="form-control" name="role">
                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="users.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
<?php
} catch (Exception $e) {
    error_log($e->getMessage());
    echo '<div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer plus tard.</div>';
}
?>
