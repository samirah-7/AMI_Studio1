<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
    <title>Products</title>
</head>
<body>

<header id="hed">
    <img src="./image/SanMilogo.png" id="logo" class="logp">
    <p class="logp">⊹₊˚‧︵‿₊୨ᰔ୧₊‿︵‧˚₊⊹</p>
    <p class="logp">a piece of art .✦ ݁˖</p>

    <nav>
        <ul>
            <li><a href="products.php">HOME</a></li>
            <li><a href="cart.php">CART</a></li>
            <li><a href="login.php">LOG IN</a></li>
            <li><a href="favorites.php">FAVEORET</a></li>
        </ul>
    </nav>
</header>

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
<div class="dprodiv">
<h1><?= $product['name']; ?></h1>

<img src="images/<?= $product['image']; ?>" width="200">

<p>Price: <?= $product['price']; ?> SAR</p>
<p><?= $product['description']; ?></p>

<button onclick="addToCart('<?= $product['id']; ?>', '<?= $product['name']; ?>', '<?= $product['price']; ?>')" class="addbut">
    Add to Cart 🛒
</button>
</div>
<script src="js/cart.js"></script>

<footer class="footer">
    <p class="background">Follow us:</p>
    <a href="https://www.instagram.com/ami.studi0?igsh=MTFrbW82OGp5ZnBydQ==">INSTAGRAM - </a>
    <a href="https://www.tiktok.com/@ami.studi0?_r=1&_t=ZS-96AJUvVID2O">TIKTOK - </a>
    <a href="https://wa.me/+966579810446">WHATSAPP</a>
    <p class="background">@2026 AMI-STUDIO</p>
</footer>

</body>
</html>