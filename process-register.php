<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
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
    <h2 id="loginh2">Create Account</h2>
    <h3 id="loginh3">∘₊✧──────────────────────✧₊∘</h3>

    <form action="process-register.php" method="POST" class="loginform">
        <input type="text" name="username" placeholder="Username" required class="loginin"><br><br>
        <input type="email" name="email" placeholder="Email" required class="loginin"><br><br>
        <input type="password" name="password" placeholder="Password" required class="loginin"><br><br>
        <button type="submit" class="loginbut">Register</button>
    </form>

    <p>
        Already have an account?
        <a href="login.php">Login</a>
    </p>
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
<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    
    $check = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $check->execute([$username]);

    if ($check->rowCount() > 0) {
        echo "<script>
            alert('اسم المستخدم موجود مسبقًا');
            window.location.href='register.php';
        </script>";
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");


    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$username, $email, $password]);

    echo "<script>
        alert('تم إنشاء الحساب بنجاح');
        window.location.href='login.php';
    </script>";
    exit();
}
?>

