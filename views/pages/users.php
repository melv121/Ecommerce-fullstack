<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/database.php';

// Check if this is an AJAX request
$isAjax = !empty($_SERVER['HTTP-X-REQUESTED-WITH']) && 
          strtolower($_SERVER['HTTP-X-REQUESTED-WITH']) == 'xmlhttprequest';

// If not AJAX and not included, include layout
if (!$isAjax && !defined('INCLUDED')) {
    include_once __DIR__ . '/../layout.php';
    exit();
}

try {
    // Verify database connection
    if (!$conn || $conn->connect_error) {
        throw new Exception("Connection failed: " . ($conn ? $conn->connect_error : "Connection is null"));
    }

    // Fetch users
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
?>
<section id="users" class="container mt-5">
    <h2>Gestion des utilisateurs</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<?php
    echo "<!-- Debug: users.php loaded -->";
} catch (Exception $e) {
    error_log($e->getMessage());
    echo '<div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer plus tard.</div>';
} finally {
    // Clean up
    if (isset($conn) && $conn) $conn->close();
}
?>
