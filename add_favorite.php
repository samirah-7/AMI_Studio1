<?php
// 1. ربط قاعدة البيانات
include "config.php";

// 2. تحديد رقم المستخدم (ثابت حالياً للتجربة كما في الداتابيز عندك)
$user_id = 1;

// 3. التأكد من أن product_id تم إرساله من الصفحة السابقة
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    try {
        // 4. كتابة أمر الإدخال في جدول favorites (بالجمع)
        // استخدمنا INSERT IGNORE عشان لو المنتج مضاف قبل كذا ما يطلّع خطأ ولا يكرره
        $stmt = $pdo->prepare("
            INSERT IGNORE INTO favorites (user_id, product_id)
            VALUES (?, ?)
        ");

        // 5. تنفيذ الأمر
        $stmt->execute([$user_id, $product_id]);

        // 6. التحويل فوراً لصفحة المفضلة بعد النجاح
        header("Location: favorites.php");
        exit();

    } catch (PDOException $e) {
        // في حال وجود خطأ في الداتابيز يطبع لنا وش المشكلة
        die("خطأ في قاعدة البيانات: " . $e->getMessage());
    }

} else {
    // لو دخلتِ الصفحة هذي بدون ضغط زر القلب يرجعك للمنتجات
    header("Location: products.php");
    exit();
}
?>