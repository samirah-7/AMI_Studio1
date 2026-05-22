<?php
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>orders</title>
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
<div class="divo1"> 
    <h1>Product Manager</h1>
    <br><a href="product-add.php">Add Product</a><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price (SAR)</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td>
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="../<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= number_format($product['price'], 2) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td><?= $product['stock'] ?></td>
                    <td><?= $product['featured'] ? 'yes' : 'no' ?></td>
                    <td class="actions">
                        <a href="product-edit.php?id=<?= $product['id'] ?>">Edit</a>
                        |
                        <a href="product-delete.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure ?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8"> No products found.</td>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="dashboardad.php">Back</a>
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