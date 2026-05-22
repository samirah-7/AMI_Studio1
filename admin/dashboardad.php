<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../user/dashboarduse.php');
    exit;
} 
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../user/dashboarduse.php');
    exit;
}?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin </title>
    <link rel="stylesheet" href="adstyle.css">
</head>
<body>
    
<header id="hed">
    <img src="../image/SanMilogo.png" id="logo" class="logp">
    <p class="logp">⊹₊˚‧︵‿₊୨ᰔ୧₊‿︵‧˚₊⊹</p>
    <p class="logp">a piece of art .✦ ݁˖</p>

    <nav>
        <ul>
            <li><a href="../products.php">HOME</a></li>
            <li><a href="../cart.php">CART</a></li>
            <li><a href="../account.php">MY ACCOUNT</a></li>
            <li><a href="../favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>
<div class="divo"> 
    <h1>Hello, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Admin Dashboard</h2>
<ul class="lulu">
    <li><a href="ordersuse.php">Manage Orders</a></li>
    <li><a href="users.php">Manage Users</a></li>
    <li><a href="productad.php">Manage Products</a></li>
    <li><a href="../logout.php">Logout</a></li>
</ul>
</div>
<footer class="footer">
    <p class="background">Follow us:</p>
    <a href="https://www.instagram.com/ami.studi0">INSTAGRAM - </a>
    <a href="https://www.tiktok.com/@ami.studi0">TIKTOK - </a>
    <a href="https://wa.me/+966579810446">WHATSAPP</a>
    <p class="background">@2026 AMI-STUDIO</p>
</footer>

</body>
</html>