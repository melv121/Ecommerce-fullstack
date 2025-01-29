<?php
require_once __DIR__ . '/../includes/database.php';

class Cart {
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM cart');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>