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

function handleLogin($conn, $input)
{
    if ((!isset($input['username']) && !isset($input['email'])) || !isset($input['password'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['message' => 'Hiányzó mezők!']);
        return;
    }
    
if (isset($input['username'])) {
    $username = $input['username'];

    $sql = "SELECT user_id, user_password password FROM " .DB_PREFIX. "_users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $email = $input['email'];

    $sql = "SELECT user_id, user_password password FROM " .DB_PREFIX. "_users WHERE user_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
}
$password = $input['password'];
    

  

    if ($result->num_rows === 0) {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['message' => 'Hibás felhasználónév vagy jelszó!']);
        //echo json_encode(['message' => 'Hibás felhasználónév vagy jelszó!', 'passwordHash' => $password, 'password' => $input['password'], 'sql' => $sql, 'email' => $email ]);
        return;
    }

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        echo json_encode(['message' => 'Sikeres bejelentkezés!', 'user_id' => $user['user_id']]);
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['message' => 'Hibás felhasználónév vagy jelszó!']);
        //echo json_encode(['message' => 'Hibás felhasználónév vagy jelszó!', 'passwordHash' => $password, 'password' => $input['password'], 'sql' => $sql, 'email' => $email, 'user' => $user]);
    }
}
?>
