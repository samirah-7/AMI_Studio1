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
            <li><a href="login.php">LOG IN</a></li>
            <li><a href="favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>

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

</body>
</html>
