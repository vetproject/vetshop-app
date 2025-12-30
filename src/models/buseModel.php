<?php
require_once __DIR__ . '/../config/db.php';

function getAllBuses()
{
    global $conn;

    $result = $conn->query("SELECT * FROM buses ORDER BY id DESC");

    if (!$result) {
        throw new Exception($conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

function addBus($busid, $busname, $password, $image, $description)
{
    global $conn;

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO buses (busid, busname, password, image, description)
         VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param("sssss", $busid, $busname, $password, $image, $description);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return $conn->insert_id;
}

function updateBus($id, $busid, $busname, $password = null, $image = null, $description = null)
{
    global $conn;

    $sql = "UPDATE buses SET busid=?, busname=?, description=?";
    $types = "sss";
    $params = [$busid, $busname, $description];

    if (!empty($password)) {
        $sql .= ", password=?";
        $types .= "s";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
    }

    if (!empty($image)) {
        $sql .= ", image=?";
        $types .= "s";
        $params[] = $image;
    }

    $sql .= " WHERE id=?";
    $types .= "i";
    $params[] = $id;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return true;
}

function deleteBus($id)
{
    global $conn;

    $stmt = $conn->prepare("DELETE FROM buses WHERE id=?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return true;
}

function countBuses()
{
    global $conn;

    $result = $conn->query("SELECT COUNT(*) AS total FROM buses");
    $row = $result->fetch_assoc();

    return $row['total'];
}
