<?php
include 'includes/header.php';

$category = isset($_GET['cat']) ? $_GET['cat'] : '';

// Tableau des titres des catégories
$categoryTitles = [
    'electronics' => 'Électronique',
    'clothing' => 'Vêtements',
    'books' => 'Livres',
    'sports' => 'Sports & Loisirs'
];

$categoryTitle = isset($categoryTitles[$category]) ? $categoryTitles[$category] : 'Catégorie non trouvée';
?>

<div class="container mt-4">
    <h2 class="text-center mb-4"><?php echo $categoryTitle; ?></h2>
    <div class="row">
        <!-- Ici vous pouvez ajouter votre logique pour afficher les produits de la catégorie -->
        <div class="col-12">
            <p class="text-center">Les produits de cette catégorie seront affichés ici.</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
