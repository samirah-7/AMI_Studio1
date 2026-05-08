<?php
include "config.php";

$user_id = 1;

$product_id = $_POST['product_id'];

$stmt = $conn->prepare("
INSERT INTO favorites (user_id, product_id)
VALUES (?, ?)
");

$stmt->execute([$user_id, $product_id]);

header("Location: products.php");
?>