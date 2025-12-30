<?php
session_start();

require_once __DIR__ . '/../models/orderModel.php';

$businfo = $_SESSION['admin'] ?? null;
$bus_name = $businfo['busname'] ?? 'Unknown Bus';

$customer_name = htmlspecialchars($_POST['customer_name']);
$customer_phone = htmlspecialchars($_POST['customer_phone']);
$cart = $_SESSION['cart'] ?? [];
$total = $_POST['total'];

// ✅ Save order to DB using external function
try {
    saveOrder($bus_name, $customer_name, $customer_phone, $cart, $total);
} catch (Exception $e) {
    die("Failed to save order: " . $e->getMessage());
}

$config = include __DIR__ . '/../models/settingTelegram.php';

$botToken = $config['botToken'];
$chatId   = $config['chatId'];

// Build the message
$message = "🛒 *New Order Received!*\n";
$message .= "🚌 Bus Name: *$bus_name*\n";
$message .= "👤 Name: *$customer_name*\n";
$message .= "📞 Phone: *$customer_phone*\n";
$message .= "\n🧾 *Order Details:*\n";

foreach ($cart as $item) {
    $name = htmlspecialchars($item['name']);
    $category = htmlspecialchars($item['category']);
    $quantity = (int)$item['quantity'];
    $price = number_format($item['price'], 2);
    $total_item = number_format($item['price'] * $item['quantity'], 2);

    $message .= "• Product: $name, Catefory: $category $ × $quantity = \$$total_item\n";
}

$message .= "\n💰 *Total: $" . number_format($total, 2) . "*";

// Send message to Telegram
$sendUrl = "https://api.telegram.org/bot$botToken/sendMessage";

$response = file_get_contents($sendUrl . '?' . http_build_query([
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'Markdown'
]));

// Clear the cart
unset($_SESSION['cart']);
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f1f1f1;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .thank-you-box {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h1 {
        font-size: 26px;
        color: #28a745;
    }

    p {
        font-size: 16px;
        color: #555;
    }

    a {
        margin-top: 20px;
        display: inline-block;
        text-decoration: none;
        color: white;
        background: #007bff;
        padding: 12px 24px;
        border-radius: 6px;
    }

    a:hover {
        background: #0056d2;
    }
</style>

<body>
    <div class="thank-you-box">
        <h1>Thank you for your order!</h1>
        <p>We've received your order and will contact you shortly.</p>
        <a href="/">← Back to Shop</a>
    </div>
</body>