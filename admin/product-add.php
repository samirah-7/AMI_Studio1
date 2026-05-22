<?php
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : 0;
    $category = isset($_POST['category']) ? substr(trim($_POST['category']), 0, 20) : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $stock = isset($_POST['stock']) ? $_POST['stock'] : 0;
    $featured = isset($_POST['featured']) ? 1 : 0;

    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
            $image_url = 'uploads/' . $imageName;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, price, category, description, stock, featured, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($name, $price, $category, $description, $stock, $featured, $image_url));

    header('Location: productad.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../style.css">
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

<h1></h1>
<div class="divo">
    <h1>Add New Product</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required><br>
        <textarea name="description" placeholder="Product Description"></textarea><br>
        <input type="number" step="0.01" name="price" placeholder="Price" required><br>
        <input type="file" name="image"><br>
        <button type="submit">Add Product</button>
    </form>
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