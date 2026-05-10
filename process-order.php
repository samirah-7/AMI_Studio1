<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['customer_name'];
    $total = $_POST['total_price'];
    $details = $_POST['order_details'];

    try {
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, total_price, order_details) VALUES (?, ?, ?)");
        $stmt->execute([$name, $total, $details]);
        $order_id = $pdo->lastInsertId();

        $phone = "966579810446"; 
        $message = "مرحباً Ami Studio ✨%0A";
        $message .= "طلب جديد رقم: *" . $order_id . "*%0A";
        $message .= "الاسم: " . $name . "%0A";
        $message .= "الطلبات: " . $details . "%0A";
        $message .= "الإجمالي: " . $total . " SAR";

        header("Location: https://wa.me/$phone?text=$message");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>