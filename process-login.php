<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if ($user && $password == $user['password']) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        if ($_SESSION['role'] == 'admin') {
        header('Location: admin/dashboardad.php');
    } else {
        header('Location: user/dashboarduse.php');
    }
    exit;

        header("Location: products.php");
        exit();
        
    } else {
        echo "<script>
            alert('Wrong username or password');
            window.location.href='login.php';
        </script>";
    }
}
?>
