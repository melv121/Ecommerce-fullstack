<?php
session_start();

// Vérifier si l'utilisateur est connecté et est admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /ecommerce/public/login.php');
    exit();
}

require_once __DIR__ . '/../includes/database.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Tableau de bord administrateur</h1>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gestion des utilisateurs</h5>
                        <p class="card-text">Gérer les comptes utilisateurs</p>
                        <a href="/ecommerce/admin/users.php" class="btn btn-primary">Gérer les utilisateurs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
