<?php
include "config.php";

$id = $_GET['id'];

$stmt = $conn->prepare("
DELETE FROM favorites
WHERE id = ?
");

$stmt->execute([$id]);

header("Location: favorites.php");
?>