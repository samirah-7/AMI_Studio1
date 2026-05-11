<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css?v=1.9">
    <title>Products - Ami Studio</title>
    <style>
        /* تنسيق بسيط للعداد فوق أيقونة السلة */
        #cart-count {
            background: #ff8fa3;
            color: white;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 11px;
            position: absolute;
            top: -10px;
            right: -15px;
            display: none;
            font-weight: bold;
            border: 1px solid white;
        }
    </style>
</head>
<body>

<header id="hed">
    <img src="./image/SanMilogo.png" id="logo" class="logp">
    <p class="logp">⊹₊˚‧︵‿₊୨ᰔ୧₊‿︵‧˚₊⊹</p>
    <p class="logp">a piece of art .✦ ݁˖</p>

    <nav>
        <ul>
            <li><a href="products.php">HOME</a></li>
            <li><a href="cart.php" style="position: relative;">CART 🛒 <span id="cart-count">0</span></a></li>
            <li><a href="account.php">MY ACCOUNT</a></li>
            <li><a href="favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>

<?php
include "config.php";

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<div class="prodiv">
    <h1>Our Products 🧶</h1>

    <?php foreach($products as $row) { ?>
        <div class="smdivpro">
            <div class="card-img-container">
                <img src="DateBase/<?php echo $row['image_url']; ?>" alt="<?= $row['name']; ?>" class="pro-img">
                
                <form action="add_favorite.php" method="POST" class="fav-form">
                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                    <button type="submit" class="fav-heart-btn">🩷</button>
                </form>
            </div>

            <h3><?= $row['name']; ?></h3>
            <p class="price-tag"><?= $row['price']; ?> SAR</p>

            <a href="product-details.php?id=<?= $row['id']; ?>" class="view-link">
                View Details ✨
            </a>
            <br><br>
            <button onclick="addToCart('<?= $row['name']; ?>', <?= $row['price']; ?>)" class="view-link" style="background: #ffb7c5; border:none; cursor:pointer; width:100%;">
                Add to Cart 🛒
            </button>
        </div>
    <?php } ?>
</div>

<div id="cart-modal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 20px; text-align: center; width: 350px; position: relative; border: 2px solid #ffb7c5; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <h3 style="color: #ff8fa3; margin-bottom: 10px;">Added to Cart! ✨</h3>
        <p style="color: #666;">Your item is ready for its new home.</p>
        
        <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
            <a href="cart.php" style="background: #ff8fa3; color: white; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: bold; display: block;">Checkout Now (إتمام الطلب)</a>
            <button onclick="closeModal()" style="background: #f0f0f0; border: none; padding: 10px; border-radius: 10px; cursor: pointer; color: #555;">Continue Shopping (إكمال التسوق)</button>
        </div>

        <div id="timer-bar" style="height: 5px; background: #ffb7c5; width: 100%; position: absolute; bottom: 0; left: 0; border-radius: 0 0 20px 20px; transition: width 3s linear;"></div>
    </div>
</div>

<footer class="footer">
    <p class="background">Follow us:</p>
    <a href="https://www.instagram.com/ami.studi0">INSTAGRAM - </a>
    <a href="https://www.tiktok.com/@ami.studi0">TIKTOK - </a>
    <a href="https://wa.me/+966579810446">WHATSAPP</a>
    <p class="background">@2026 AMI-STUDIO</p>
</footer>

<script>
let modalTimer;

function updateCartBadge() {
    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    let count = cart.reduce((total, item) => total + item.quantity, 0);
    let badge = document.getElementById('cart-count');
    
    if (badge) {
        if (count > 0) {
            badge.innerText = count;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
}

function addToCart(name, price) {
    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    let found = cart.find(item => item.name === name);

    if (found) {
        found.quantity += 1;
    } else {
        cart.push({ name: name, price: price, quantity: 1 });
    }

    localStorage.setItem('ami_cart', JSON.stringify(cart));
    
    updateCartBadge();
    showModal();
}

function showModal() {
    const modal = document.getElementById('cart-modal');
    const bar = document.getElementById('timer-bar');
    
    modal.style.display = 'flex';
    bar.style.transition = 'none';
    bar.style.width = '100%';
    
    setTimeout(() => {
        bar.style.transition = 'width 3s linear';
        bar.style.width = '0%';
    }, 10);

    clearTimeout(modalTimer);
    modalTimer = setTimeout(() => {
        closeModal();
    }, 3000);
}

function closeModal() {
    document.getElementById('cart-modal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', updateCartBadge);
</script>

</body>
</html>