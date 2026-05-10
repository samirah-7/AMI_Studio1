<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. استقبال البيانات
    $name = $_POST['customer_name'];
    $total = $_POST['total_price'];
    $details = $_POST['order_details'];

    try {
        // 2. تسجيل الطلب في جدول orders
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, total_price, order_details) VALUES (?, ?, ?)");
        $stmt->execute([$name, $total, $details]);

        // 3. الحصول على رقم الطلب
        $order_id = $pdo->lastInsertId();

        // 4. رقم الواتساب (بالصيغة الدولية وبدون + وبدون 0 في البداية)
        $phone = "966579810446"; 

        // 5. تجهيز الرسالة
        $message = "مرحباً Ami Studio ✨%0A";
        $message .= "أرغب في تأكيد طلبي رقم: *" . $order_id . "*%0A";
        $message .= "الاسم: " . $name . "%0A";
        $message .= "الطلبات: " . $details . "%0A";
        $message .= "الإجمالي: " . $total . " SAR";

        // 6. الانتقال المباشر للواتساب
        header("Location: https://wa.me/$phone?text=$message");
        exit();

    } catch (PDOException $e) {
        die("خطأ في قاعدة البيانات: " . $e->getMessage());
    }
}
?>