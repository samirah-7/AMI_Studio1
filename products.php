<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css?v=1.7">
    <title>Products - Ami Studio</title>
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
            <li><a href="favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>

<?php
include "config.php";

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<div class="prodiv">
    <h1>Our Products 🧶</h1>

    <?php foreach($products as $row) { ?>
        <div class="smdivpro">
            <div class="card-img-container">
                <img src="DateBase/<?php echo $row['image_url']; ?>" alt="<?= $row['name']; ?>" class="pro-img">
                
                <form action="add_favorite.php" method="POST" class="fav-form">
                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                    <button type="submit" class="fav-heart-btn">🩷</button>
                </form>
            </div>

            <h3><?= $row['name']; ?></h3>
            <p class="price-tag"><?= $row['price']; ?> SAR</p>

            <a href="product-details.php?id=<?= $row['id']; ?>" class="view-link">
                View Details ✨
            </a>
        </div>
    <?php } ?>
</div>

<footer class="footer">
    <p class="background">Follow us:</p>
    <a href="https://www.instagram.com/ami.studi0?igsh=MTFrbW82OGp5ZnBydQ==">INSTAGRAM - </a>
    <a href="https://www.tiktok.com/@ami.studi0?_r=1&_t=ZS-96AJUvVID2O">TIKTOK - </a>
    <a href="https://wa.me/+966579810446">WHATSAPP</a>
    <p class="background">@2026 AMI-STUDIO</p>
</footer>

</body>
</html>