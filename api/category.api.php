<?php

header("Content-Type: application/json");
include('../common/db.inc.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if (!$conn) {
    sendResponse(500, false, "Database connection failed");
    exit;
}

switch ($method) {
    case 'GET':
        handleGetCategory($conn);
        break;
}

$conn->close();

function handleGetCategory($conn) {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = "SELECT category_name FROM " . DB_PREFIX . "_category WHERE category_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["error" => "Database query preparation failed"]);
            return;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($row = $result->fetch_assoc()) { 
                echo json_encode(['category' => $row["category_name"]]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Category not found"]);
            }
            $result->free(); // Freeing up resources
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Query execution failed"]);
        }

        $stmt->close(); // Close statement
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Missing category ID"]);
    }
}
