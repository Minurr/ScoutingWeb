<?php
include 'config.php';

$data = file_get_contents('scout_data.txt');

preg_match('/Team Code:\s*(\d+)/', $data, $matches);
$teamCode = $matches[1] ?? 'Unknown';
?>
<!DOCTYPE html>
<html lang='zh-CN'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?php echo $teamname ?> <?php echo $team ?>| Scouting Website</title>
    <style>
        body {
            //font-family: 'Arial-Black', cursive;
            font-family: Arial Black;
            background-image: url('https://api.lfcup.cn/photo/files/67694b89cc17a.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        h1,
        h2,
        h3 {
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.64);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class='container'>
        <h1><?php echo $teamname ?>-<?php echo $team ?></h1>
        <h2>Scouting Site</h2>
        <hr>
        <!-- <p>TeamCode of Already Have Data:<br><br><?php echo $teamCode ?></p> -->
        <form action="./view.php">
            <label for="team">Team Code:</label>
            <input type="text" id="team" name="team" placeholder="114514">
            <input type="submit" value="Submit">
        </form>
        <br><br>
        <!-- 放两个links在这里，后面优化样式。。。 -->
        <a href='./scout.php'>Scouting Site</a><br>
        <a href='./admin.php'>Admin Site</a>
    </div>

</body>

</html>