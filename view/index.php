<?php
include '../config.php';

$data = file_get_contents('../resource/data/scout_data.txt');
$alzFile = '../resource/data/alz.txt';
$teamParam = $_GET['team'] ?? null;
$matchParam = $_GET['match'] ?? null;

$historyAnalysis = '';
if (file_exists($alzFile)) {
    $historyAnalysis = file_get_contents($alzFile);
}

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
$videoData = file_get_contents('../resource/data/scout_video.txt');
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

    define('OPENAI_API_KEY', 'sk-');
    if (isset($_POST['action']) && $_POST['action'] === 'analyze') {
        $filePath = '../resource/data/scout_data.txt';

        if (!file_exists($filePath)) {
            echo json_encode(['success' => false, 'message' => 'Data file not found.']);
            exit;
        }

        $fileContent = file_get_contents($filePath);

        $apiUrl = "https://api.xx.xx/v1/chat/completions";
        $data = [
            "model" => "gemini-exp-1121",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a data analyst specialized in sports performance analysis."
                ],
                [
                    "role" => "user",
                    "content" => "Here is the scout data of multiple teams:\n\n$fileContent\n\nAnalyze the strengths and weaknesses of each team and return the results in a table format. make table well-formatted, you must should show it in html, and make a table with html/css tags. Our team is 5516. Analyze which team we should choose for the alliance and mark out.must not use markdown.just feedback me html,Let the strong team match 5516 to make up for the weaknesses of 5516.Provide certain data when showing weaknesses and strengths,表格紧凑，内容多，分两个表格，第一个显示全部队伍的数据，然后第二个显示优点和缺点还有5516应该选择那些队伍当5516的联盟队友（排名），还有理由，理由粗体写在两个表格上面的空白，深色模式深色模式，使用font-family: 'Poppins', sans-serif;，全都使用英文，不要使用任何markdown文本，html内容也不需要用md文本```标注，
                   禁止输出除html主要部分以外的任何内容，只给我html内容，当普通文本发，css不要设置background-color之类会影响原网站样式的，适配手机端适配手机端，表格太长页面不够的时候，让他右划拖动展示剩下的，一定要让表格能够完整显示文字，不要让它挤着，让他右划拖动展示剩下的，我用的是嵌入你的结果给我的网站"
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
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="../favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | SCOUT <?php echo $com_type ?></title>
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/v_styles.css" rel="stylesheet">
</head>

<body class="dark">
    <?php include '../unify/header.php'; ?>
    <div class="container">
        <?php if ($teamParam && isset($teams[$teamParam])): ?>
            <br>
            <h1 style="font-size: 26px;">&nbsp;&nbsp;&nbsp;&nbsp;Team <?php echo htmlspecialchars($teamParam); ?>'s Data
            </h1>
            <hr>
            <?php if ($matchParam && isset($teams[$teamParam][$matchParam])): ?>
                <h2>&nbsp;&nbsp;&nbsp;&nbsp;Match <?php echo htmlspecialchars($matchParam); ?></h2>
                <hr>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Data</th>
                                </th>
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
                <p class="p2"><a class="a2" href="../view?team=<?php echo urlencode($teamParam); ?>">Back to Team</a></p>
            <?php else: ?>
                <h2 style="font-size: 18px;">&nbsp;&nbsp;&nbsp;&nbsp;Matches List</h2><br>

                <ul>
                    <?php
                    foreach ($teams[$teamParam] as $matchCode => $matchData): ?>
                        <li><a class="a2"
                                href="../view?team=<?php echo urlencode($teamParam); ?>&match=<?php echo urlencode($matchCode); ?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;Match " . htmlspecialchars($matchCode); ?></a>
                        </li>
                    <?php endforeach; ?>
                    <hr>
                    <p class="p2"><a class="a2" href="./">&nbsp;Back to All-Team</a></p>
                </ul>
            <?php endif; ?>
        <?php else: ?>
            <br>
            <h1 style="font-size: 26px;">&nbsp;&nbsp;&nbsp;&nbsp;Team List</h1>
            <br>
            <div class="container2">
                <button id="analyzeButton">
                    <p style="color: #FF5722">Cilck to Analyze Data</p>
                </button>
                <div id="output" class="output"></div>
                
                <?php if ($historyAnalysis): ?>
                    <div class="analysis-history">
                        <div><?php echo $historyAnalysis; ?></div>
                    </div>
                    <hr>
                <?php endif; ?>
                
            </div>
            <hr>
            <ul>
                <?php
                foreach ($teams as $teamCode => $matchList): ?>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;<a class="a2"
                            href="../view?team=<?php echo urlencode($teamCode); ?>">F<?php echo $com_type ?>
                            #<?php echo htmlspecialchars($teamCode); ?></a></li>
                <?php endforeach; ?>
            </ul>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <?php endif; ?>
    </div>
    <?php include '../unify/footer.php'; ?>
    <script><?php include '../js/ai_script.js'; ?></script>

</html>
