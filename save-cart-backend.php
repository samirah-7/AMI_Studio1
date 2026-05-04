<?php
include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];

foreach ($data as $item) {

    $stmt = $pdo->prepare("
        INSERT INTO cart (user_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $user_id,
        $item['id'],
        $item['quantity']
    ]);
}

echo "saved";
?>