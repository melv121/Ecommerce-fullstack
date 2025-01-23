<?php
session_start();
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php'; // Corrected path to the functions file
require_once __DIR__ . '/../controllers/ProductController.php'; // Inclure le ProductController

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $productId = intval($_POST['product_id']);
        $product = getProductById($productId);

        if ($product) {
            if (isset($_POST['remove'])) {
                // Logique pour supprimer un article du panier
                if (isset($_SESSION['cartItems'])) {
                    foreach ($_SESSION['cartItems'] as $key => $item) {
                        if ($item['id'] === $productId) {
                            unset($_SESSION['cartItems'][$key]);
                            break;
                        }
                    }
                    // Réindexer le tableau pour éviter les trous dans les clés
                    $_SESSION['cartItems'] = array_values($_SESSION['cartItems']);
                }
            } else {
                $quantity = 1; // Par défaut, ajouter une quantité de 1

                // Ajouter la clé 'is_promotion' et 'original_price' si elles n'existent pas
                if (!isset($product['is_promotion'])) {
                    $product['is_promotion'] = !empty($product['promotion_price']) && 
                        isset($product['promotion_start']) && 
                        isset($product['promotion_end']) && 
                        strtotime($product['promotion_start']) <= time() && 
                        strtotime($product['promotion_end']) >= time();
                }
                if ($product['is_promotion']) {
                    if (!isset($product['original_price'])) {
                        $product['original_price'] = $product['price'];
                    }
                    $product['price'] = $product['promotion_price'];
                }

                // Ajouter le produit au panier
                if (!isset($_SESSION['cartItems'])) {
                    $_SESSION['cartItems'] = [];
                }

                // Vérifier si le produit est déjà dans le panier
                $found = false;
                foreach ($_SESSION['cartItems'] as &$item) {
                    if ($item['id'] === $productId) {
                        $item['quantity'] += $quantity;
                        $found = true;
                        break;
                    }
                }

                // Si le produit n'est pas dans le panier, l'ajouter
                if (!$found) {
                    $product['quantity'] = $quantity;
                    $_SESSION['cartItems'][] = $product;
                }

                // Si la requête est AJAX, retourner le nombre d'articles dans le panier
                if (isset($_POST['ajax']) && $_POST['ajax'] == '1') {
                    echo count($_SESSION['cartItems']);
                    exit;
                }
            }
        } else {
            echo "Produit non trouvé.";
        }
    }

    // Rediriger vers la page du panier
    header('Location: /ecommerce/views/pages/cart.php');
    exit;
}

$cart = $_SESSION['cartItems'] ?? [];
$products = [];

foreach ($cart as $item) {
    $product = getProductById($item['id']);
    if ($product) {
        $products[] = $product;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Fishing-Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <main class="container mt-5">
        <h2>Your Cart</h2>
        <?php if (empty($products)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="card-text">Price: $<?php echo number_format($product['price'], 2); ?></p>
                                <form action="/ecommerce/public/remove_from_cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

