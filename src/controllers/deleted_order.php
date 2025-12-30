<?php
require_once __DIR__ . '/../models/orderModel.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $order_id = $_GET['order_id'] ?? null;

    try {
        if ($order_id) {
            $deleted = deleteOrder($order_id);
            if ($deleted) {
                header('Location: /orders?deleted=false');
            } else {
                header('Location: /orders?deleted=true&order_id=' . $order_id);
            }
        } else {
            header('Location: /orders?deleted=false');
        }
    } catch (Exception $e) {
        header('Location: /orders.php?error=' . urlencode($e->getMessage()));
    }
    exit;
}
