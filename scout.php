<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teamCode = $_POST['team_code'] ?? '';
    $matchCode = $_POST['match_code'] ?? '';
    $scoutData = $_POST['scout_data'] ?? [];

    $filename = "scout_data.txt";
    $fileContent = "Team Code: $teamCode\nMatch Code: $matchCode\n";

    foreach ($scoutData as $key => $value) {
        $fileContent .= "$key: $value\n";
    }

    // 这里先存到txt文件里面，后面改数据库，先实现功能为主
    file_put_contents($filename, $fileContent, FILE_APPEND);
    echo "Data saved successfully.";
}
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $teamname ?> <?php echo $team ?> | SCOUTING</title>
    <link href="./styles2.css" rel="stylesheet">
    <link href="./styles3.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #eaeaea;
            font-family: 'Poppins', sans-serif;
        }

        h1 {
            text-transform: uppercase;
        }

        .hero-section {
            background-image: url('https://api4.lfcup.cn/photo/bj.jpg');
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(8px);
            padding: 50px;
            border-radius: 20px;
            color: white;
            margin: 8px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 30px;
            margin: 8px;
            backdrop-filter: blur(6px);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.04);
        }

        .button {
            background-color: #FF5722;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #FF784E;
        }

        footer {
            margin-top: 30px;
            border-top: 2px solid #fff;
            padding-top: 20px;
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .footer-logo img {
            max-width: 150px;
        }

        .footer-sponsor {
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #ccc;
        }
        .inline-form {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .inline-form label {
            font-size: 16px;
            font-weight: bold;
            color: #e0e0e0;
        }

        .inline-form input[type="text"] {
            flex: 1;
            max-width: 300px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            outline: none;
            transition: all 0.3s;
        }

        .inline-form input[type="text"]:focus {
            background-color: #444;
        }

        .inline-form input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #5e6f78;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .inline-form input[type="submit"]:hover {
            background-color: #4a565f;
        }
        form {
            margin-top: 20px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #e0e0e0;
        }

        input[type="text"] {
            width: 60%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            outline: none;
            transition: all 0.3s;
        }

        input[type="text"]:focus {
            background-color: #444;
        }

        input[type="number"] {
            width: 60%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            outline: none;
            transition: all 0.3s;
        }

        input[type="number"]:focus {
            background-color: #444;
        }

        input[type="submit"] {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #5e6f78;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #4a565f;
        }

        .f1orm {
            background: rgba(255, 255, 255, 0.53);
            border-radius: 17px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .i1nput,
        select {
            width: calc(100% - 20px);
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }


        .form-section {
            margin-bottom: 20px;
        }

        .add-button {
            display: inline-block;
            background-color: #28a745;
        }

        .add-button:hover {
            background-color: #218838;
        }

        .remove-button {
            background-color: #dc3545;
        }

        .remove-button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body class="dark">
    <br>
    <header class="text-center p-5">
        <a href="./"><h1 class="text-4xl font-semibold"><?php echo $teamname ?> SCOUT</h1></a>
        <form action="./view.php" class="inline-form">
            <label for="team">Search Team:</label>
            <input type="text" id="team" name="team" placeholder="114514">
            <input type="submit" value="Submit">
        </form>
    </header>
    <section class="hero-section">
        <h2>F<?php echo $com_type ?>#<?php echo $team ?></h2>
        <h2 class="text-2xl">欢迎来到 F<?php echo $com_type ?> 2025</h2>
        <p>这里是<?php echo $teamname ?>的SCOUT网站，你可以在这里找到各种类型的数据和技巧、分类。</p>
    </section>

    <form class="f1orm" method="POST">
        <div class="form-section">
            <label for="team_code">Team Code:</label>
            <input type="text" id="team_code" name="team_code" required>
            <br>
            <label for="match_code">Match Code:</label>
            <input type="text" id="match_code" name="match_code" required>
        </div>
        <hr><br>
        <!-- 变量显示 -->
        <?php foreach ($variables as $variable): ?>
            <div class="form-section">
                <label for="<?= $variable['name'] ?>"><?= $variable['name'] ?>:</label>
                <?php if ($variable['type'] === 'number'): ?>
                    <input type="number" id="<?= $variable['name'] ?>" name="scout_data[<?= $variable['name'] ?>]">
                <?php elseif ($variable['type'] === 'select' && isset($variable['options'])): ?>
                    <select style="color:black" id="<?= $variable['name'] ?>" name="scout_data[<?= $variable['name'] ?>]">
                        <?php foreach ($variable['options'] as $option): ?>
                            <option style="color:black" value="<?= $option ?>"><?= $option ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <input type="submit" value="Submit">
    </form>

    <footer>
        <div class="footer-content">
            <div class="footer-sponsor">
                <b>
                    <p>Sponsors 鸣谢赞助: </p>
                </b>
            </div>
            <div class="footer-logo">
                <a href="https://www.zyhost.cn/"><img src="https://api4.lfcup.cn/files/logo2.png" alt="Logo"
                        class="logo" width="150" height="auto"></a>
            </div>
        </div>
        <p>Current Server: Aliyun-Shanghai</p>
    </footer>
    <footer class="text-center p-5">
        <p>Copyright &copy; 2025 IronMaple@Minur.</p>
    </footer>
</body>

</html>