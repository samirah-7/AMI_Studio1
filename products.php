<?php
include "config.php";

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<h1>Products</h1>

<?php foreach($products as $row) { ?>

  <div>
    <h3><?= $row['name']; ?></h3>
    <p><?= $row['price']; ?> SAR</p>

    <a href="product-details.php?id=<?= $row['id']; ?>">
      View Details
    </a>
  </div>

<?php } ?>
