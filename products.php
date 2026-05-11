<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=2.9">
    <title>Products - Ami Studio</title>
    <style>
        body, h1, h2, h3, p, a, button {
            font-family: 'Tajawal', sans-serif;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        /* تنسيق الأسماء بلون وردي مميز */
        .highlight {
            color: #ff4d6d; /* وردي أغمق شوي عشان يبرز */
            font-weight: 700;
        }

        .intro-section {
            background-color: #fff5f7;
            padding: 80px 20px;
            text-align: center;
            border-bottom: 2px dashed #ffb7c5;
        }

        .intro-container {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
            direction: rtl; 
        }

        .intro-text {
            flex: 1.2;
            min-width: 300px;
            text-align: right;
        }

        .intro-image {
            flex: 0.8;
            min-width: 300px;
        }

        .intro-image img {
            width: 100%;
            max-width: 400px;
            border-radius: 40px;
            border: 8px solid white;
            box-shadow: 0 15px 30px rgba(255, 183, 197, 0.4);
        }

        /* تنسيق عنوان الكولكشن */
        .collection-header {
            width: 100%;
            text-align: center;
            margin: 60px 0 40px 0;
        }

        .collection-header h2 {
            font-size: 3.8rem;
            color: #ff8fa3;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .scroll-link {
            display: inline-block;
            margin-top: 40px;
            color: #ff8fa3;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
    </style>
</head>
<body onload="window.scrollTo(0, 0);">

<script>
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
</script>

<header id="hed">
    <img src="./image/SanMilogo.png" id="logo" class="logp">
    <nav>
        <ul>
            <li><a href="products.php">HOME</a></li>
            <li><a href="cart.php" style="position: relative;">CART 🛒 <span id="cart-count">0</span></a></li>
            <li><a href="login.php">LOG IN</a></li>
            <li><a href="favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>

<section class="intro-section">
    <div class="intro-container">
        <div class="intro-text">
            <h1 style="color: #ff8fa3; font-size: 2.8em; margin-bottom: 25px;">حكاية خيط وجمعة بنات.. قصة <span class="highlight">Ami Studio</span> ✨</h1>
            
            <p style="font-size: 1.25em; color: #555; line-height: 1.9; margin-bottom: 15px;">
                هلا والله! حكايتنا في <span class="highlight">Ami Studio</span> بدأت من جلسة روقان وحب لخيوط الكروشيه بين <span class="highlight">جنى وميس</span>. كنا نبغى نحول هالخيوط الصامتة لأشياء كيوت تنحب وتنبض بالحياة، ومع الوقت كبر الحلم وصرنا نغزل لك كل قطعة بحب وتركيز عالي. 🧶
            </p>
            
            <p style="font-size: 1.25em; color: #555; line-height: 1.9; margin-bottom: 15px;">
                وطبعاً هالجمال ما كمل إلا بوقفة مبدعاتنا <span class="highlight">دانه وسميره</span>، اللي كان لهم الدور الكبير في تطوير هالموقع وتنسيقه عشان يوصل لك بأفضل صورة وتكون تجربتك معنا سهلة وتفتح النفس. 💻🎀
            </p>
            
            <p style="font-size: 1.25em; color: #555; line-height: 1.9;">
                هدفنا دايم إننا نقدم لك قطعة فنية يدوية (Handmade) تعيش معك عمر، وتذكرك دايم إن "الإبداع غرزة ورى غرزة". نورتينا في عالمنا الصغير! 🌸
            </p>
        </div>

        <div class="intro-image">
            <img src="./image/our-story.jpg" alt="Ami Studio Story">
        </div>
    </div>
    
    <a href="#products-start" class="scroll-link">
        تصفحي منتجاتنا المصنوعة بحب ✨
        <div style="font-size: 2.5em;">👇</div>
    </a>
</section>

<?php
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<div class="collection-header" id="products-start">
    <h2>Our Collection 🧶</h2>
</div>

<div class="prodiv">
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
            <a href="product-details.php?id=<?= $row['id']; ?>" class="view-link">View Details ✨</a>
            <br><br>
            <button onclick="addToCart('<?= $row['name']; ?>', <?= $row['price']; ?>)" class="view-link" style="background: #ffb7c5; border:none; cursor:pointer; width:100%;">
                Add to Cart 🛒
            </button>
        </div>
    <?php } ?>
</div>

<script>
// كود السلة وتحديث الشارة يبقى كما هو
function updateCartBadge() {
    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    let count = cart.reduce((total, item) => total + item.quantity, 0);
    let badge = document.getElementById('cart-count');
    if (badge) {
        badge.innerText = count;
        badge.style.display = count > 0 ? 'inline-block' : 'none';
    }
}
document.addEventListener('DOMContentLoaded', updateCartBadge);
</script>
</body>
</html>