<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. استقبال البيانات من السلة
    $name = $_POST['customer_name'];
    $total = $_POST['total_price'];
    $details = $_POST['order_details'];

    try {
        // 2. تسجيل الطلب في جدول orders اللي أنشأتيه في الداتابيز
        // هذا السطر هو اللي بيولد "رقم الطلب" تلقائياً
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, total_price, order_details) VALUES (?, ?, ?)");
        $stmt->execute([$name, $total, $details]);

        // 3. الحصول على رقم الطلب اللي تم إنشاؤه الآن
        $order_id = $pdo->lastInsertId();

        // 4. تجهيز رسالة الواتساب الاحترافية لـ Ami Studio
        $phone = "966579810446"; // رقمك
        $message = "مرحباً Ami Studio ✨%0A";
        $message .= "لديك طلب جديد رقم: *" . $order_id . "*%0A";
        $message .= "باسم العميل: " . $name . "%0A";
        $message .= "تفاصيل المنتجات: " . $details . "%0A";
        $message .= "الإجمالي: " . $total . " SAR%0A";
        $message .= "يرجى الرد لتأكيد البدء في التنفيذ 🧶";

        // 5. توجيه العميل تلقائياً للواتساب مع الرسالة الجاهزة
        header("Location: https://wa.me/$phone?text=$message");
        exit();

    } catch (PDOException $e) {
        // في حال وجود خطأ في الداتابيز
        die("خطأ في تسجيل الطلب: " . $e->getMessage());
    }

} else {
    // لو أحد حاول يدخل الصفحة بدون طلب يرجعه للسلة
    header("Location: cart.php");
    exit();
}
?>