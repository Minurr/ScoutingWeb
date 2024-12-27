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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Scout Data</title>
    <style>
        body {
            font-family: "Lato", "Regular 400 Italic";
            background-image: url('https://api.lfcup.cn/photo/files/67694b89cc17a.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0px auto;
            background: rgba(37, 37, 38, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }

        h1,
        h2 {
            text-align: center;
            color: #dcdcdc;
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

        p {
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

<body>
    <div class="container">
        <?php if ($teamParam && isset($teams[$teamParam])): ?>
            <h1>Scouting Data</h1><h2>for Team <?php echo htmlspecialchars($teamParam); ?></h2>
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
                <p><a href="./view.php?team=<?php echo urlencode($teamParam); ?>">Back to Team</a></p>
            <?php else: ?>
                <h2>Matches</h2>
                <hr>
                <ul>
                    <?php
                    foreach ($teams[$teamParam] as $matchCode => $matchData): ?>
                        <li><a href="./view.php?team=<?php echo urlencode($teamParam); ?>&match=<?php echo urlencode($matchCode); ?>"><?php echo htmlspecialchars($matchCode); ?></a></li>
                    <?php endforeach; ?>
                    <p><a href="./view.php">Back to All-Team</a></p>
                </ul>
            <?php endif; ?>
        <?php else: ?>
            <h1>All Teams</h1>
            <hr>
            <ul>
                <?php
                foreach ($teams as $teamCode => $matchList): ?>
                    <li><a href="./view.php?team=<?php echo urlencode($teamCode); ?>">Team <?php echo htmlspecialchars($teamCode); ?></a></li>
                <?php endforeach; ?>
            </ul>
            <p><a href="./">Back to Index</a></p>
        <?php endif; ?>
    </div>
</body>

</html>
