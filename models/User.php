<?php
require_once __DIR__ . '/../includes/database.php';

class User {
    public static function getById($id) {
        $db = (new Database())->getConnection();
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            error_log("Error executing query: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public static function getAll() {
        $db = (new Database())->getConnection();
        $query = "SELECT id, username, email, role FROM users";
        $stmt = $db->query($query);
        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            error_log("Error executing query: " . implode(", ", $db->errorInfo()));
            return false;
        }
    }

    public static function delete($id) {
        $db = (new Database())->getConnection();
        $query = "DELETE FROM users WHERE id = :id AND role != 'admin'";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error executing query: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public static function updateRole($id, $role) {
        $db = (new Database())->getConnection();
        $query = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':role', $role);
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error executing query: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }
}
?>
