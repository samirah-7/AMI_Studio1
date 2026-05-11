<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("<script>alert('يرجى تسجيل الدخول أولاً'); window.location.href='login.php';</script>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $redbox = isset($_POST['redbox_point']) ? trim($_POST['redbox_point']) : 'غير محدد';
    $total_from_form = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;
    $details_from_form = isset($_POST['order_details']) ? trim($_POST['order_details']) : '';

    $cart_json = isset($_POST['cart_json']) ? $_POST['cart_json'] : '';
    $cart = [];
    if (!empty($cart_json)) {
        $cart = json_decode($cart_json, true);
        if (!is_array($cart)) $cart = [];
    }

    $order_items = [];
    $total = 0;
    $items_for_whatsapp = [];

    if (!empty($cart)) {
        $product_ids = array_filter(array_column($cart, 'id')); // فلترة أي ID فارغ
        
        if (!empty($product_ids)) {
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id IN ($placeholders)");
            $stmt->execute(array_values($product_ids));
            $products_db = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products_db[$row['id']] = $row;
            }

            foreach ($cart as $item) {
                $pid = isset($item['id']) ? intval($item['id']) : 0;
                $qty = intval($item['quantity']);
                if ($qty <= 0) continue;

                // إذا وجدنا المنتج في الداتابيز نأخذ سعره الحقيقي
                if (isset($products_db[$pid])) {
                    $price = floatval($products_db[$pid]['price']);
                    $item_name = $products_db[$pid]['name'];
                } else {
                    // حل احتياطي لو الـ ID مو موجود
                    $price = isset($item['price']) ? floatval($item['price']) : 0;
                    $item_name = isset($item['name']) ? $item['name'] : 'منتج غير معروف';
                }

                $subtotal = $price * $qty;
                $total += $subtotal;
                $order_items[] = [
                    'product_id' => $pid,
                    'quantity' => $qty,
                    'price' => $price
                ];
                $items_for_whatsapp[] = $item_name . " (x$qty)";
            }
        }
    }

    // إذا السلة فاضية تماماً نستخدم بيانات الفورم
    if (empty($order_items) && $total_from_form > 0) {
        $total = $total_from_form;
        $items_for_whatsapp[] = $details_from_form;
    }

    if (empty($order_items)) {
        die("<script>alert('عذراً، السلة فارغة أو هناك خطأ في البيانات'); window.location.href='cart.php';</script>");
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status, order_date) VALUES (?, ?, 'pending', NOW())");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $order_id = $pdo->lastInsertId();

        $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($order_items as $item) {
            // إذا كان الـ product_id صفر، نخليه NULL لو الجدول يسمح، أو نخليه 0
            $stmt_item->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
        }

        $pdo->commit();

        // إرسال للواتساب
        $phone = "966579810446";
        $message = "مرحباً Ami Studio ✨%0A";
        $message .= "طلب جديد رقم: *" . $order_id . "*%0A";
        $message .= "الاسم: " . $name . "%0A";
        $message .= "المدينة: " . $city . "%0A";
        $message .= "نقطة ريدبوكس: " . $redbox . "%0A";
        $message .= "الطلبات: " . implode(', ', $items_for_whatsapp) . "%0A";
        $message .= "الإجمالي: " . number_format($total, 2) . " SAR";

        $whatsapp_url = "https://wa.me/$phone?text=$message";
        header("Location: cart.php?status=success&wa=" . urlencode($whatsapp_url));
        exit();

    } catch (PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        die("خطأ في حفظ الطلب: " . $e->getMessage());
    }
} else {
    header('Location: cart.php');
    exit;
}
?>