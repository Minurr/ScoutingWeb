<?php
include '../config.php';

$data = file_get_contents('../resource/data/scout_data.txt');
$alzFile = '../resource/data/alz.txt'; // 本地分析结果存储路径
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

    define('OPENAI_API_KEY', 'xxxxxxxxxxxxxxxxxxxxxxxxxxx');
    if (isset($_POST['action']) && $_POST['action'] === 'analyze') {
        $filePath = '../resource/data/scout_data.txt';

        if (!file_exists($filePath)) {
            echo json_encode(['success' => false, 'message' => 'Data file not found.']);
            exit;
        }

        $fileContent = file_get_contents($filePath);

        $apiUrl = "https://api.xx.xx/v1/chat/completions";
        $data = [
            "model" => "gemini-2.0-flash-thinking-exp-01-21",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a data analyst specialized in sports performance analysis."
                ],
                [
                    "role" => "user",
                    "content" => "Here is the scout data of multiple teams:\n\n$fileContent\n\nAnalyze the strengths and weaknesses of each team and return the results in a table format. make table well-formatted, you must should show it in html, and make a table with html/css tags. Our team is 5516. Analyze which team we should choose for the alliance and mark out.must not use markdown.just feedback me html,Let the strong team match 5516 to make up for the weaknesses of 5516.Provide certain data when showing weaknesses and strengths,表格紧凑，内容多，分两个表格，第一个显示全部队伍的数据，然后第二个显示优点和缺点还有5516应该选择那些队伍当5516的联盟队友（排名），还有理由，理由粗体写在两个表格上面的空白，深色模式深色模式，使用font-family: 'Poppins', sans-serif;，尽量使用中文，不要使用任何markdown文本，html内容也不需要用md文本```标注，
                   禁止输出除html主要部分以外的任何内容，只给我html内容，当普通文本发，css不要设置background-color之类会影响原网站样式的，适配手机端适配手机端，表格太长页面不够的时候，让他右划拖动展示剩下的，我用的是嵌入你的结果给我的网站"
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
    <script src="../js/chart_script.js"></script>
    <style>
        .chart-container {
            //background-color: rgb(255, 255, 255);
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        canvas {
            border: 2px solid rgba(132, 197, 255, 0.7);
            //cursor: pointer;
            height: 100%;
            width: 100%;
        }

        .button-container {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            justify-content: flex-start;
        }

        .button-container button {
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
            color: #333;
        }

        .button-container button:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body class="dark">
    <?php include '../unify/header.php'; ?>
    <div class="container">
        <?php if ($teamParam && isset($teams[$teamParam])): ?>
            <br>
            <h1 style="font-size: 26px;">    Team <?php echo htmlspecialchars($teamParam); ?>'s Data
            </h1>
            <hr>
            <?php if ($matchParam && isset($teams[$teamParam][$matchParam])): ?>
                <h2>    Match <?php echo htmlspecialchars($matchParam); ?></h2>
                <hr>
                <!-- 原数据展示方案 
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

                        </tbody>
                    </table>
                </div>
                -->
                <div class="chart-container">
                    
                    <canvas id="matchDataChart"></canvas>
                    <br>
                </div>
                <hr>
                <p>Path Drawing</p>
                <canvas id="canvas"></canvas>
                <div class="button-container">
                    <button id="saveButton" onclick="saveImage()">Download</button>
                    <button id="resetButton">Reset</button>
                    <button id="groupButton">Switch Base</button>
                </div>

                <hr>
                <div>
                    <h3>Video</h3>
                    <?php
                    echo "<video width='100%' controls><source src='" . htmlspecialchars($videos[$teamParam][$matchParam]) . "' type='video/mp4'>Your browser does not support the video tag.</video>";
                    ?>
                </div>

                <br>
                <p class="p2"><a class="a2" href="../view?team=<?php echo urlencode($teamParam); ?>">Back to Team</a></p>
            <?php else: ?>
                <h2 style="font-size: 18px;">    Matches List</h2><br>

                <ul>
                    <?php
                    foreach ($teams[$teamParam] as $matchCode => $matchData): ?>
                        <li><a class="a2"
                                href="../view?team=<?php echo urlencode($teamParam); ?>&match=<?php echo urlencode($matchCode); ?>"><?php echo "    Match " . htmlspecialchars($matchCode); ?></a>
                        </li>
                    <?php endforeach; ?>
                    <hr>
                    <p class="p2"><a class="a2" href="./"> Back to All-Team</a></p>
                </ul>
            <?php endif; ?>
        <?php else: ?>
            <br>
            <h1 style="font-size: 26px;">    Team List</h1>
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
                    <li>    <a class="a2"
                            href="../view?team=<?php echo urlencode($teamCode); ?>">F<?php echo $com_type ?>
                            #<?php echo htmlspecialchars($teamCode); ?></a></li>
                <?php endforeach; ?>
            </ul>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <?php endif; ?>
    </div>
    <?php include '../unify/footer.php'; ?>
    <script><?php include '../js/ai_script.js'; ?></script>
    <script>
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");
        const img = new Image();
        

        const imageSources = ["../resource/bg.png", "../resource/bg2.png"];
        let currentImageIndex = 0;

        let points = [];
        let draggingPoint = null;

        function saveDrawing() {
            const teamId = '<?php echo htmlspecialchars($teamParam); ?>';
            const matchCode = '<?php echo htmlspecialchars($matchParam); ?>';
            const data = {
                teamId: teamId,
                matchCode: matchCode,
                points: points
            };
        
            fetch('./save_drawing.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    console.log("Points saved successfully.");
                } else {
                    console.error("Error saving points:", result.message);
                }
            });
        }


        function loadDrawing() {
            const teamId = '<?php echo htmlspecialchars($teamParam); ?>';
            const matchCode = '<?php echo htmlspecialchars($matchParam); ?>';
        
            fetch(`./load_drawing.php?teamId=${teamId}&matchCode=${matchCode}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        points = result.points || [];
                        img.src = imageSources[currentImageIndex];
                        img.onload = function() {
                            canvas.width = img.width;
                            canvas.height = img.height;
                            ctx.drawImage(img, 0, 0);
                            draw();
                        };
                    } else {
                        console.error("Error loading points:", result.message);
                    }
                });
        }


        function resetCanvas() {
            points = [];
            localStorage.removeItem('drawingPoints');
            localStorage.removeItem('currentImageIndex');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0);
        }

        loadDrawing();
        
        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0);
            if (points.length > 1) {
                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);
                for (let i = 1; i < points.length - 1; i++) {
                    const xc = (points[i].x + points[i + 1].x) / 2;
                    const yc = (points[i].y + points[i + 1].y) / 2;
                    ctx.quadraticCurveTo(points[i].x, points[i].y, xc, yc);
                }
                ctx.lineTo(points[points.length - 1].x, points[points.length - 1].y);
                ctx.strokeStyle = "red";
                ctx.lineWidth = 12;
                ctx.stroke();
            }
            points.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, 15, 0, Math.PI * 2);
                ctx.fillStyle = "blue";
                ctx.fill();
            });
        }

        canvas.addEventListener("mousedown", (e) => {
            const rect = canvas.getBoundingClientRect();
            let x = e.clientX - rect.left;
            let y = e.clientY - rect.top;

            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;

            x *= scaleX;
            y *= scaleY;

            draggingPoint = points.find(p => Math.hypot(p.x - x, p.y - y) < 5);
            if (!draggingPoint) {
                points.push({ x, y });
                draw();
                saveDrawing();
            }
        });

        canvas.addEventListener("mousemove", (e) => {
            if (draggingPoint) {
                const rect = canvas.getBoundingClientRect();
                let x = e.clientX - rect.left;
                let y = e.clientY - rect.top;

                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;

                x *= scaleX;
                y *= scaleY;

                draggingPoint.x = x;
                draggingPoint.y = y;
                draw();
                saveDrawing();
            };
            
        canvas.addEventListener("mouseup", () => draggingPoint = null);
        
        });
        
        

        function saveImage() {
            const link = document.createElement("a");
            link.download = "modified.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
        }

        document.getElementById('resetButton').addEventListener('click', resetCanvas);

        document.getElementById('groupButton').addEventListener('click', () => {
            currentImageIndex = (currentImageIndex + 1) % imageSources.length;
            img.src = imageSources[currentImageIndex];
            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                draw();
                saveDrawing();
            };
        });
    </script>

    <script>
        <?php
        $matchData = $teams[$teamParam][$matchParam];
        $labels = [];
        $values = [];
        foreach ($matchData as $key => $value) {
            if (is_numeric($value)) {
                $labels[] = $key;
                $values[] = $value;
            }
        }
        ?>

        const ctxChart = document.getElementById('matchDataChart').getContext('2d');
        new Chart(ctxChart, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Match Data',
                    data: <?php echo json_encode($values); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: false,
                        text: "#<?php echo htmlspecialchars($teamParam); ?>'s Match Data"
                    }
                }
            }
        });
    </script>

</html>
