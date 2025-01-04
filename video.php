<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamCode = isset($_POST['team_code']) ? $_POST['team_code'] : null;
    $matchCode = isset($_POST['match_code']) ? $_POST['match_code'] : null;
    $videoPath = isset($_POST['video_path']) ? $_POST['video_path'] : null;

    if (!$teamCode || !$matchCode || !$videoPath) {
        $response = ['success' => false, 'message' => 'Team Code, Match Code, and Video Path are REQUIRED.'];
        echo json_encode($response);
        exit;
    }

    $scoutVideoFile = 'scout_video.txt';
    $videoData = "Team Code: $teamCode\nMatch Code: $matchCode\nVideo Path: $videoPath\n\n";

    if (file_put_contents($scoutVideoFile, $videoData, FILE_APPEND)) {
        $response = [
            'success' => true,
            'message' => 'Completed.',
            'file_link' => $videoPath
        ];
    } else {
        $response = ['success' => false, 'message' => 'Error saving data.'];
    }

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $teamname ?> <?php echo $team ?> | Video Upload</title>
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

        .error {
            color: red;
            font-size: 14px;
        }

        .success {
            color: green;
            font-size: 14px;
        }

        .progress-container {
            width: 100%;
            background: #f3f3f3;
            border-radius: 5px;
            margin-top: 20px;
        }

        .progress-bar {
            height: 20px;
            width: 0;
            background: #33bfe4;
            border-radius: 5px;
        }

        .progress-text {
            text-align: center;
            font-weight: bold;
            color: white;
            line-height: 20px;
            height: 100%;
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
        <br>
        <h1 style="font-size: 26px;">Scout Video</h1>
        <form id="uploadForm">
            <label for="team_code">Team Code:</label>
            <input type="text" id="team_code" name="team_code" required><br><br>

            <label for="match_code">Match Code:</label>
            <input type="text" id="match_code" name="match_code" required><br><br>

            <label for="video_file">Upload Video:</label>
            <input type="file" id="video_file" name="video" accept="video/*" required><br><br>

            <button type="submit" class="button">Upload Video</button><br><br>
        </form>

        <div class="progress-container" style="display: none;">
            <div class="progress-bar">
                <div class="progress-text">0%</div>
            </div>
        </div>

        <div id="responseMessage"></div>
    </div>
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
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData();
            const teamCode = document.getElementById('team_code').value;
            const matchCode = document.getElementById('match_code').value;
            const videoFile = document.getElementById('video_file').files[0];

            if (!teamCode || !matchCode || !videoFile) {
                document.getElementById('responseMessage').innerHTML = '<p class="error">Please fill in all fields</p>';
                return;
            }

            formData.append('team_code', teamCode);
            formData.append('match_code', matchCode);
            formData.append('video', videoFile);
            const progressContainer = document.querySelector('.progress-container');
            const progressBar = document.querySelector('.progress-bar');
            const progressText = document.querySelector('.progress-text');

            progressContainer.style.display = 'block';
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://api4.lfcup.cn/upload.php', true);

            xhr.upload.addEventListener('progress', function(event) {
                if (event.lengthComputable) {
                    const percent = Math.round((event.loaded / event.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressText.textContent = percent + '%';
                }
            });

            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById('responseMessage').innerHTML = `<p class="success">${response.message}</p><p>Video Link: <a href="${response.file_link}" target="_blank">${response.file_link}</a></p>`;

                    const saveData = new FormData();
                    saveData.append('team_code', teamCode);
                    saveData.append('match_code', matchCode);
                    saveData.append('video_path', response.file_link);

                    const saveXhr = new XMLHttpRequest();
                    saveXhr.open('POST', 'video.php', true);
                    saveXhr.onload = function() {
                        const saveResponse = JSON.parse(saveXhr.responseText);
                        if (saveResponse.success) {
                            document.getElementById('responseMessage').innerHTML += `<p class="success">${saveResponse.message}</p>`;
                        } else {
                            document.getElementById('responseMessage').innerHTML += `<p class="error">${saveResponse.message}</p>`;
                        }
                    };
                    saveXhr.send(saveData);
                } else {
                    document.getElementById('responseMessage').innerHTML = `<p class="error">${response.message}</p>`;
                }
                progressContainer.style.display = 'none';
            };

            xhr.onerror = function() {
                document.getElementById('responseMessage').innerHTML = '<p class="error">Upload failed. Please try again or contact admin.</p>';
                progressContainer.style.display = 'none';
            };

            xhr.send(formData);
        });
    </script>

</body>

</html>