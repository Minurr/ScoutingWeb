<?php
// backend.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // 注册功能
    if ($action === 'register') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $group = $_POST['group'];
        $reg_code = $_POST['reg_code'];

        if (verifyRegCode($reg_code)) {
            // 这里将用户数据追加到文件中
            $data = "$username,$email,$password,$group\n";
            file_put_contents('../resource/data/users.txt', $data, FILE_APPEND);
            echo json_encode(['success' => true, 'message' => 'Registration successful!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid registration code!']);
        }
    }

    // 登录功能
    if ($action === 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $users = file('../resource/data/users.txt');

        foreach ($users as $user) {
            list($storedUsername, $storedEmail, $storedPassword, $storedGroup) = explode(',', trim($user));
            if ($email === $storedEmail && $password === $storedPassword) {
                session_start();
                $_SESSION['username'] = $storedUsername;
                $_SESSION['email'] = $storedEmail;
                $_SESSION['group'] = $storedGroup;
                echo json_encode(['success' => true, 'message' => 'Login successful!']);
                exit;
            }
        }
        echo json_encode(['success' => false, 'message' => 'Invalid credentials!']);
    }
}

// 验证注册代码的函数
function verifyRegCode($reg_code) {
    $valid_codes = ['REG2025']; // 这里可以添加更多有效的注册代码
    return in_array($reg_code, $valid_codes);
}
?>
