<?php
include 'config.php';
$data = file_get_contents('scout_data.txt');
$teamParam = $_GET['team'] ?? null;
$matchParam = $_GET['match'] ?? null;

$teams = [];
$matches = [];
$videos = [];

$lines = explode("\n", $data);
$currentTeam = null;
$currentMatch = null;
$teamData = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (preg_match("/^Team Code:\s*(\d+)$/", $line, $match)) {
        $currentTeam = $match[1];
        $currentMatch = null;
    } elseif (preg_match("/^Match Code:\s*(\d+)$/", $line, $match)) {
        $currentMatch = $match[1];
    } elseif ($currentTeam && $currentMatch && strpos($line, ':') !== false) {
        [$key, $value] = explode(':', $line, 2);
        $teams[$currentTeam][$currentMatch][trim($key)] = trim($value);
    }
}

// nm的这个bug我修了一个小时，12/28/2024 12:28AM修好留念。
$videoData = file_get_contents('scout_video.txt');
$videoLines = explode("\n", $videoData);
$videos = [];
$currentTeam = null;
$currentMatch = null;

foreach ($videoLines as $line) {
    $line = trim($line);

    if (preg_match("/^Team Code:\s*(\d+)/", $line, $match)) {
        $currentTeam = $match[1];
    }

    if (preg_match("/^Match Code:\s*(\d+)/", $line, $match)) {
        $currentMatch = $match[1];
    }

    if (preg_match("/^Video Path:\s*(\S+)/", $line, $match)) {
        if ($currentTeam && $currentMatch) {
            $videos[$currentTeam][$currentMatch] = $match[1];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $teamname ?> <?php echo $team ?> | SCOUT <?php echo $com_type ?></title>
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
        .a2 {
            color: #3794ff;
            text-decoration: none;
        }

        .a2:hover {
            text-decoration: underline;
        }

        hr {
            border: none;
            height: 1px;
            background: #444;
            margin: 20px 0;
        }

        .p2 {
            line-height: 1.8;
            font-size: 16px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solidrgb(255, 255, 255);
        }

        th {
            background-color:rgba(53, 73, 162, 0.9);
        }

        td {
            background-color:rgba(15, 29, 49, 0.9);
        }

        td strong {
            color: #dcdcdc;
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
    <div class="container">
        <?php if ($teamParam && isset($teams[$teamParam])): ?>
            <br>
            <h1 style="font-size: 26px;">Team <?php echo htmlspecialchars($teamParam); ?>'s Data</h1>
            <hr>
            <?php if ($matchParam && isset($teams[$teamParam][$matchParam])): ?>
                <h2>Match: <?php echo htmlspecialchars($matchParam); ?></h2>
                <hr>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Data</th></th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $matchData = $teams[$teamParam][$matchParam];
                            foreach ($matchData as $key => $value) {
                                echo "<tr><td><strong>" . htmlspecialchars($key) . ":</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div>
                    <h3>Video</h3>
                    <?php
                    echo "<video width='100%' controls><source src='" . htmlspecialchars($videos[$teamParam][$matchParam]) . "' type='video/mp4'>Your browser does not support the video tag.</video>";
                    ?>
                </div>
                <p class="p2"><a class="a2" href="./view.php?team=<?php echo urlencode($teamParam); ?>">Back to Team</a></p>
            <?php else: ?>
                <h2 style="font-size: 18px;">Matches List 比赛列表</h2>
                <hr>
                
                <ul>
                    <?php
                    foreach ($teams[$teamParam] as $matchCode => $matchData): ?>
                        <li><a class="a2" href="./view.php?team=<?php echo urlencode($teamParam); ?>&match=<?php echo urlencode($matchCode); ?>"><?php echo "Match ".htmlspecialchars($matchCode); ?></a></li>
                    <?php endforeach; ?>
                    <hr>
                    <p class="p2"><a class="a2" href="./view.php">Back to All-Team</a></p>
                </ul>
            <?php endif; ?>
        <?php else: ?>
            <br>
            <h1 style="font-size: 26px;">Team List 队伍列表</h1>
            <hr>
            <ul>
                <?php
                foreach ($teams as $teamCode => $matchList): ?>
                    <li><a class="a2" href="./view.php?team=<?php echo urlencode($teamCode); ?>">Team <?php echo htmlspecialchars($teamCode); ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <footer>
        <div class="footer-content">
            <div class="footer-sponsor">
                <b>
                    <p class="p2">Sponsors 鸣谢赞助: </p>
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