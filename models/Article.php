<?php
require_once __DIR__ . '/../includes/database.php';

class Article {
    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM articles";
        $result = $conn->query($sql);
        $articles = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $articles[] = $row;
            }
        }
        return $articles;
    }
}
?>
