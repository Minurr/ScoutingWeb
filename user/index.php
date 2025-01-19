<?php
session_start();
$file = '../resource/data/users.txt';
include '../config.php';
include '../admin/permissions.php';
checkPermission(['管理员']);

function readUsers($file)
{
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

function updateGroup($file, $email, $newGroup)
{
    if (!file_exists($file) || !is_writable($file)) {
        echo "<p>数据不存在/不可写</p>";
        return;
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as &$line) {
        $parts = explode(',', $line);
        if ($parts[1] === $email) {
            $parts[3] = $newGroup;
            $line = implode(',', $parts);
        }
    }
    file_put_contents($file, implode("\n", $lines)); // 保存文件
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['group'])) {
    $email = htmlspecialchars($_POST['email']);
    $newGroup = htmlspecialchars($_POST['group']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>邮箱格式无效</p>";
        exit;
    }
    if (empty($newGroup)) {
        echo "<p>组别不能为空</p>";
        exit;
    }

    updateGroup($file, $email, $newGroup);
    echo "<p>用户组别已更新</p>";
}

$users = readUsers($file);
?>


<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="../favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | USER CONFIG</title>
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/v_styles.css" rel="stylesheet">
    <style>
        table {
            border: 1px solid black;
        }

        table {
            font-size: inherit;

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
        <h1 style="font-size: 26px;">Change user's group</h1>
        <form method="post">
            <label for="email" style="color: rgb(216, 247, 255);">User's E-mail：</label><br>
            <input type="text" id="email" name="email" required><br><br>
            <label for="group" style="color: rgb(216, 247, 255);">New Group：</label><br>
            <input type="text" id="group" name="group" required><br><br>
            <input type="submit" value="Submit">
            <br>
        </form>
    </div>
    <br><br>
    <!-- <div class="container" style="background-color:#484848cf"> -->
    <h2 style="font-size: 21px;">Total Mumber：<?php echo count($users); ?></h2>

    <table border="1">
        <thead>
            <tr>
                <th>Name 昵称</th>
                <th>Email 邮箱</th>
                <th>Group 组别</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['nickname']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['group']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- </div> -->
    <br><br><br>
    <?php include '../unify/footer.php'; ?>
</body>

</html>