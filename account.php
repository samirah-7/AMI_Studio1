<?php
require_once 'config.php';

// إذا لم يكن مسجل الدخول، اذهب إلى صفحة تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// إذا كان مسجلاً، وجه حسب الدور
if ($_SESSION['role'] === 'admin') {
    header('Location: admin/dashboardad.php');
} else {
    header('Location: user/dashboarduse.php');
}
exit;
?>