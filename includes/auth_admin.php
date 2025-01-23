<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: /ecommerce/public/login.php');
    exit;
}

require_once __DIR__ . '/../models/User.php';

$user = User::getById($_SESSION['user_id']);
if (!$user || $user['role'] !== 'admin') {
    header('Location: /ecommerce/index.php');
    exit;
}
?>
