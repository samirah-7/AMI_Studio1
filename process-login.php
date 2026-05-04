<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if ($user && $password == $user['password']) {
        
        // ✅ Session
        $_SESSION['user_id'] = $user['id'];

        // ✅ بعد الدخول نحفظ الكارت
        header("Location: save-cart.php");
        exit();

    } else {
        echo "❌ Wrong username or password";
    }
}
?>