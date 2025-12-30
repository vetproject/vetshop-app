<?php
require_once __DIR__ . '/../config/db.php';

/* =========================
   CREATE ORDER
========================= */
function saveOrder($bus_name, $customer_name, $customer_phone, $cart, $total)
{
    global $conn;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare(
            "INSERT INTO orders (bus_name, customer_name, customer_phone, total, order_date)
             VALUES (?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param('sssd', $bus_name, $customer_name, $customer_phone, $total);
        $stmt->execute();

        $order_id = $conn->insert_id;

        $stmtItem = $conn->prepare(
            "INSERT INTO order_items 
            (order_id, product_id, product_name, category, quantity, price, image)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        foreach ($cart as $item) {

            $product_id   = (int)$item['id'];
            $product_name = $item['name'];
            $category     = $item['category'];
            $quantity     = (int)$item['quantity'];
            $price        = (float)$item['price'];
            $image        = $item['image'];

            $stmtItem->bind_param(
                'iissids',
                $order_id,
                $product_id,
                $product_name,
                $category,
                $quantity,
                $price,
                $image
            );

            $stmtItem->execute();
        }

        $conn->commit();
        return $order_id;
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}

/* =========================
   COUNTS
========================= */
function getNotificationsCount()
{
    global $conn;
    $res = $conn->query("
        SELECT COUNT(DISTINCT order_id) AS total 
        FROM order_items 
        WHERE isRead = 0
    ");
    return (int)$res->fetch_assoc()['total'];
}

function countOrders()
{
    global $conn;
    $res = $conn->query("SELECT COUNT(*) AS total FROM orders");
    return (int)$res->fetch_assoc()['total'];
}

/* =========================
   GET ALL ORDERS
========================= */
function getAllOrders()
{
    global $conn;

    $sql = "
        SELECT 
            o.id AS order_id,
            o.bus_name,
            o.customer_name,
            o.customer_phone,
            o.total,
            o.order_date,
            o.status,
            GROUP_CONCAT(DISTINCT oi.category) AS categories,
            GROUP_CONCAT(CONCAT(oi.product_name,' (x',oi.quantity,')')) AS products,
            IF(SUM(oi.isRead = 0) > 0, 0, 1) AS isRead
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        GROUP BY o.id
        ORDER BY o.order_date DESC
    ";

    $result = $conn->query($sql);
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $row['isRead'] = (int)$row['isRead']; // normalize
        $orders[] = $row;
    }

    return $orders;
}

/* =========================
   GET ORDER BY ID
========================= */
function getOrderById($order_id)
{
    global $conn;

    $sqlOrder = "
        SELECT 
            o.id AS order_id,
            o.bus_name,
            o.customer_name,
            o.customer_phone,
            o.total,
            o.order_date,
            o.status,
            IF(SUM(oi.isRead = 0) > 0, 0, 1) AS isRead
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        WHERE o.id = ?
        GROUP BY o.id
        LIMIT 1
    ";

    $stmt = $conn->prepare($sqlOrder);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order) return null;

    $stmtItems = $conn->prepare("
        SELECT product_name, category, price, quantity, image
        FROM order_items WHERE order_id = ?
    ");
    $stmtItems->bind_param("i", $order_id);
    $stmtItems->execute();

    $order['items'] = $stmtItems->get_result()->fetch_all(MYSQLI_ASSOC);
    $order['isRead'] = (int)$order['isRead']; // normalize

    return $order;
}

/* =========================
   UPDATE
========================= */
function markOrderAsRead($order_id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE order_items SET isRead = 1 WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
}

function updateOrderStatus($order_id, $status)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
}

/* =========================
   STATS
========================= */
function getTopProducts($limit = 10)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT 
            product_id,
            MAX(product_name) AS product_name,
            MAX(image) AS image,
            SUM(quantity) AS total_sold,
            SUM(quantity * price) AS total_price
        FROM order_items
        GROUP BY product_id
        ORDER BY total_sold DESC
        LIMIT ?
    ");
    $stmt->bind_param("i", $limit);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/* =========================
   DELETE ORDER
========================= */
function deleteOrder($order_id)
{
    global $conn;
    $stmtItems = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmtItems->bind_param("i", $order_id);
    $stmtItems->execute();

    $stmtOrder = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmtOrder->bind_param("i", $order_id);
    $stmtOrder->execute();
}
