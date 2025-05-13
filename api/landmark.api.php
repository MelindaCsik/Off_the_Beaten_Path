<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
        handleGetLandmark($conn);
        break;
}
function handleGetLandmark($conn) {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = "SELECT landmark_discription FROM " . DB_PREFIX . "_landmark WHERE landmark_id = ?";
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
                echo json_encode(['landmark_discription' => $row["landmark_discription"], ]);
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
        $query = "SELECT * FROM " . DB_PREFIX . "_landmark";
        $result = $conn->query($query);
        
        $data = []; // Initialize an array
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Push each row into the array
            }
        } else {
            echo "Error: " . $conn->error;
        }
        
        $conn->close();
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
