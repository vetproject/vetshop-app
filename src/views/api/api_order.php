<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/orderModel.php';

$method = $_SERVER['REQUEST_METHOD'];

/**
 * Allow HTML form override (_method)
 */
if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}

try {

    /* =========================
       GET
       - /api/v1/orders
       - /api/v1/orders?id=1
    ========================= */
    if ($method === 'GET') {

        if (isset($_GET['id'])) {
            $order = getOrderById((int)$_GET['id']);

            if (!$order) {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "Order not found"]);
                exit;
            }

            echo json_encode([
                "status" => true,
                "data" => $order
            ]);
            exit;
        }

        echo json_encode([
            "status" => true,
            "data" => getAllOrders(),
            "total" => countOrders(),
            "unread" => getNotificationsCount()
        ]);
        exit;
    }

    /* =========================
       POST
       - CREATE ORDER
    ========================= */
    if ($method === 'POST') {

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "Invalid JSON"]);
            exit;
        }

        $order_id = saveOrder(
            $data['bus_name'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['cart'],
            $data['total']
        );

        echo json_encode([
            "status" => true,
            "message" => "Order created",
            "order_id" => $order_id
        ]);
        exit;
    }

    /* =========================
       PUT
       - UPDATE STATUS
       - MARK AS READ
    ========================= */
    if ($method === 'PUT') {

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['order_id'])) {
            http_response_code(400);
            echo json_encode(["message" => "Order ID required"]);
            exit;
        }

        if (isset($data['markRead']) && $data['markRead'] === true) {
            markOrderAsRead($data['order_id']);
        }

        if (isset($data['status'])) {
            updateOrderStatus($data['order_id'], $data['status']);
        }

        echo json_encode([
            "status" => true,
            "message" => "Order updated"
        ]);
        exit;
    }

    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "error" => $e->getMessage()
    ]);
}
