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
            font-family: "Consolas", "Courier New", monospace;
            background-image: url('https://api.lfcup.cn/photo/files/67694b89cc17a.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #d4d4d4;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3 {
            text-align: center;
            color: #dcdcdc;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background:rgba(37, 37, 38, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }

        p {
            line-height: 1.8;
            font-size: 16px;
            margin: 5px 0;
            color: #d4d4d4;
        }

        /* Split style for ":" */
        p span {
            display: inline-block;
            font-weight: bold;
            color: #569cd6; /* Key color */
            min-width: 120px; /* Ensure alignment */
        }

        p span.value {
            font-weight: normal;
            color: #9cdcfe; /* Value color */
        }

        a {
            color: #3794ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        hr {
            border: none;
            height: 1px;
            background: #444;
            margin: 20px 0;
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
                echo " ";
            }
        } else {
            echo "<h3>No Data</h3>";
            echo "<p>Plz provide a valid teamCode.</p><br><p>Like ./view.php?team=114514</p>";
        }
        ?>

        <?php
            foreach ($lines as $line) {
                // 分离 ":" 前后内容
                if (strpos($line, ':') !== false) {
                    [$key, $value] = explode(':', $line, 2);
                    echo "<p><span>$key:</span> <span class='value'>" . htmlspecialchars(trim($value)) . "</span></p>";
                } else {
                    echo "<p>" . htmlspecialchars($line) . "</p>";
                }
            }
        ?>

    </div>
</body>

</html>