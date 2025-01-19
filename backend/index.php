<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'register') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $group = $_POST['group'];
        $reg_code = $_POST['reg_code'];

        if (verifyRegCode($reg_code)) {
            $users = file('../resource/data/users.txt');
            foreach ($users as $user) {
                list($storedUsername, $storedEmail, $storedPassword, $storedGroup) = explode(',', trim($user));
                if ($username === $storedUsername) {
                    echo json_encode(['success' => false, 'message' => 'Username already exists!']);
                    exit;
                }
                if (strtolower($email) === strtolower($storedEmail)) {
                    echo json_encode(['success' => false, 'message' => 'Email already registered!']);
                    exit;
                }
            }

            if (strlen($username) <= 4) {
                echo json_encode(['success' => false, 'message' => 'Username must be longer than 4 characters!']);
                exit;
            }

            if (strlen($password) <= 9) {
                echo json_encode(['success' => false, 'message' => 'Password must be longer than 9 characters!']);
                exit;
            }

            if (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password)) {
                echo json_encode(['success' => false, 'message' => 'Password must contain both uppercase and lowercase letters!']);
                exit;
            }

            $data = "$username,$email,$password,$group\n";
            file_put_contents('../resource/data/users.txt', $data, FILE_APPEND);
            echo json_encode(['success' => true, 'message' => 'Registration successful!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid registration code!']);
        }
    }

    if ($action === 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $users = file('../resource/data/users.txt');

        foreach ($users as $user) {
            list($storedUsername, $storedEmail, $storedPassword, $storedGroup) = explode(',', trim($user));
            if (strtolower($email) === strtolower($storedEmail) && $password === $storedPassword) {
                session_start();
                $_SESSION['username'] = $storedUsername;
                $_SESSION['email'] = $storedEmail; // Store the original email format in session
                $_SESSION['group'] = $storedGroup;
                echo json_encode(['success' => true, 'message' => 'Login successful!']);
                exit;
            }
        }
        echo json_encode(['success' => false, 'message' => 'Invalid credentials!']);
    }
}

function verifyRegCode($reg_code) {
    $valid_codes = ['IronMaple_5516_SCOUT_0x1s5kjdl'];
    return in_array($reg_code, $valid_codes);
}
?>
