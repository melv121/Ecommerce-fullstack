<?php
require_once __DIR__ . '/../models/User.php';

function getAllUsers() {
    return User::getAll();
}

function deleteUser($userId) {
    return User::delete($userId);
}

function changeUserRole($userId, $newRole) {
    if (!in_array($newRole, ['user', 'admin'])) {
        return false;
    }
    return User::updateRole($userId, $newRole);
}
?>
