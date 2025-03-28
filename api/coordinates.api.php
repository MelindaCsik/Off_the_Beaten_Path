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
        handleGetCoordinate($conn);
        break;
    default:
        sendResponse(405, false, "Method Not Allowed");
}

$conn->close();

function handleGetCoordinate($conn) {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "User ID is required"]);
        return;
    }

    $id = intval($_GET['id']);
    $sql = "SELECT coordinate_id , coordinate_latitude, coordinate_longitude FROM " . DB_PREFIX . "_coordinate WHERE coordinate_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $coordinate = $result->fetch_assoc();
        echo json_encode(["success" => true, "message" => $coordinate]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Coordinate not found"]);
    }
}
?>