<?php 



include "config.php";

if (isLoggedIn()) {

    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT products.name, products.price, cart.quantity
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = ?
    ");

    $stmt->execute([$user_id]);
    $cartItems = $stmt->fetchAll();
}













include "config.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ami Studio - Shopping Cart</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; }
        .checkout-section { margin-top: 30px; padding: 20px; border: 2px dashed #eee; border-radius: 10px; }
        .btn-remove { background-color: #ff4d4d; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 5px; }
        .btn-order { background-color: #28a745; color: white; border: none; padding: 10px 20px; cursor: pointer; font-size: 16px; border-radius: 5px; }
        .total-box { text-align: right; margin-top: 15px; font-size: 1.2em; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h1>Your Shopping Cart 🛒</h1>
    
    <div id="cart-content">
        <!-- Rendered by JavaScript -->
    </div>

    <div class="checkout-section">
        <h3>Order Confirmation</h3>
        <form action="process-order.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="receipt">Upload Payment Receipt (PDF):</label><br><br>
                <input type="file" id="receipt" name="receipt" accept=".pdf" required>
            </p>
            <button type="submit" class="btn-order">Complete Purchase ✅</button>
        </form>
    </div>
</div>

<script>
function displayCart() {
    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    let cartContent = document.getElementById('cart-content');
    
    if (cart.length === 0) {
        cartContent.innerHTML = "<p>Your cart is empty. <a href='products.php'>Go shopping!</a></p>";
        return;
    }

    let tableHTML = `
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    `;

    let grandTotal = 0;

    cart.forEach((item, index) => {
        let itemTotal = item.price * item.quantity;
        grandTotal += itemTotal;
        tableHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.price} SAR</td>
                <td>${item.quantity}</td>
                <td>${itemTotal} SAR</td>
                <td><button class="btn-remove" onclick="removeItem(${index})">Remove</button></td>
            </tr>
        `;
    });

    tableHTML += `
            </tbody>
        </table>
        <div class="total-box">
            Grand Total: ${grandTotal} SAR
        </div>
    `;

    cartContent.innerHTML = tableHTML;
}

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('ami_cart', JSON.stringify(cart));
    displayCart();
}

document.addEventListener('DOMContentLoaded', displayCart);
</script>

</body>
</html>