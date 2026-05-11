<?php
include "config.php";

// التحقق من تسجيل الدخول
if (!isLoggedIn()) {
    echo "<script>alert('يرجى تسجيل الدخول أولاً'); window.location.href='login.php';</script>";
    exit;
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=3.0">
    <title>Ami Studio - Shopping Cart</title>
</head>
<body>

<header id="hed">
    <img src="./image/SanMilogo.png" id="logo" class="logp">
    <nav>
        <ul>
            <li><a href="products.php">HOME</a></li>
            <li><a href="cart.php">CART 🛒</a></li>
            <li><a href="account.php">MY ACCOUNT</a></li>
            <li><a href="favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>

<div class="container" style="padding-top: 50px;">
    <h1 style="color: #ff8fa3; margin-bottom: 30px;">Your Shopping Cart 🛒</h1>
    
    <div id="cart-content"></div>

    <div class="checkout-section" id="checkout-form-container" style="display:none; background: #fffdfd; border: 2px dashed #ffb7c5; padding: 30px; border-radius: 20px; max-width: 600px; margin: 40px auto;">
        <h3 style="color: #ff8fa3; margin-bottom: 20px;">Order Confirmation ✨</h3>
        <form action="process-order.php" method="POST">
            <p>
                <label for="customer_name" style="font-weight: bold; color: #555;">Your Name:</label><br>
                <input type="text" id="customer_name" name="customer_name" placeholder="Enter your full name" required 
                       style="padding: 12px; border-radius: 10px; border: 1px solid #ffb7c5; width: 90%; margin-top: 10px;">
            </p>
            <p style="margin-top: 15px;">
                <label for="city" style="font-weight: bold; color: #555;">City (المدينة):</label><br>
                <input type="text" id="city" name="city" placeholder="e.g. Al-Baha / Jeddah" required 
                       style="padding: 12px; border-radius: 10px; border: 1px solid #ffb7c5; width: 90%; margin-top: 10px;">
            </p>
            <p style="margin-top: 15px;">
                <label for="redbox_point" style="font-weight: bold; color: #555;">RedBox Point (اختياري):</label><br>
                <input type="text" id="redbox_point" name="redbox_point" placeholder="اسم أقرب خزنة ريدبوكس" 
                       style="padding: 12px; border-radius: 10px; border: 1px solid #ffb7c5; width: 90%; margin-top: 10px;">
            </p>

            <input type="hidden" id="hidden_total" name="total_price" value="">
            <input type="hidden" id="hidden_details" name="order_details" value="">
            <input type="hidden" id="cart_json" name="cart_json">

            <button type="submit" class="btn-order" style="background: #28a745; margin-top: 30px; width: 100%; font-size: 1.1em; padding: 15px;">
                Confirm & Order via WhatsApp 💬
            </button>
        </form>
    </div>
</div>

<script>
function displayCart() {
    const urlParams = new URLSearchParams(window.location.search);
    
    // حالة نجاح الطلب
    if (urlParams.get('status') === 'success') {
        localStorage.removeItem('ami_cart'); // مسح السلة فوراً
        let cartContent = document.getElementById('cart-content');
        let checkoutSection = document.getElementById('checkout-form-container');
        
        cartContent.innerHTML = `
            <div style="text-align: center; padding: 50px; background: #fff5f7; border-radius: 20px; border: 2px dashed #ffb7c5; margin-top: 20px;">
                <h2 style="color: #ff8fa3;">Thank You! 🎀</h2>
                <p style="font-size: 1.2em; color: #555; margin: 15px 0;">Your order has been placed successfully.</p>
                <p style="color: #888;">Redirecting to WhatsApp to complete your order...</p>
                <br>
                <a href="products.php" class="btn-order" style="text-decoration: none; padding: 12px 30px; display: inline-block; background: #ff8fa3;">Back to Shop 🧶</a>
            </div>
        `;
        if(checkoutSection) checkoutSection.style.display = "none";

        const waLink = urlParams.get('wa');
        if (waLink) {
            setTimeout(() => {
                window.location.href = decodeURIComponent(waLink);
            }, 1500);
        }
        return;
    }

    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    let cartContent = document.getElementById('cart-content');
    let checkoutSection = document.getElementById('checkout-form-container');
    
    if (cart.length === 0) {
        cartContent.innerHTML = `
            <div style="padding: 50px; text-align: center;">
                <p style="font-size: 1.3em; color: #777;">Your cart is empty. 🧶</p>
                <br>
                <a href="products.php" style="color: #ff8fa3; font-weight: bold; text-decoration: none; border-bottom: 2px solid;">Go shopping!</a>
            </div>
        `;
        checkoutSection.style.display = "none";
        return;
    }

    checkoutSection.style.display = "block";
    let tableHTML = `
        <div style="overflow-x:auto;">
            <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <thead style="background: #ff8fa3; color: white;">
                    <tr>
                        <th style="padding: 15px;">Product</th>
                        <th style="padding: 15px;">Price</th>
                        <th style="padding: 15px;">Qty</th>
                        <th style="padding: 15px;">Total</th>
                        <th style="padding: 15px;">Action</th>
                    </tr>
                </thead>
                <tbody>`;
    
    let grandTotal = 0;
    let detailsString = "";

    cart.forEach((item, index) => {
        let itemTotal = item.price * item.quantity;
        grandTotal += itemTotal;
        detailsString += `${item.name} (x${item.quantity}), `;
        
        tableHTML += `
            <tr style="border-bottom: 1px solid #eee; text-align: center;">
                <td style="padding: 15px; font-weight: bold;">${item.name}</td>
                <td style="padding: 15px;">${item.price} SAR</td>
                <td style="padding: 15px;">${item.quantity}</td>
                <td style="padding: 15px; color: #ff4d6d; font-weight: bold;">${itemTotal} SAR</td>
                <td style="padding: 15px;">
                    <button class="btn-remove" onclick="removeItem(${index})" style="background: #ff4d6d; color: white; border: none; padding: 5px 12px; border-radius: 8px; cursor: pointer;">Remove</button>
                </td>
            </tr>`;
    });

    tableHTML += `
                </tbody>
            </table>
        </div>
        <div class="total-box" style="text-align: right; padding: 20px; font-size: 1.5em; color: #ff4d6d;">
            <strong>Grand Total: ${grandTotal} SAR</strong>
        </div>`;

    cartContent.innerHTML = tableHTML;
    
    // تحديث الحقول المخفية للنموذج
    document.getElementById('cart_json').value = JSON.stringify(cart);
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

<style>
    /* تنسيق إضافي لضمان جمال السلة */
    .container { max-width: 1000px; margin: 0 auto; }
    table th { font-family: 'Tajawal', sans-serif; }
    .btn-order:hover { background: #218838 !important; transform: scale(1.02); transition: 0.2s; }
</style>

</body>
</html>