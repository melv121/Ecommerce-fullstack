<?php
require_once __DIR__ . '/../includes/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
    if (!$id) {
        throw new Exception("ID utilisateur invalide");
    }

    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);

    header('Location: users.php');
    exit;
    
} catch (Exception $e) {
    error_log($e->getMessage());
    echo '<div class="alert alert-danger">Une erreur est survenue lors de la suppression.</div>';
    echo '<a href="users.php" class="btn btn-primary mt-3">Retour à la liste</a>';
}
?>
