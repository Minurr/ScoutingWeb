<?php
session_start();
include '../config.php';

// 检查是否为 POST 请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取 POST 数据
    $teamCode = isset($_POST['team_code']) ? $_POST['team_code'] : null;
    $matchCode = isset($_POST['match_code']) ? $_POST['match_code'] : null;
    $videoPath = isset($_POST['video_path']) ? $_POST['video_path'] : null;

    // 检查必填字段是否为空
    if (!$teamCode || !$matchCode || !$videoPath) {
        $response = ['success' => false, 'message' => 'Missing required fields.'];
        echo json_encode($response);
        exit;
    }

    // 文件保存路径
    $scoutVideoFile = '../resource/data/scout_video.txt';

    // 写入内容
    $videoData = "Team Code: $teamCode\nMatch Code: $matchCode\nVideo Path: $videoPath\n\n";

    // 尝试写入文件
    if (file_put_contents($scoutVideoFile, $videoData, FILE_APPEND)) {
        // 成功返回响应
        $response = [
            'success' => true,
            'message' => 'Data saved successfully.',
            'file_path' => realpath($scoutVideoFile) // 返回文件路径
        ];
    } else {
        // 写入失败返回响应
        $response = ['success' => false, 'message' => 'Failed to save data. Please check file permissions.'];
    }

    // 返回 JSON 响应
    echo json_encode($response);
    exit;
} else {
    // 非 POST 请求返回错误
    $response = ['success' => false, 'message' => 'Invalid request method.'];
    echo json_encode($response);
    exit;
}