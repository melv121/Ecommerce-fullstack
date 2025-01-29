<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

try {
    // Désactiver les contraintes
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

    // Vider la table articles
    $pdo->query("TRUNCATE TABLE articles");
    $pdo->query("TRUNCATE TABLE categories");

    // Insérer les catégories
    $categories = ['Smartphones', 'Ordinateurs', 'Accessoires', 'Jeux Vidéo', 'Audio'];
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    foreach ($categories as $category) {
        $stmt->execute([$category]);
    }

    // Préparer l'insertion des articles
    $stmt = $pdo->prepare("
        INSERT INTO articles (
            name, 
            description, 
            price, 
            stock,
            image,
            category_id,
            promotion_price,
            promotion_start,
            promotion_end,
            reduction
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // Générer 40 articles
    for ($i = 0; $i < 40; $i++) {
        $basePrice = $faker->randomFloat(2, 19.99, 1999.99);
        $hasPromotion = $faker->boolean(30); // 30% de chance d'avoir une promotion
        $reduction = $hasPromotion ? $faker->numberBetween(5, 50) : null;
        $promoPrice = $reduction ? $basePrice * (1 - $reduction/100) : null;

        $stmt->execute([
            $faker->unique()->words($faker->numberBetween(2, 4), true), // nom
            $faker->paragraph(2), // description
            $basePrice, // prix normal
            $faker->numberBetween(0, 100), // stock
            'article-' . $faker->numberBetween(1, 10) . '.jpg', // image
            $faker->numberBetween(1, count($categories)), // catégorie
            $promoPrice, // prix promotion
            $hasPromotion ? $faker->dateTimeBetween('now', '+1 week')->format('Y-m-d') : null,
            $hasPromotion ? $faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d') : null,
            $reduction
        ]);
    }

    // Réactiver les contraintes
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

    echo "Génération terminée avec succès!\n";
    echo "Catégories créées : " . implode(', ', $categories) . "\n";
    echo "40 articles ont été générés\n";

} catch (Exception $e) {
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    echo "Erreur : " . $e->getMessage() . "\n";
}
