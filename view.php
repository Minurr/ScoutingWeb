<?php
include 'config.php';
$data = file_get_contents('scout_data.txt');
$teamParam = $_GET['team'] ?? null;
$matchParam = $_GET['match'] ?? null;

$teams = [];

$lines = explode("\n", $data);
$currentTeam = null;
$matches = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (preg_match("/^Team Code:\s*(\d+)$/", $line, $match)) {
        $currentTeam = $match[1];
        if (!isset($matches[$currentTeam])) {
            $matches[$currentTeam] = [];
        }
        $matches[$currentTeam][] = "";
    } elseif ($currentTeam && strpos($line, ':') !== false) {
        $matches[$currentTeam][count($matches[$currentTeam]) - 1] .= $line . "\n";
    }
}

foreach ($matches as $teamCode => $matchList) {
    $totalMatches = count($matchList);
    for ($i = 0; $i < $totalMatches; $i++) {
        $teams[$teamCode]["Match " . ($i + 1)] = trim($matchList[$i]);
    }
}

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>
        <?php
        if ($teamParam && $matchParam) {
            echo "Team $teamParam - $matchParam | FRC5516 Scouting";
        } elseif ($teamParam) {
            echo "Team $teamParam | FRC5516 Scouting";
        } else {
            echo "All Teams | FRC5516 Scouting";
        }
        ?>
    </title>
    <style>
        body {
            font-family: "Consolas", "Courier New", monospace;
            background-image: url('https://api.lfcup.cn/photo/files/67694b89cc17a.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            //color: #d4d4d4;
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            color: #dcdcdc;
        }

        .container {
            max-width: 500px;
            margin: 5 auto;
            background: rgba(37, 37, 38, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        p {
            line-height: 1.8;
            font-size: 16px;
            margin: 5px 0;
            color: #d4d4d4;
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
    <br>
    <div class='container'>
        <?php if ($teamParam && isset($teams[$teamParam])): ?>
            <h1>Scouting Data</h1>
            <h2>for Team <?php echo htmlspecialchars($teamParam); ?></h2>
            <hr>
            <?php if ($matchParam && isset($teams[$teamParam][$matchParam])): ?>
                <h2><?php echo htmlspecialchars($matchParam); ?></h2>
                <hr>
                <?php
                $lines = explode("\n", $teams[$teamParam][$matchParam]);
                foreach ($lines as $line) {
                    if (strpos($line, ':') !== false) {
                        [$key, $value] = explode(':', $line, 2);
                        echo "<p><strong>" . htmlspecialchars(trim($key)) . ":</strong> " . htmlspecialchars(trim($value)) . "</p>";
                    } else {
                        echo "<p>" . htmlspecialchars($line) . "</p>";
                    }
                }
                ?>
                <p><a href="./view.php?team=<?php echo urlencode($teamParam); ?>">Back to team's data</a></p>
            <?php else: ?>
                <h2>Matches</h2>
                <hr>
                <ul>
                    <?php foreach ($teams[$teamParam] as $matchCode => $matchData): ?>
                        <li><a
                                href="./view.php?team=<?php echo urlencode($teamParam); ?>&match=<?php echo urlencode($matchCode); ?>"><?php echo htmlspecialchars($matchCode); ?></a>
                        </li>
                    <?php endforeach; ?>
                    <br>
                    <p><a href="./view.php">Back to All-team</a></p>
                </ul>
            <?php endif; ?>
        <?php else: ?>
            <h1>All Teams</h1>
            <hr>
            <ul>
                <?php foreach ($teams as $teamCode => $matches): ?>
                    <li><a href="./view.php?team=<?php echo urlencode($teamCode); ?>">Team
                            <?php echo htmlspecialchars($teamCode); ?></a></li>
                <?php endforeach; ?>
                <br>
                <p><a href="./">Back to Index</a></p>
            </ul>
        <?php endif; ?>
    </div>
</body>

</html>