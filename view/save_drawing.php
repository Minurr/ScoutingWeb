<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['teamId']) && isset($data['matchCode']) && isset($data['points']) && isset($data['imageIndex'])) {
    $teamId = $data['teamId'];
    $matchCode = $data['matchCode'];
    $points = $data['points'];
    $imageIndex = $data['imageIndex'];

    $filePath = "../resource/data/points/{$teamId}_{$matchCode}_points.json";

    $result = file_put_contents($filePath, json_encode($points));

    if ($result === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to save points data.']);
    } else {
        echo json_encode(['success' => true, 'message' => 'Points saved successfully.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}
?>
