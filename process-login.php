<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    // التأكد من صحة البيانات
    if ($user && $password == $user['password']) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        // التوجيه بناءً على الرتبة
        if ($_SESSION['role'] == 'admin') {
            // الأدمن يروح للوحة التحكم الخاصة فيه
            header('Location: admin/dashboardad.php');
        } else {
            // اليوزر العادي يروح لصفحة المنتجات (الهوم) فوراً
            header('Location: products.php');
        }
        exit;
        
    } else {
        // رسالة تنبيه في حال الخطأ
        echo "<script>
            alert('Wrong username or password');
            window.location.href='login.php';
        </script>";
    }
}
?>