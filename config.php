
<?php
session_start();

$host = 'localhost';
$dbname = 'ami_studi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    $debug = true;
    if($debug) {
        echo " Connection successful! Database connected.<br>";
    }   
} catch(PDOException $e) {
    echo " Connection failed: " . $e->getMessage();
    die();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// function getCurrentUser() {
//     return $_SESSION['user_name'] ?? null;
// }

?>
