<?php

include "config.php";

$user_id = 1;

if (isset($_POST['product_id'])) {

    try {

        $product_id = $_POST['product_id'];

        $stmt = $pdo->prepare("
            INSERT IGNORE INTO favorites (user_id, product_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$user_id, $product_id]);

        
        header("Location: favorites.php");
        exit();

    } catch (PDOException $e) {

        die("خطأ في قاعدة البيانات: " . $e->getMessage());
    }

} else {

    header("Location: products.php");
    exit();
}
?>
