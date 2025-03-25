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
    case 'GET' :
        handleGetUser($conn);
        break;
    case 'PUT':
        if (isset($input["password"])) {
            handleUpdatePassword($conn, $input);
        } else {
            handleUpdateProfile($conn, $input);
        }
        break;
    case 'DELETE':
        handleDeleteAccount($conn, $input);
        break;
    default:
        http_response_code(400);
        echo json_encode(["error" => "Invalid API request"]);
        break;
}

function handleGetUser($conn) {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "User ID is required"]);
        return;
    }

    $id = intval($_GET['id']);
    $sql = "SELECT user_id, user_name, user_email FROM " . DB_PREFIX . "_users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(["success" => true, "message" => "User found", "user" => $user]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "User not found"]);
    }
}

function handleUpdateProfile($conn, $input) {
    if (!isset($input["id"])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "User ID is required"]);
        return;
    }

    $id = intval($input["id"]);
    $updatedFields = [];

    if (isset($input['username'])) {
        $username = $input['username'];
        $sql = "UPDATE " . DB_PREFIX . "_users SET user_name = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $username, $id);

        if ($stmt->execute()) {
            $updatedFields["username"] = $username;
        }
    }

    if (isset($input["email"])) {
        $email = $input["email"];
        $sql = "UPDATE " . DB_PREFIX . "_users SET user_email = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $email, $id);

        if ($stmt->execute()) {
            $updatedFields["email"] = $email;
        }
    }

    if (!empty($_FILES["profileImage"]["name"])) {
        $uploadDir = "uploads/profile_pics/";
        $imageFileType = strtolower(pathinfo($_FILES["profileImage"]["name"], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($imageFileType, $allowedTypes)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Invalid file type"]);
            return;
        }

        $newFileName = "profile_" . $id . "_" . time() . "." . $imageFileType;
        $targetFilePath = $uploadDir . $newFileName;

        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFilePath)) {
            $sql = "UPDATE " . DB_PREFIX . "_users SET user_profile_image = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newFileName, $id);

            if ($stmt->execute()) {
                $updatedFields["profileImage"] = $targetFilePath;
            }
        }
    }

    if (empty($updatedFields)) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "No valid data provided"]);
    } else {
        echo json_encode(["success" => true, "message" => "User updated successfully", "updatedFields" => $updatedFields]);
    }
}

function handleDeleteAccount($conn, $input) {
    if (empty($input["id"])) {
        http_response_code(400);
        echo json_encode(["error" => "User ID is required"]);
        return;
    }

    $id = intval($input["id"]);
    $sql = "DELETE FROM " . DB_PREFIX . "_users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Account successfully deleted"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to delete account"]);
    }
}
function handleUpdatePassword($conn, $input) {
    if (!isset($input["id"]) || !isset($input["old_password"]) || !isset($input["new_password"])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "User ID, old password, and new password are required"]);
        return;
    }

    $id = intval($input["id"]);
    $oldPassword = $input["old_password"];
    $newPassword = $input["new_password"];

    // Fetch current password hash
    $sql = "SELECT user_password FROM " . DB_PREFIX . "_users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "User not found"]);
        return;
    }

    $user = $result->fetch_assoc();
    $storedPasswordHash = $user['user_password'];

    if (!password_verify($oldPassword, $storedPasswordHash)) {
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "Incorrect old password"]);
        return;
    }

    $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

    $sql = "UPDATE " . DB_PREFIX . "_users SET user_password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newPasswordHash, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Password updated successfully", "updatedFields" => ["passwordUpdated" => true]]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to update password"]);
    }
}
?>
