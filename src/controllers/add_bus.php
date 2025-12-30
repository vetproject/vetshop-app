<?php
require_once __DIR__ . '/../models/buseModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $busid = trim($_POST['busid']);
    $busname = trim($_POST['busname']);
    $password = trim($_POST['password']);
    $description = trim($_POST['description']);

    // Convert uploaded image to base64
    if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $base64Image = base64_encode($imageData);
    } else {
        $base64Image = null;
    }

    addBus($busid, $busname, $password, $base64Image, $description);

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
