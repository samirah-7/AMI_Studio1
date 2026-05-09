<?php
include "config.php";

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<script>
let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];

if (cart.length > 0) {

    fetch("save-cart-backend.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(cart)
    }).then(() => {
        localStorage.removeItem('ami_cart');
        window.location.href = "products.php";
    });

} else {
    window.location.href = "products.php";
}
</script>