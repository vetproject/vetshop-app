<?php
require_once __DIR__ . '/../../models/orderModel.php';

$orderDetails = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $order_id = $_GET['id'] ?? null;
    if ($order_id) {
        $orderDetails = getOrderById($order_id);
    }
}

// Mark order as read
if ($orderDetails && (($orderDetails['isRead'] ?? 1) == 0)) {
    markOrderAsRead($order_id);
    $orderDetails['isRead'] = 1;
}


?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<!-- back to home -->
<div class="m-4">
    <a href="/orders"
        class="btn  w-100 d-flex align-items-center justify-content-start gap-2 fw-semibold"
        style="color:#662D91;">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Orders
    </a>
</div>

<?php if (!empty($orderDetails)): ?>

    <?php
    $busName       = htmlspecialchars($orderDetails['bus_name']);
    $customerName  = htmlspecialchars($orderDetails['customer_name']);
    $customerPhone = htmlspecialchars($orderDetails['customer_phone']);
    $orderDate     = htmlspecialchars($orderDetails['order_date']);
    $orderStatus   = htmlspecialchars($orderDetails['status']);

    $orderTime = date('g:i a', strtotime($orderDetails['order_date']));
    $orderTimeFormatted = strtoupper(str_replace(['am', 'pm'], ['AM', 'PM'], $orderTime));
    ?>

    <div class="order-summary">
        <div class="order-col">
            <p><span>🏢 Business:</span> <?= $busName ?></p>
            <p><span>👤 Customer:</span> <?= $customerName ?></p>
            <p><span>📞 Phone:</span> <?= $customerPhone ?></p>
        </div>

        <div class="order-col">
            <p><span>📦 Status:</span> <?= $orderStatus ?></p>
            <p><span>⏰ Time:</span> <?= $orderTimeFormatted ?></p>
            <p><span>📅 Date:</span> <?= $orderDate ?></p>
        </div>
    </div>

<?php endif; ?>



<?php if (empty($orderDetails['items'])): ?>

    <table class="table-product-order">
        <tbody>
            <tr id="noResultsRow">
                <td colspan="6">No items found for this order.</td>
            </tr>
        </tbody>
    </table>

<?php else: ?>

    <table class="table-product-order">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $grandTotal = 0;

            foreach ($orderDetails['items'] as $item):
                $itemTotal = $item['price'] * $item['quantity'];
                $grandTotal += $itemTotal;

                $image = !empty($item['image'])
                    ? htmlspecialchars($item['image'])
                    : '../images/products/default.png';
            ?>

                <tr class="<?= (($orderDetails['isRead'] ?? 1) == 0) ? 'order-unread' : '' ?>">

                    <td>
                        <img src="<?= $image ?>"
                            alt="<?= htmlspecialchars($item['product_name']) ?>"
                            style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                    </td>

                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= htmlspecialchars($item['category']) ?></td>
                    <td><?= (int)$item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($itemTotal, 2) ?></td>
                </tr>

            <?php endforeach; ?>

            <tr style="background:#fff;">
                <td colspan="5" style="text-align:right;font-weight:bold;">
                    Total Price:
                </td>
                <td style="font-weight:bold;">
                    $<?= number_format($grandTotal, 2) ?>
                </td>
            </tr>
        </tbody>
    </table>

<?php endif; ?>


<style>
    .order-summary {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        background: #f7f7fb;
        padding: 16px 20px;
        border-radius: 8px;
        color: #333;
        font-size: 13px;
        margin-bottom: 15px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .order-col {
        flex: 1;
    }

    .order-col p {
        margin: 0 0 10px;
        padding: 6px 10px;
        border-left: 4px solid #662D91;
        border-radius: 4px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .order-col span {
        font-weight: bold;
        color: #662D91;
        min-width: 90px;
        display: inline-block;
    }

    @media (max-width: 600px) {
        .order-summary {
            flex-direction: column;
        }
    }
</style>

<style>
    .table-product-order {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 6px;
        margin-top: 15px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 13px;
    }

    .table-product-order thead tr {
        color: #662D91;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .table-product-order th,
    .table-product-order td {
        padding: 10px 12px;
        text-align: left;
        vertical-align: top;
    }

    .table-product-order ul {
        list-style-type: disc;
        padding-left: 20px;
        margin: 0;
    }

    .table-product-order li {
        margin-bottom: 4px;
    }

    .table-product-order tbody tr {
        font-size: 12px;
        background-color: #f8f8fc;
        transition: background-color 0.2s ease;
        border-radius: 6px;
        cursor: pointer;
    }

    .table-product-order tbody tr:hover {
        background-color: #ecebfa;
    }

    #noResultsRow td {
        font-style: italic;
        color: #888;
        background-color: #fff5f5;
        text-align: center;
        padding: 12px;
        border-radius: 6px;
        font-size: 13px;
    }

    .order-unread {
        background-color: #e0d8e7ff !important;
        font-weight: bold;
        border-left: 4px solid #ffc107;
    }

    .order-unread td {
        font-weight: bold;
    }
</style>

<style>
    .btn-purple {
        background-color: #662D91;
        color: #fff;
        border-radius: 8px;
    }

    .btn-purple:hover {
        background-color: #522370;
        color: #fff;
    }
</style>