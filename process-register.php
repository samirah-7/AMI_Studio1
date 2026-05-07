<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1️⃣ نتأكد ما فيه مستخدم مكرر
    $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$username]);

    if ($check->fetch()) {
        die("Username already exists");
    }

    // 2️⃣ نحفظ المستخدم
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([$username, $email, $password]);

    // 3️⃣ نرجع للوجين
    header("Location: login.php");
    exit();
}
?>