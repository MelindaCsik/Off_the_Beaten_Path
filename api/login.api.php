<?php

header("Content-Type: application/json");

include('../common/db.inc.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);  

switch ($method) {
    case 'POST':
        handleLogin($conn, $input);  // Call the login function
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');  
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function handleLogin($conn, $input) {
    if (empty($input['password']) || (empty($input['username']) && empty($input['email']))) {
        http_response_code(400);
        echo json_encode(["error" => "Hiányzó adatok"]);  
    }

    $password = $input['password'];
    $stmt = null;

    // Check if we are using username or email
    if (!empty($input['username'])) {
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
        echo json_encode(["error" => "Hiba az adatbázisban"]); 
        return;
    }

    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        http_response_code(401);
        echo json_encode(["error" => "Hibás felhasználónév vagy jelszó"]);  
        return;
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['user_password'])) {
        http_response_code(401);
        echo json_encode(["error" => "Hibás felhasználónév vagy jelszó"]);  
        return;
    }

    unset($user['user_password']);  
    $user['token'] = bin2hex(random_bytes(32));  // Generate a token

    echo json_encode(["success" => true, "message" => "Sikeres bejelentkezés", "user" => $user]); 

}
?>