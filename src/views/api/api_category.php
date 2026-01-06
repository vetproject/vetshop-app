<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/categoryModel.php';

$method = $_SERVER['REQUEST_METHOD'];

try {

    // =========================
    // GET /api/categories
    // =========================
    if ($method === 'GET') {
        echo json_encode([
            "status" => true,
            "data" => getAllCategories()
        ]);
        exit;
    }

    // =========================
    // POST /api/categories
    // =========================
    if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || empty($data['name'])) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid data"]);
            exit;
        }

        $id = addCategory(
            $data['name'],
            $data['description'] ?? null
        );

        echo json_encode([
            "status" => true,
            "message" => "Category created",
            "id" => $id
        ]);
        exit;
    }

    // =========================
    // PUT /api/categories
    // =========================
    if ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        updateCategory(
            $data['id'],
            $data['name'],
            $data['description']
        );

        echo json_encode([
            "status" => true,
            "message" => "Category updated"
        ]);
        exit;
    }

    // =========================
    // DELETE /api/categories?id=1
    // =========================
    if ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["message" => "Category ID required"]);
            exit;
        }

        deleteCategory($id);

        echo json_encode([
            "status" => true,
            "message" => "Category deleted"
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
