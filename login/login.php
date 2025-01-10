<?php
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

$file = 'users.txt';

if (file_exists($file)) {
    $users = file($file, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($storedEmail, $storedPassword, $role) = explode('|', $user);
        if ($storedEmail == $email && $storedPassword == $password) {
            echo json_encode(['message' => "Suc role: $role"]);
            exit;
        }
    }
}

echo json_encode(['message' => 'Failed，邮箱或密码错误']);
?>
