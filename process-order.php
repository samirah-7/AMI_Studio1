<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // هنا المفروض الكود اللي يحفظ الطلب في الداتابيز
    // بس حالياً بنعطيك رسالة نجاح عشان تتأكدين إن الربط صح
    echo "<h2>Ami Studio 🧶</h2>";
    echo "<p>Thank you! Your order has been placed successfully.</p>";
    echo "<p>We will review your payment receipt soon.</p>";
    echo "<a href='products.php'>Back to Shop</a>";
}
?>