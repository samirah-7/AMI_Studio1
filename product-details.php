<?php
include "config.php";

if (!isset($_GET['id'])) {
    die("Product ID is missing.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);

$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}
?>

<h1><?= $product['name']; ?></h1>

<img src="images/<?= $product['image']; ?>" width="200">

<p>Price: <?= $product['price']; ?> SAR</p>
<p><?= $product['description']; ?></p>

<button onclick="addToCart('<?= $product['id']; ?>', '<?= $product['name']; ?>', '<?= $product['price']; ?>')">
    Add to Cart 🛒
</button>

<script src="js/cart.js"></script>
