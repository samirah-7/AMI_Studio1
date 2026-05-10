<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. استلام البيانات من الـ Form
    $name = $_POST['customer_name'];
    $city = $_POST['city'];
    // التأكد من اسم الحقل في الفورم (redbox_point)
    $redbox = !empty($_POST['redbox_point']) ? $_POST['redbox_point'] : 'غير محدد';
    $total = $_POST['total_price'];
    $details = $_POST['order_details'];

    try {
        // 2. تسجيل الطلب في قاعدة البيانات
        // قمنا بتحديد أسماء الأعمدة يدوياً لضمان الدقة وتجنب خطأ "Column count doesn't match"
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, city, redbox_point, total_price, order_details) VALUES (?, ?, ?, ?, ?)");
        
        // تنفيذ الإرسال
        $stmt->execute([$name, $city, $redbox, $total, $details]);
        
        // الحصول على رقم الطلب التلقائي
        $order_id = $pdo->lastInsertId();

        // 3. تجهيز بيانات الواتساب
        $phone = "966579810446"; 
        $message = "مرحباً Ami Studio ✨%0A";
        $message .= "طلب جديد رقم: *" . $order_id . "*%0A";
        $message .= "الاسم: " . $name . "%0A";
        $message .= "المدينة: " . $city . "%0A";
        $message .= "نقطة ريدبوكس: " . $redbox . "%0A";
        $message .= "الطلبات: " . $details . "%0A";
        $message .= "الإجمالي: " . $total . " SAR";

        // تجهيز الرابط
        $whatsapp_url = "https://wa.me/$phone?text=$message";

        // 4. التوجيه الذكي لصفحة السلة مع علامة النجاح ورابط الواتساب
        header("Location: cart.php?status=success&wa=" . urlencode($whatsapp_url));
        exit();

    } catch (PDOException $e) {
        // في حال وجود خطأ في الداتابيز، سيطبع لكِ السبب بدقة
        die("Database Error: " . $e->getMessage());
    }
}
?>