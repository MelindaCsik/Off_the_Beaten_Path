<?php

header("Content-Type: application/json");
include('../common/db.inc.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Fetch a single POI by ID
            $id = intval($_GET['id']);
            $query = "SELECT * FROM points_of_interest WHERE poi_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $poi = $result->fetch_assoc();

            echo json_encode($poi ?: ["error" => "POI not found"]);
        } else {
            // Fetch all POIs
            $query = "SELECT * FROM points_of_interest";
            $result = $conn->query($query);
            $pois = $result->fetch_all(MYSQLI_ASSOC);

            echo json_encode($pois);
        }
        break;

    case 'POST':
        // Add a new POI
        if (!empty($input['poi_name']) && !empty($input['poi_description']) && !empty($input['coordinate_id']) && !empty($input['landmark_id']) && !empty($input['category_id']) && !empty($input['user_id'])) {
            $poi_name = $input['poi_name'];
            $poi_description = $input['poi_description'];
            $coordinate_id = $input['coordinate_id'];
            $landmark_id = $input['landmark_id'];
            $category_id = $input['category_id'];
            $user_id = $input['user_id'];

            $query = "INSERT INTO points_of_interest (poi_name, poi_description, coordinate_id, landmark_id, category_id, user_id) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssiiii", $poi_name, $poi_description, $coordinate_id, $landmark_id, $category_id, $user_id);
            $stmt->execute();

            echo json_encode(["message" => "POI added successfully", "poi_id" => $stmt->insert_id]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid input"]);
        }
        break;

    case 'PUT':
        // Update an existing POI
        if (!empty($input['poi_id']) && (!empty($input['poi_name']) || !empty($input['poi_description']) || !empty($input['coordinate_id']) || !empty($input['landmark_id']) || !empty($input['category_id']) || !empty($input['user_id']))) {
            $poi_id = intval($input['poi_id']);
            $poi_name = $input['poi_name'] ?? null;
            $poi_description = $input['poi_description'] ?? null;
            $coordinate_id = $input['coordinate_id'] ?? null;
            $landmark_id = $input['landmark_id'] ?? null;
            $category_id = $input['category_id'] ?? null;
            $user_id = $input['user_id'] ?? null;

            $query = "UPDATE points_of_interest SET 
                        poi_name = COALESCE(?, poi_name), 
                        poi_description = COALESCE(?, poi_description), 
                        coordinate_id = COALESCE(?, coordinate_id), 
                        landmark_id = COALESCE(?, landmark_id), 
                        category_id = COALESCE(?, category_id), 
                        user_id = COALESCE(?, user_id)
                      WHERE poi_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssiiiiii", $poi_name, $poi_description, $coordinate_id, $landmark_id, $category_id, $user_id, $poi_id);
            $stmt->execute();

            echo json_encode(["message" => "POI updated successfully"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid input"]);
        }
        break;

    case 'DELETE':
        // Delete a POI by ID
        if (isset($_GET['id'])) {
            $poi_id = intval($_GET['id']);
            $query = "DELETE FROM points_of_interest WHERE poi_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $poi_id);
            $stmt->execute();

            echo json_encode(["message" => "POI deleted successfully"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID is required"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
}

$conn->close();

?>
