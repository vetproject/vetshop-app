<?php
require_once __DIR__ . '/../models/buseModel.php';

$id = $_POST['id'];
$busid = $_POST['busid'];
$busname = $_POST['busname'];
$description = $_POST['description'];

// Password (optional)
$password = null;
if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
}

// Image (optional)
$image = null;
if (!empty($_FILES['image']['tmp_name'])) {
    $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
}

updateBus($id, $busid, $busname, $password, $image, $description);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
