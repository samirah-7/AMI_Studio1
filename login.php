<?php
session_start();
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
            <li><a href="account.php">MY ACCOUNT</a></li>
            <li><a href="favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>

<h1></h1>
<div class="logindiv">
    <h2 id="loginh2">Login</h2>
    <h3 id="loginh3">∘₊✧──────────────────────✧₊∘</h3>

    <form action="process-login.php" method="POST" class="loginform">
        <input type="text" name="username" placeholder="Username" required class="loginin"><br><br>
        <input type="password" name="password" placeholder="Password" required class="loginin"><br><br>
        <button type="submit" class="loginbut">Login</button>
    </form>

    <p>
        Don't have an account?
        <a href="process-register.php">Create Account</a>
    </p>
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
