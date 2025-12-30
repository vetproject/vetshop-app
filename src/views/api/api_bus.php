<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/buseModel.php';

$method = $_SERVER['REQUEST_METHOD'];

try {

    // =========================
    // GET /api/v1/buses
    // =========================
    if ($method === 'GET') {
        echo json_encode([
            "status" => true,
            "data" => getAllBuses()
        ]);
        exit;
    }

    // =========================
    // POST /api/v1/buses
    // =========================
    if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        $id = addBus(
            $data['busid'],
            $data['busname'],
            $data['password'],
            $data['image'] ?? null,
            $data['description'] ?? null
        );

        echo json_encode([
            "status" => true,
            "message" => "Bus created",
            "id" => $id
        ]);
        exit;
    }

    // =========================
    // PUT /api/v1/buses
    // =========================
    if ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        updateBus(
            $data['id'],
            $data['busid'],
            $data['busname'],
            $data['password'] ?? null,
            $data['image'] ?? null,
            $data['description'] ?? null
        );

        echo json_encode([
            "status" => true,
            "message" => "Bus updated"
        ]);
        exit;
    }

    // =========================
    // DELETE /api/v1/buses?id=1
    // =========================
    if ($method === 'DELETE') {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["message" => "Bus ID required"]);
            exit;
        }

        deleteBus($_GET['id']);

        echo json_encode([
            "status" => true,
            "message" => "Bus deleted"
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
