<?php
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scout Video</title>
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
            max-width: 600px;
            margin: 0px auto;
            background-color: rgba(255, 255, 255, 0.63);
            padding: 30px;
            //border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #33bfe4;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #31a8c7;
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
<body>

<div class="container">
    <h1>Scout Video</h1>
    <form id="uploadForm">
        <label for="team_code">Team Code:</label>
        <input type="text" id="team_code" name="team_code" required>

        <label for="match_code">Match Code:</label>
        <input type="text" id="match_code" name="match_code" required>

        <label for="video_file">Upload Video:</label>
        <input type="file" id="video_file" name="video" accept="video/*" required>

        <button type="submit">Upload Video</button>
    </form>

    <div class="progress-container" style="display: none;">
        <div class="progress-bar">
            <div class="progress-text">0%</div>
        </div>
    </div>

    <div id="responseMessage"></div>
</div>

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
