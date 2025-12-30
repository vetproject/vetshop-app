<?php
require_once __DIR__ . '/../models/orderModel.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_GET['order_id'];
    $status  = $_POST['status'];

    try {
        if ($order_id && $status) {
            $updated = updateOrderStatus($order_id, $status);
            if ($updated) {
                header('Location: /orders');
            } else {
                header('Location: /orders');
            }
        } else {
            header('Location: /orders');
        }
    } catch (Exception $e) {
        header('Location: /orders.php?error=' . urlencode($e->getMessage()));
    }
}
