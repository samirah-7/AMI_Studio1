<?php
include "config.php";

// رقم المستخدم (تأكدي أنه 1 زي ما جربنا في الداتابيز)
$user_id = 1;

// استخدمنا $pdo بدلاً من $conn عشان يختفي الخطأ
$stmt = $pdo->prepare("
    SELECT favorites.id AS fav_id, products.* FROM favorites 
    JOIN products ON favorites.product_id = products.id 
    WHERE favorites.user_id = ?
");

$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
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

<h1>Your Favorites ❤️</h1>

<div class="prodiv">
    <?php
    if(count($favorites) > 0){
        foreach($favorites as $fav){
    ?>
        <div class="smdivpro">
            <div class="card-img-container">
                <img src="DateBase/<?= $fav['image_url']; ?>" class="pro-img">
            </div>

            <h3><?= $fav['name']; ?></h3>
            <p class="price-tag"><?= $fav['price']; ?> SAR</p>

            <a href="remove_favorite.php?id=<?= $fav['fav_id']; ?>" class="view-link" style="background-color: #ff4d4d;">
                Remove ❌
            </a>
        </div>
    <?php
        }
    } else {
        echo "<p style='grid-column: 1/-1;'>No favorites yet 💔</p>";
    }
    ?>
</div>

<?php
}

}else{
  echo "<p>No favorites yet 💔</p>";
}
?>

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