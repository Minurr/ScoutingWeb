<?php
session_start();
$file = '../resource/data/users.txt';
include '../config.php';

if (!isset($_SESSION['email'])) {
    echo "<p>pls login first.</p>";
    exit;
}

$userEmail = $_SESSION['email'];

function readUsers($file) {
    $users = [];
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($nickname, $email, $password, $group) = explode(',', $line);
            $users[] = ['nickname' => $nickname, 'email' => $email, 'password' => $password, 'group' => $group];
        }
    }
    return $users;
}

function updateNickname($file, $email, $newNickname) {
    if (!file_exists($file) || !is_writable($file)) {
        echo "<p>数据不存在或不可写</p>";
        return;
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as &$line) {
        $parts = explode(',', $line);
        if ($parts[1] === $email) {
            $parts[0] = $newNickname; // 修改昵称
            $line = implode(',', $parts);
        }
    }
    file_put_contents($file, implode("\n", $lines)); // 保存文件
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nickname'])) {
    $newNickname = htmlspecialchars($_POST['nickname']);

    if (empty($newNickname)) {
        echo "<p>昵称不能为空</p>";
        exit;
    }

    updateNickname($file, $userEmail, $newNickname);
    echo "<p>昵称已更新</p>";
}

$users = readUsers($file);
$currentUser = array_filter($users, function ($user) use ($userEmail) {
    return $user['email'] === $userEmail;
});
$currentUser = reset($currentUser); // 获取当前用户信息
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="../favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | CHANGE NAME</title>
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/v_styles.css" rel="stylesheet">
    <style>
        table {
            border: 1px solid black;
        }
        @media only screen and (max-width: 600px) {
            table {
                font-size: 13px;
            }
        }
    </style>
</head>
<body class="dark">
    <?php include '../unify/header.php'; ?>
    <div class="container">
        <h1 style="font-size: 26px;">Change UserName</h1>
        <form method="post">
            <label for="nickname">New Name：</label><br>
            <input type="text" id="nickname" name="nickname" value="<?php echo htmlspecialchars($currentUser['nickname'] ?? ''); ?>" required><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
    <br><br>
    <h2 style="font-size: 21px;">Now profile：</h2>
    <table border="1">
        <thead>
            <tr>
                <th>UserName</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo htmlspecialchars($currentUser['nickname'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($currentUser['email'] ?? ''); ?></td>
            </tr>
        </tbody>
    </table><br>
  If you wanna change other self-data, please contact admin.
    <br><br><br>
    <?php include '../unify/footer.php'; ?>
</body>
</html>