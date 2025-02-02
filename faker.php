<?php

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ecommerce', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert users
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
    for ($i = 0; $i < 50; $i++) { 
        $stmt->execute([
            ':username' => $faker->userName,
            ':email' => $faker->email,
            ':password' => password_hash('password', PASSWORD_BCRYPT),
            ':role' => $faker->randomElement(['admin', 'user']),
        ]);
    }

  
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
    $categories = ['Électronique', 'Livres', 'Vêtements', 'Jouets', 'Maison', 'Jardin'];
    foreach ($categories as $category) { 
        $stmt->execute([':name' => $category]);
    }

    
    $stmt = $pdo->prepare("INSERT INTO articles (name, description, price, stock, image, category_id) VALUES (:name, :description, :price, :stock, :image, :category_id)");
    for ($i = 0; $i < 100; $i++) { 
        $stmt->execute([
            ':name' => $faker->word,
            ':description' => $faker->sentence,
            ':price' => $faker->randomFloat(2, 10, 1000),
            ':stock' => $faker->numberBetween(0, 100),
            ':image' => $faker->imageUrl(640, 480, 'technics'),
            ':category_id' => $faker->numberBetween(1, 6), 
        ]);
    }

    
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, status, total_price) VALUES (:user_id, :status, :total_price)");
    for ($i = 0; $i < 50; $i++) { 
        $stmt->execute([
            ':user_id' => $faker->numberBetween(1, 50), // Adjust user_id range
            ':status' => $faker->randomElement(['pending', 'completed', 'cancelled']),
            ':total_price' => $faker->randomFloat(2, 10, 1000),
        ]);
    }

    
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, article_id, quantity, price) VALUES (:order_id, :article_id, :quantity, :price)");
    for ($i = 0; $i < 200; $i++) { 
        $stmt->execute([
            ':order_id' => $faker->numberBetween(1, 50), 
            ':article_id' => $faker->numberBetween(1, 100),
            ':quantity' => $faker->numberBetween(1, 5),
            ':price' => $faker->randomFloat(2, 10, 1000),
        ]);
    }

    echo "Data inserted successfully\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
