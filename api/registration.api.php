<?php

header("Content-Type: application/json");
include('../common/db.inc.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'POST':
        handlePost($conn, $input);  
        break;
    default:
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'Hibás API kérés!']);
        break;
}

function handlePost($conn, $input)
{
    if (!isset($input['username']) || !isset($input['email']) || !isset($input['password'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'Hiányzó mezők!']);
        return;
    }

    $username = $input['username'];
    $email = $input['email'];
    $password = password_hash($input['password'], PASSWORD_BCRYPT);

    $sql = "SELECT * FROM " . DB_PREFIX . "_users WHERE user_name = ? OR user_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header('HTTP/1.1 409 Conflict');
        echo json_encode(['message' => 'A felhasználónév vagy az e-mail cím már foglalt.']);
    } else {
        $sql = "INSERT INTO " . DB_PREFIX . "_users (user_name, user_email, user_password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Sikeres regisztráció!']);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['message' => 'Hiba történt a regisztráció során.']);
        }
    }
}
?>
