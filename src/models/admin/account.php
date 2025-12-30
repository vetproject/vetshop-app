<?php
require __DIR__ . '../../../config/db.php';

function addBus($name, $password, $image)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO buses (busname, password, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $password, $image);
    return $stmt->execute();
}

function loginBus($name, $password)
{
    global $conn;

    $stmt = $conn->prepare(
        "SELECT id, busname, role 
         FROM buses 
         WHERE busname = ? AND password = ? 
         LIMIT 1"
    );
    $stmt->bind_param("ss", $name, $password);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}
