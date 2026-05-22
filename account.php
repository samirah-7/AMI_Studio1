<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


if ($_SESSION['role'] === 'admin') {
    header('Location: admin/dashboardad.php');
} else {
    header('Location: user/dashboarduse.php');
}
exit;
?>