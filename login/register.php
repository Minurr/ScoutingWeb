<?php
$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$code = $data['code'];

$validCodes = [
    'IronMaple_5516_Staff_mmff0' => 'Staff',
    'IronMaple_5516_Member_0' => 'Member'
];

if (!isset($validCodes[$code])) {
    echo json_encode(['message' => '无效验证码']);
    exit;
}

$role = $validCodes[$code];

$file = 'users.txt';
$userData = "$email|$password|$username|$role\n";

file_put_contents($file, $userData, FILE_APPEND);

echo json_encode(['message' => 'Suc role: ' . $role]);
?>
