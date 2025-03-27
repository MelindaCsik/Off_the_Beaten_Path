<?php

header("Content-Type: application/json");

include('../common/db.inc.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'POST':
        handleLogin($conn, $input);
        break;
    default:
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'Hibás API kérés!']);
        break;
}

function handleLogin($conn, $input) {
    if ((!isset($input['username']) && !isset($input['email'])) || !isset($input['password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing required fields"]);
        return;
    }

    $password = $input['password'];
    $stmt = null;

    if (isset($input['username'])) {
        $username = trim($input['username']);
        $sql = "SELECT user_id, user_password, user_name, user_email, user_admin FROM " . DB_PREFIX . "_users WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
    } else {
        $email = trim($input['email']);
        $sql = "SELECT user_id, user_password, user_name, user_email, user_admin FROM " . DB_PREFIX . "_users WHERE user_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
    }

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(["error" => "Database error"]);
        return;
    }

    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid username or password"]);
        return;
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['user_password'])) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid username or password"]);
        return;
    }

    unset($user['user_password']);
    $user['token'] = bin2hex(random_bytes(32)); // Generate secure session token

    echo json_encode(["message" => "Sikeres bejelentkezés ", "user" => $user]);
}
?>