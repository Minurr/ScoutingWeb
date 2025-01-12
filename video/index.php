<?php
session_start();
include '../config.php';
include '../permissions.php';
checkPermission(['媒体组','管理员','外联组']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamCode = isset($_POST['team_code']) ? $_POST['team_code'] : null;
    $matchCode = isset($_POST['match_code']) ? $_POST['match_code'] : null;
    $videoPath = isset($_POST['video_path']) ? $_POST['video_path'] : null;

    if (!$teamCode || !$matchCode || !$videoPath) {
        $response = ['success' => false, 'message' => 'REQUIRED.'];
        echo json_encode($response);
        exit;
    }

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
    <link href="../css/vdo_styles.css" rel="stylesheet">
    
    
</head>

<body class="dark">
    <?php include '../unify/header.php'; ?>
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
            <script type="text/javascript" src="../js/v_script.js"></script>
            <button type="submit" class="button">Upload Video</button><br><br>
        </form>

        <div class="progress-container" style="display: none;">
            <div class="progress-bar">
                <div class="progress-text">0%</div>
            </div>
        </div>

        <div id="responseMessage"></div>
    </div>
    <?php include '../unify/footer.php'; ?>
    
</body>

</html>