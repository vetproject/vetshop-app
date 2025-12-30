<?php
session_start();

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$id || !$action || !isset($_SESSION['cart'][$id])) {
    header("Location: /view_cart");
    exit;
}

switch ($action) {

    case 'plus':
        $_SESSION['cart'][$id]['quantity']++;
        break;

    case 'minus':
        if ($_SESSION['cart'][$id]['quantity'] > 1) {
            $_SESSION['cart'][$id]['quantity']--;
        } else {
            unset($_SESSION['cart'][$id]);
        }
        break;

    case 'remove':
        unset($_SESSION['cart'][$id]);
        break;
}

header("Location: /view_cart");
exit;
