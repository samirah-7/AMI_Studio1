
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













 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ami Studio - Shopping Cart</title>
</head>
<body >

<header id="hed">
    <img src="./image/SanMilogo.png" id="logo" class="logp">
    <p class="logp">⊹₊˚‧︵‿₊୨ᰔ୧₊‿︵‧˚₊⊹</p>
    <p class="logp">a piece of art .✦ ݁˖</p>

    <nav>
        <ul>
            <li><a href="products.php">HOME</a></li>
            <li><a href="cart.php">CART</a></li>
            <li><a href="login.php">LOG IN</a></li>
            <li><a href="#">FAVEORET</a></li>
        </ul>
    </nav>
</header>

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

<footer class="footer">
    <p class="background">Follow us:</p>
    <a href="https://www.instagram.com/ami.studi0?igsh=MTFrbW82OGp5ZnBydQ==">INSTAGRAM - </a>
    <a href="https://www.tiktok.com/@ami.studi0?_r=1&_t=ZS-96AJUvVID2O">TIKTOK - </a>
    <a href="https://wa.me/+966579810446">WHATSAPP</a>
    <p class="background">@2026 AMI-STUDIO</p>
</footer>

</body>
</html>
