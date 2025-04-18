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
        handleGetPOI($conn);
        break;
    case 'POST':
        handleAddPOI($conn, $input);
        break;
    case 'PUT':
        handleUpdatePOI($conn, $input);
        break;
    case 'DELETE':
        handleDeletePOI($conn);
        break;
    default:
        sendResponse(405, false, "Method Not Allowed");
}

$conn->close();


function handleGetPOI($conn) {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = "SELECT * FROM " . DB_PREFIX . "_poi WHERE poi_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $poi = $result->fetch_assoc();

        sendResponse(200, true, $poi ?: ["error" => "POI not found"]);
    } 
    elseif(isset($_GET["user_id"])){
        $id = intval($_GET['user_id']);
        $query = "SELECT * FROM " . DB_PREFIX . "_poi WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $userPois = $result->fetch_all(MYSQLI_ASSOC);

        sendResponse(200, true, $userPois);
    }
    else {
        $query = "SELECT * FROM " . DB_PREFIX . "_poi";
        $result = $conn->query($query);
        $pois = $result->fetch_all(MYSQLI_ASSOC);

        sendResponse(200, true, $pois);
    }
}


function handleAddPOI($conn, $input) {
    if (empty($input['poi_name']) || empty($input['poi_discription']) || empty($input['latitude']) || empty($input['longitude']) || empty($input['landmark_id']) || empty($input['category_id']) || empty($input['user_id'])) {
        sendResponse(400, false, "Invalid input: All fields are required.");
        return;
    }

    $poi_name = $input['poi_name'];
    $poi_discription = $input['poi_discription'];
    $latitude = $input['latitude'];
    $longitude = $input['longitude'];
    $landmark_id = $input['landmark_id'];
    $category_id = $input['category_id'];
    $user_id = $input['user_id'];

    $coordinate_id = insertCoordinate($conn, $latitude, $longitude);
    if (!$coordinate_id) {
        sendResponse(500, false, "Failed to create coordinate.");
        return;
    }

    $query = "INSERT INTO " . DB_PREFIX . "_poi (poi_name, poi_discription, coordinate_id, landmark_id, category_id, user_id) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiiii", $poi_name, $poi_discription, $coordinate_id, $landmark_id, $category_id, $user_id);
    
    if ($stmt->execute()) {
        sendResponse(201, true, ["message" => "POI added successfully", "poi_id" => $stmt->insert_id]);
    } else {
        sendResponse(500, false, "Failed to add POI");
    }
}


function handleUpdatePOI($conn, $input) {
    if (empty($_GET['poi_id'])) {
        sendResponse(400, false, "POI ID is required for update.");
        return;
    }

    $poi_id = intval($_GET['poi_id']);
    $poi_name = $input['poi_name'] ?? null;
    $poi_discription = $input['poi_discription'] ?? null;
    $landmark_id = $input['landmark_id'] ?? null;
    $category_id = $input['category_id'] ?? null;
    $user_id = $input['user_id'] ?? null;

    $coordinate_id = null;
    if (!empty($input['latitude']) && !empty($input['longitude'])) {
        $latitude = $input['latitude'];
        $longitude = $input['longitude'];
        $coordinate_id = insertCoordinate($conn, $latitude, $longitude);
        if (!$coordinate_id) {
            sendResponse(500, false, "Failed to create coordinate.");
            return;
        }
    }

    $query = "UPDATE " . DB_PREFIX . "_poi SET ";
    $params = [];
    $types = "";

    if ($poi_name !== null) {
        $query .= "poi_name = ?, ";
        $params[] = $poi_name;
        $types .= "s";
    }
    if ($poi_discription !== null) {
        $query .= "poi_discription = ?, ";
        $params[] = $poi_discription;
        $types .= "s";
    }
    if ($coordinate_id !== null) {
        $query .= "coordinate_id = ?, ";
        $params[] = $coordinate_id;
        $types .= "i";
    }
    if ($landmark_id !== null) {
        $query .= "landmark_id = ?, ";
        $params[] = $landmark_id;
        $types .= "i";
    }
    if ($category_id !== null) {
        $query .= "category_id = ?, ";
        $params[] = $category_id;
        $types .= "i";
    }
    if ($user_id !== null) {
        $query .= "user_id = ?, ";
        $params[] = $user_id;
        $types .= "i";
    }

    $query = rtrim($query, ", ") . " WHERE poi_id = ?";
    $params[] = $poi_id;
    $types .= "i";

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        sendResponse(200, true, "POI updated successfully");
    } else {
        sendResponse(500, false, "Failed to update POI");
    }
}



function handleDeletePOI($conn) {
    if (!isset($_GET['id'])) {
        sendResponse(400, false, "ID is required");
        return;
    }

    $poi_id = intval($_GET['id']);
    $query = "DELETE FROM " . DB_PREFIX . "_poi WHERE poi_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $poi_id);

    if ($stmt->execute()) {
        sendResponse(200, true, "POI deleted successfully");
    } else {
        sendResponse(500, false, "Failed to delete POI");
    }
}

function insertCoordinate($conn, $latitude, $longitude) {
    $query = "INSERT INTO " . DB_PREFIX . "_coordinate (coordinate_latitude, coordinate_longitude) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("dd", $latitude, $longitude);
    
    if ($stmt->execute()) {
        return $stmt->insert_id; 
    } else {
        return false; 
    }
}

function fetchCoordinateId($conn, $category_id) {
    $query = "SELECT coordinate_id FROM " . DB_PREFIX . "_category WHERE latidute = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row ? $row['coordinate_id'] : null;
}

function sendResponse($statusCode, $success, $message) {
    http_response_code($statusCode);
    echo json_encode(["success" => $success, "message" => $message]);
}

?>
