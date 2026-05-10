<?php
include "config.php";

if (!isLoggedIn()) {
    echo "<script>
    alert('يرجى تسجيل الدخول أولاً');
    window.location.href='login.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=1.9">
    <title>Ami Studio - Shopping Cart</title>
</head>
<body>

<header id="hed">
    <img src="./image/SanMilogo.png" id="logo" class="logp">
    <p class="logp">⊹₊˚‧︵‿₊୨ᰔ୧₊‿︵‧˚₊⊹</p>
    <p class="logp">a piece of art .✦ ݁˖</p>

    <nav>
        <ul>
            <li><a href="products.php">HOME</a></li>
            <li><a href="cart.php">CART</a></li>
            <li><a href="login.php">LOG IN</a></li>
            <li><a href="favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Your Shopping Cart 🛒</h1>
    <div id="cart-content"></div>

    <div class="checkout-section" id="checkout-form-container" style="display:none;">
        <h3>Order Confirmation ✨</h3>
        <form action="process-order.php" method="POST">
            <p>
                <label for="customer_name">Your Name:</label><br>
                <input type="text" id="customer_name" name="customer_name" placeholder="Enter your full name" required 
                       style="padding: 10px; border-radius: 10px; border: 1px solid #ddd; width: 80%; margin-top: 10px;">
            </p>
            <input type="hidden" id="hidden_total" name="total_price" value="">
            <input type="hidden" id="hidden_details" name="order_details" value="">
            <button type="submit" class="btn-order">Confirm & Order via WhatsApp 💬</button>
        </form>
    </div>
</div>

<script>
function displayCart() {
    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    let cartContent = document.getElementById('cart-content');
    let checkoutSection = document.getElementById('checkout-form-container');
    
    if (cart.length === 0) {
        cartContent.innerHTML = "<p>Your cart is empty. <a href='products.php'>Go shopping!</a></p>";
        checkoutSection.style.display = "none";
        return;
    }

    checkoutSection.style.display = "block";

    let tableHTML = `<table><thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr></thead><tbody>`;
    let grandTotal = 0;
    let detailsString = "";

    cart.forEach((item, index) => {
        let itemTotal = item.price * item.quantity;
        grandTotal += itemTotal;
        detailsString += `${item.name} (x${item.quantity}), `;
        tableHTML += `<tr><td>${item.name}</td><td>${item.price} SAR</td><td>${item.quantity}</td><td>${itemTotal} SAR</td><td><button class="btn-remove" onclick="removeItem(${index})">Remove</button></td></tr>`;
    });

    tableHTML += `</tbody></table><div class="total-box">Grand Total: ${grandTotal} SAR</div>`;
    cartContent.innerHTML = tableHTML;
    document.getElementById('hidden_total').value = grandTotal;
    document.getElementById('hidden_details').value = detailsString;
}

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('ami_cart', JSON.stringify(cart));
    displayCart();
}
document.addEventListener('DOMContentLoaded', displayCart);
</script>

<footer class="footer">
    <p class="background">@2026 AMI-STUDIO</p>
</footer>

</body>
</html>