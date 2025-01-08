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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    define('OPENAI_API_KEY', '[你的key]');
    if (isset($_POST['action']) && $_POST['action'] === 'analyze') {
        $filePath = 'scout_data.txt';

        if (!file_exists($filePath)) {
            echo json_encode(['success' => false, 'message' => 'Data file not found.']);
            exit;
        }

        $fileContent = file_get_contents($filePath);

        $apiUrl = "https://api.openai.com/v1/chat/completions";
        $data = [
            "model" => "gpt-4o-mini",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a data analyst specialized in sports performance analysis."
                ],
                [
                    "role" => "user",
                    "content" => "Here is the scout data of multiple teams:\n\n$fileContent\n\nAnalyze the strengths and weaknesses of each team and return the results in a table format. make table well-formatted, you must should show it in html, and make a table with html/css tags. Our team is 5516. Analyze which team we should choose for the alliance and mark out.must not use markdown.just feedback me html, dont use ```html xxx ``` or else.Let the strong team match 5516 to make up for the weaknesses of 5516.Provide certain data when showing weaknesses and strengths,表格紧凑，内容多，分两个表格，第一个显示全部队伍的数据，然后第二个显示优点和缺点还有5516应该选择哪一个队伍当5516的联盟队友，还有理由，理由粗体写在两个表格上面的空白，深色模式深色模式，使用font-family: 'Poppins', sans-serif;，尽量使用中文，不要使用任何markdown文本，html内容也不需要用md文本[```html xxx ``` ]标注，不要css设置background，我用的是嵌入你的结果给我的网站"
                ]
            ]
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . OPENAI_API_KEY
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $responseData = json_decode($response, true);
            $analysis = $responseData['choices'][0]['message']['content'];
            echo json_encode(['success' => true, 'analysis' => $analysis]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to fetch analysis.', 'details' => $response]);
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="favicon.ico">
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
            background-image: url('https://api.lfcup.cn/photo/files/677bb07f3a332.webp');
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
        .container {
            max-width: 800px;
            margin: 0 auto;
            background:rgba(0, 0, 0, 0.34);
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
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
            <h1 style="font-size: 26px;">&nbsp;&nbsp;&nbsp;&nbsp;Team <?php echo htmlspecialchars($teamParam); ?>'s Data</h1>
            <hr>
            <?php if ($matchParam && isset($teams[$teamParam][$matchParam])): ?>
                <h2>&nbsp;&nbsp;&nbsp;&nbsp;Match <?php echo htmlspecialchars($matchParam); ?></h2>
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
                <h2 style="font-size: 18px;">&nbsp;&nbsp;&nbsp;&nbsp;Matches List 比赛列表</h2><br>
                
                <ul>
                    <?php
                    foreach ($teams[$teamParam] as $matchCode => $matchData): ?>
                        <li><a class="a2" href="./view.php?team=<?php echo urlencode($teamParam); ?>&match=<?php echo urlencode($matchCode); ?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;Match ".htmlspecialchars($matchCode); ?></a></li>
                    <?php endforeach; ?>
                    <hr>
                    <p class="p2"><a class="a2" href="./view.php">&nbsp;Back to All-Team</a></p>
                </ul>
            <?php endif; ?>
        <?php else: ?>
            <br>
            <h1 style="font-size: 26px;">&nbsp;&nbsp;&nbsp;&nbsp;Team List 队伍列表</h1>    
            <div class="container">
                <button id="analyzeButton"><p style="color: #FF5722">点击分析队伍数据</p></button>
                    <div id="output" class="output"></div>
            </div>
            <hr>
            <ul>
                <?php
                foreach ($teams as $teamCode => $matchList): ?>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;<a class="a2" href="./view.php?team=<?php echo urlencode($teamCode); ?>">F<?php echo $com_type ?> #<?php echo htmlspecialchars($teamCode); ?></a></li>
                <?php endforeach; ?>
            </ul>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
    <script>
        document.getElementById('analyzeButton').addEventListener('click', function() {
            const output = document.getElementById('output');
            output.textContent = "IronMaple-AI分析数据中，请稍后...";

            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=analyze'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    output.innerHTML = data.analysis;
                } else {
                    output.innerHTML = `<span class="error">Error: ${data.message}</span>`;
                }
            })
            .catch(error => {
                output.innerHTML = `<span class="error">An unexpected error occurred: ${error}</span>`;
            });
        });
    </script>
</body>

</html>