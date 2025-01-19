<?php
session_start();
include '../config.php';
include '../permissions.php';
checkPermission(['媒体组', '管理员', '外联组']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamCode = isset($_POST['team_code']) ? $_POST['team_code'] : null;
    $matchCode = isset($_POST['match_code']) ? $_POST['match_code'] : null;
    $videoFile = isset($_FILES['video']) ? $_FILES['video'] : null;

    // 检查是否填写了必要的字段
    if (!$teamCode || !$matchCode || !$videoFile) {
        $response = ['success' => false, 'message' => 'REQUIRED.'];
        echo json_encode($response);
        exit;
    }

    // 上传视频文件
    $uploadDir = '../resource/videos/';  // 你的视频存储路径
    $videoPath = $uploadDir . basename($videoFile['name']);

    if (move_uploaded_file($videoFile['tmp_name'], $videoPath)) {
        // 文件成功上传，保存视频数据
        $scoutVideoFile = '../resource/data/scout_video.txt';
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
    } else {
        $response = ['success' => false, 'message' => 'Error uploading video.'];
    }

    // 返回 JSON 响应
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="../favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | Video Upload</title>
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/vdo_styles.css" rel="stylesheet">
    <script src="https://unpkg.com/sober/dist/sober.min.js"></script>
</head>

<body class="dark">
    <?php include '../unify/header.php'; ?>
    <div class="container">
        <br>
        <h1 style="font-size: 26px;">Scout Video</h1>
        <form id="uploadForm" enctype="multipart/form-data">
            <label for="team_code">Team Code:</label>
            <input type="text" id="team_code" name="team_code" required><br><br>

            <label for="match_code">Match Code:</label>
            <input type="text" id="match_code" name="match_code" required><br><br>

            <label for="video_file">Upload Video:</label>
            <input type="file" id="video_file" name="video" accept="video/*" required><br><br>

            <s-button id="uploadButton" slot="action" class="button"> Upload </s-button>
        </form>

        <div class="progress-container" style="display: none;">
            <div class="progress-bar">
                <div class="progress-text">0%</div>
            </div>
        </div>

        <div id="responseMessage"></div>
    </div>
    <?php include '../unify/footer.php'; ?>
    <script>
        const uploadButton = document.getElementById('uploadButton');

        uploadButton.addEventListener('click', function (event) {
            event.preventDefault();

            const form = document.getElementById('uploadForm');
            const teamCode = document.getElementById('team_code').value;
            const matchCode = document.getElementById('match_code').value;
            const videoFile = document.getElementById('video_file').files[0];

            if (!teamCode || !matchCode || !videoFile) {
                document.getElementById('responseMessage').innerHTML = '<p class="error">Please fill in all fields</p>';
                return;
            }

            const formData = new FormData();
            formData.append('team_code', teamCode);
            formData.append('match_code', matchCode);
            formData.append('video', videoFile);

            const progressContainer = document.querySelector('.progress-container');
            const progressBar = document.querySelector('.progress-bar');
            const progressText = document.querySelector('.progress-text');

            progressContainer.style.display = 'block';
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://api4.lfcup.cn/upload.php', true);

            xhr.upload.addEventListener('progress', function (event) {
                if (event.lengthComputable) {
                    const percent = Math.round((event.loaded / event.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressText.textContent = percent + '%';
                }
            });

            xhr.onload = function () {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById('responseMessage').innerHTML = `<p class="success">${response.message}</p><p>Video Link: <a href="${response.file_link}" target="_blank">${response.file_link}</a></p>`;

                    const saveData = new FormData();
                    saveData.append('team_code', teamCode);
                    saveData.append('match_code', matchCode);
                    saveData.append('video_path', response.file_link);

                    const saveXhr = new XMLHttpRequest();
                    saveXhr.open('POST', './video.php', true);
                    saveXhr.onload = function () {
                        const saveResponse = JSON.parse(saveXhr.responseText);
                        if (saveResponse.success) {
                            document.getElementById('responseMessage').innerHTML += `<p class="success">${saveResponse.message}</p>`;
                        } else {
                            document.getElementById('responseMessage').innerHTML += `<p class="error">${saveResponse.message}</p>`;
                        }
                    };
                    saveXhr.onerror = function () {
                        document.getElementById('responseMessage').innerHTML = '<p class="error">Saving video failed. Please try again.</p>';
                    };
                    saveXhr.send(saveData);
                } else {
                    document.getElementById('responseMessage').innerHTML = `<p class="error">${response.message}</p>`;
                }
                progressContainer.style.display = 'none';
            };

            xhr.onerror = function () {
                document.getElementById('responseMessage').innerHTML = '<p class="error">Upload failed. Please try again or contact admin.</p>';
                progressContainer.style.display = 'none';
            };

            xhr.send(formData);
        });
    </script>

</body>

</html>