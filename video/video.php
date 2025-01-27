<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $teamCode = isset($_POST['team_code']) ? $_POST['team_code'] : null;
    $matchCode = isset($_POST['match_code']) ? $_POST['match_code'] : null;
    $videoPath = isset($_POST['video_path']) ? $_POST['video_path'] : null;

    if (!$teamCode || !$matchCode || !$videoPath) {
        $response = ['success' => false, 'message' => 'Missing required fields.'];
        echo json_encode($response);
        exit;
    }

    $scoutVideoFile = '../resource/data/scout_video.txt';

    $videoData = "Team Code: $teamCode\nMatch Code: $matchCode\nVideo Path: $videoPath\n\n";

    if (file_put_contents($scoutVideoFile, $videoData, FILE_APPEND)) {

        $response = [
            'success' => true,
            'message' => 'Data saved successfully.',
            'file_path' => realpath($scoutVideoFile)
        ];
    } else {

        $response = ['success' => false, 'message' => 'Failed to save data. Please check file permissions.'];
    }

    echo json_encode($response);
    exit;
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
    echo json_encode($response);
    exit;
}