<?php

header("Content-Type: application/json");

include('../common/db.inc.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        handleLogin($conn);
        break;
    default:
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'Hibás API kérés!']);
        break;
}

function handleLogin($conn, $input)
{
    if (!isset($input['username']) || !isset($input['password'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'Hiányzó mezők!']);
        return;
    }

    $username = $input['username'];
    $password = $input['password'];

    $sql = "SELECT id, password FROM " .DB_PREFIX. "_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['message' => 'Hibás felhasználónév vagy jelszó!']);
        return;
    }

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        echo json_encode(['message' => 'Sikeres bejelentkezés!', 'user_id' => $user['id']]);
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['message' => 'Hibás felhasználónév vagy jelszó!']);
    }
}
?>
