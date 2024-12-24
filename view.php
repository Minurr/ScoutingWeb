<?php
include 'config.php';
$teamParam = $_GET['team'] ?? null;
$data = file_get_contents('scout_data.txt');
$teamData = null;

if ($teamParam) {
    preg_match(
        "/Team Code:\s*{$teamParam}.*?(?=Team Code:|$)/s",
        $data,
        $teamDataMatches
    );
    $teamData = $teamDataMatches[0] ?? null;
}
?>
<!DOCTYPE html>
<html lang='zh-CN'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Team <?php echo $teamParam ?> | FRC5516 Scouting</title>
    <style>
        body {
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
        <?php
        if ($teamParam && $teamData) {
            echo "<h1>IM  Scouting Data</h1><h2>for Team $teamParam</h2><hr>";
            $lines = explode("\n", trim($teamData));
            foreach ($lines as $line) {
                echo "<p>" . htmlspecialchars($line) . "</p>";
            }
        } else {
            echo "<h3>No Data</h3>";
            echo "<p>Plz provide a valid teamCode.</p><br><p>Like ./view.php?team=114514</p>";
        }
        ?>

    </div>
</body>

</html>