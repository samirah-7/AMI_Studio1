<?php
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: productad.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: productad.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $featured = isset($_POST['featured']) ? 1 : 0;
 
    $image_url = $product['image_url'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
            if (!empty($product['image_url']) && file_exists('../' . $product['image_url'])) {
                unlink('../' . $product['image_url']);
            }
            $image_url = 'uploads/' . $imageName;
        }
    }
    
    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, category = ?, description = ?, stock = ?, featured = ?, image_url = ? WHERE id = ?");
    $stmt->execute([$name, $price, $category, $description, $stock, $featured, $image_url, $id]);
    
    header('Location: productad.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
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
    <h1>Edit Product: <?= htmlspecialchars($product['name']) ?></h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Price (SAR):</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
        </div>
        <div class="form-group">
            <label>Category:</label>
            <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>">
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Stock:</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>">
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="featured" value="1" <?= $product['featured'] ? 'checked' : '' ?>>
                Featured Product
            </label>
        </div>
        <div class="form-group">
            <label>Current Image:</label>
            <?php if (!empty($product['image_url'])): ?>
                <img src="../<?= $product['image_url'] ?>" width="100">
            <?php else: ?>
                No image available
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Change Image:</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit">Save Changes</button>
        <a href="productad.php">Cancel</a>
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