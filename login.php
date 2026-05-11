<?php
session_start();
?>


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <title>Login - Ami Studio</title>
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

<div class="logindiv" style="margin-top: 50px;">
    <h2 id="loginh2">Login</h2>
    <h3 id="loginh3">∘₊✧──────────────────────✧₊∘</h3>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: #ff4d6d; background: #fff0f3; padding: 10px; border-radius: 10px;">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </p>
    <?php endif; ?>

    <form action="process-login.php" method="POST" class="loginform">
        <input type="text" name="username" placeholder="Username" required class="loginin"><br><br>
        <input type="password" name="password" placeholder="Password" required class="loginin"><br><br>
        <button type="submit" class="loginbut" style="background-color: #ff8fa3; color: white; border: none; padding: 10px 30px; border-radius: 20px; cursor: pointer;">Login</button>
    </form>

    <p style="margin-top: 20px;">
        Don't have an account? 
        <a href="register.php" style="color: #ff8fa3; text-decoration: none; font-weight: bold;">Create Account</a>
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