<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("<script>alert('يرجى تسجيل الدخول أولاً'); window.location.href='login.php';</script>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // بيانات الفورم (المستخدمة في الواتساب والجدول القديم)
    $name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $redbox = isset($_POST['redbox_point']) ? trim($_POST['redbox_point']) : 'غير محدد';
    $total_from_form = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;
    $details_from_form = isset($_POST['order_details']) ? trim($_POST['order_details']) : '';

    // محاولة الحصول على بيانات السلة من cart_json (أسلوبنا الجديد)
    $cart_json = isset($_POST['cart_json']) ? $_POST['cart_json'] : '';
    $cart = [];
    if (!empty($cart_json)) {
        $cart = json_decode($cart_json, true);
        if (!is_array($cart)) $cart = [];
    }

    // إذا كانت السلة غير موجودة أو فارغة، نستخدم order_details من الفورم لإنشاء عنصر وهمي للحفظ في order_items؟ لا، الأفضل أن نطلب تفاصيل.
    // لكن سنتعامل مع الحالتين:

    $order_items = [];
    $total = 0;
    $items_for_whatsapp = [];

    if (!empty($cart)) {
        // الحالة المثالية: لدينا منتجات مفصلة من السلة
        $product_ids = array_column($cart, 'id');
        if (!empty($product_ids)) {
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id IN ($placeholders)");
            $stmt->execute($product_ids);
            $products_db = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products_db[$row['id']] = $row;
            }
            foreach ($cart as $item) {
                $pid = $item['id'];
                $qty = intval($item['quantity']);
                if ($qty <= 0) continue;
                if (!isset($products_db[$pid])) continue;
                $price = floatval($products_db[$pid]['price']);
                $subtotal = $price * $qty;
                $total += $subtotal;
                $order_items[] = [
                    'product_id' => $pid,
                    'quantity' => $qty,
                    'price' => $price
                ];
                $items_for_whatsapp[] = $products_db[$pid]['name'] . " (x$qty)";
            }
        }
    }

    // إذا فشلنا في الحصول على تفاصيل من cart (إما لعدم إرساله أو عدم وجود منتجات صحيحة)، نستخدم total_from_form و details_from_form لإنشاء عنصر واحد في order_items (حل احتياطي)
    if (empty($order_items) && !empty($details_from_form)) {
        // إنشاء سجل واحد في order_items يحتوي على نص الطلب كمنتج وهمي (لأغراض التوثيق)
        $total = $total_from_form;
        $order_items[] = [
            'product_id' => 0,  // معرف وهمي، لن يكون موجوداً في products
            'quantity' => 1,
            'price' => $total
        ];
        $items_for_whatsapp[] = $details_from_form;
    }

    if (empty($order_items)) {
        die("<script>alert('لا توجد منتجات صالحة للطلب'); window.location.href='cart.php';</script>");
    }

    // حفظ الطلب في قاعدة البيانات
    try {
        $pdo->beginTransaction();

        // إدراج في جدول orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status, order_date) VALUES (?, ?, 'pending', NOW())");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $order_id = $pdo->lastInsertId();

        // إدراج في order_items (تجنب إدراج product_id=0 إن أمكن)
        $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($order_items as $item) {
            $pid = ($item['product_id'] > 0) ? $item['product_id'] : NULL;
            // إذا كان pid يساوي NULL، قد لا يسمح به الجدول. لإتمام الحفظ نضع قيمة افتراضية 0 إذا كان الحقل Not Null.
            // لكن الأفضل تعديل الجدول ليقبل NULL مؤقتاً. سنستخدم 0 مؤقتاً.
            $stmt_item->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
        }

        $pdo->commit();

        // إعداد رابط الواتساب
        $phone = "966579810446";
        $message = "مرحباً Ami Studio ✨%0A";
        $message .= "طلب جديد رقم: *" . $order_id . "*%0A";
        $message .= "الاسم: " . $name . "%0A";
        $message .= "المدينة: " . $city . "%0A";
        $message .= "نقطة ريدبوكس: " . $redbox . "%0A";
        $message .= "الطلبات: ";
        if (!empty($items_for_whatsapp)) {
            $message .= implode(', ', $items_for_whatsapp);
        } else {
            $message .= $details_from_form;
        }
        $message .= "%0A";
        $message .= "الإجمالي: " . number_format($total, 2) . " SAR";

        $whatsapp_url = "https://wa.me/$phone?text=$message";
        header("Location: cart.php?status=success&wa=" . urlencode($whatsapp_url));
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("خطأ في حفظ الطلب: " . $e->getMessage());
    }
} else {
    header('Location: cart.php');
    exit;
}
?>