<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require_once '../config.php';

$stmt = $pdo->query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.order_date DESC");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
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
<div class="divo1">

    <h1>All Orders</h1>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Date</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['username'] ?></td>
            <td><?= $order['order_date'] ?></td>
            <td><?= $order['total'] ?> SAR</td>
            <td><?= $order['status'] ?>         
    <form method="GET" action="update-order-status.php" style="display:inline;">
        <input type="hidden" name="id" value="<?= $order['id'] ?>">
        <select name="status" onchange="this.form.submit()">
            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>pending</option>
            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>processing</option>
            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>shipped</option>
            <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>delivered</option>
            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>cancelled</option>
        </select>
    </form>
</td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="dashboardad.php">Back to the menu</a>
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