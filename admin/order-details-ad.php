<?php
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$userId = $_SESSION['user_id'];



$stmt = $pdo->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmt->execute([$orderId]);
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>order details #<?= $orderId ?></title>
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

<h1></h1>
<div class="divo">
    <h1>order details #<?= $orderId ?></h1>
    <p><strong>date:</strong> <?= $order['order_date'] ?></p>
    <p><strong>total:</strong> <?= $order['total'] ?> SAR</p>
    <p><strong>status:</strong> <?= $order['status'] ?></p>

    <h2>products</h2>
    <table border="1">
        <tr>
            <th>product</th>
            <th>quantity</th>
            <th>price</th>
            <th>total</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= $item['price'] ?> SAR</td>
            <td><?= $item['quantity'] * $item['price'] ?> SAR</td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="ordersuse.php">Back to My Orders</a>
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