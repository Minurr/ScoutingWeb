<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit;
}

include '../config.php';

$data = file_get_contents('../resource/data/scout_data.txt');

preg_match('/Team Code:\s*(\d+)/', $data, $matches);
$teamCode = $matches[1] ?? 'Unknown';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="../favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | MY PROFILE</title>
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        header h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .profile-section img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #ffffff;
        }
        .profile-info {
            flex-grow: 1;
        }
        .profile-info p {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        .profile-info button {
            background-color: #f05454;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }
        .profile-info button:hover {
            background-color: #d94141;
        }
    </style>
</head>
<body class="dark">
    <?php include '../unify/header.php'; ?>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        </header>
        <main>
            <section class="profile-section">
                    <img src="https://api.lfcup.cn/photo/files/6783c14824306.png" alt="Default Avatar">
                    <div class="profile-info">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                        <p><strong>Group:</strong> <?php echo htmlspecialchars($_SESSION['group']); ?></p>
                        <button onclick="logout()">Logout</button>
                        <button style="background-color:#177cb0"><a href="../user/name.php">Change</a></button>
                    </div>
            </section>
        </main>
    </div>
    <?php include '../unify/footer.php'; ?>
    <script>
        function logout() {
            fetch('../logout', { method: 'POST' }).then(() => {
                window.location.href = '/';
            });
        }
    </script>
</body>
</html>
