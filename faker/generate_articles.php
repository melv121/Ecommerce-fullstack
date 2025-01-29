<?php
require_once __DIR__ . '/../vendor/autoload.php';  // Correction du chemin

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialisation de Faker
$faker = Faker\Factory::create('fr_FR');

// Récupérer les IDs des catégories existantes
$sql = "SELECT id FROM categories";
$result = $conn->query($sql);
$categories = [];
while($row = $result->fetch_assoc()) {
    $categories[] = $row['id'];
}

// Générer 30 articles aléatoires
for ($i = 0; $i < 30; $i++) {
    $name = $faker->words(3, true);
    $description = $faker->paragraph(2);
    $price = $faker->randomFloat(2, 10, 500);
    $stock = $faker->numberBetween(5, 100);
    $image = $faker->imageUrl(640, 480, 'product');
    $category_id = $categories[array_rand($categories)];

    $sql = "INSERT INTO articles (name, description, price, stock, image, category_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdiis", $name, $description, $price, $stock, $image, $category_id);
    $stmt->execute();
}

echo "30 articles ont été générés avec succès!";
$conn->close();
?>
