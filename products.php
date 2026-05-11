<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <title>Products - Ami Studio</title>
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
            <li><a href="cart.php" style="position: relative;">CART 🛒 <span id="cart-count" style="background: #ff8fa3; color: white; border-radius: 50%; padding: 2px 7px; font-size: 11px; position: absolute; top: -10px; right: -15px; display: none; font-weight: bold; border: 1px solid white; min-width: 15px; text-align: center;">0</span></a></li>
            <li><a href="account.php">MY ACCOUNT</a></li>
            <li><a href="favorites.php">FAVORITE</a></li>
        </ul>
    </nav>
</header>

<div class="intro-div">
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
</div>

<?php
// إعدادات الترقيم (Pagination)
$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$totalStmt = $pdo->query("SELECT COUNT(*) FROM products");
$totalProducts = $totalStmt->fetchColumn();
$totalPages = ceil($totalProducts / $limit);

$stmt = $pdo->prepare("SELECT * FROM products LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
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
            <button onclick="addToCart(<?= $row['id']; ?>, '<?= addslashes($row['name']); ?>', <?= $row['price']; ?>)" class="addbut" style="width: 100%; border: none; cursor: pointer; padding: 10px; border-radius: 20px; background-color: #4FAF95; color: white; font-family: 'Futura', sans-serif;">
                Add to Cart 🛒
            </button>
        </div>
    <?php } ?>
</div>

<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page-1 ?>#products-start">&laquo; السابق</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>#products-start" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page+1 ?>#products-start">التالي &raquo;</a>
    <?php endif; ?>
</div>
<?php endif; ?>

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
        badge.innerText = count;
        badge.style.display = count > 0 ? 'inline-block' : 'none';
    }
}

function addToCart(id, name, price) {
    if(!id) return; // حماية إضافية
    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    let found = cart.find(item => item.id === id);
    if (found) { 
        found.quantity += 1; 
    } else { 
        cart.push({ id: id, name: name, price: price, quantity: 1 }); 
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
    modalTimer = setTimeout(() => { closeModal(); }, 3000);
}

function closeModal() {
    document.getElementById('cart-modal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', updateCartBadge);
</script>
</body>
</html>