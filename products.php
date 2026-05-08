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
            <li><a href="#">FAVEORET</a></li>
        </ul>
    </nav>
</header>

<?php
include "config.php";

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<div class="prodiv">
<h1>Products</h1>

<?php foreach($products as $row) { ?>

  <div class="smdivpro">
    <h3><?= $row['name']; ?></h3>
    <p><?= $row['price']; ?> SAR</p>

    <a href="product-details.php?id=<?= $row['id']; ?>" class="view-link">
      View Details
    </a>
  </div>
  <form action="add_favorite.php" method="POST">

  <input type="hidden" 
         name="product_id" 
         value="<?= $row['id']; ?>">

  <button type="submit" class="fav-btn">
    ❤️
  </button>

</form>

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