<?php
include "config.php";

session_start(); // 🔥 مهم جدًا

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // البحث عن المستخدم
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    // التحقق
    if ($user && $password == $user['password']) {

        // 🔥 حفظ بيانات المستخدم
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // تحويل للصفحة الرئيسية
        header("Location: products.php");
        exit();

    } else {
        echo "<h3 style='color:red;'>❌ Wrong username or password</h3>";
        echo "<a href='login.php'>Try again</a>";
    }
}
?>