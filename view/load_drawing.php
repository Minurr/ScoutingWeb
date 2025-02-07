<?php
// Load drawing points for the specific team and match
header('Content-Type: application/json');
$teamId = $_GET['teamId'] ?? null;
$matchCode = $_GET['matchCode'] ?? null;

if ($teamId && $matchCode) {
    $filePath = "../resource/data/points/{$teamId}_{$matchCode}_points.json";

    if (file_exists($filePath)) {
        $points = json_decode(file_get_contents($filePath), true);
        echo json_encode(['success' => true, 'points' => $points]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Points data not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid team ID or match code.']);
}
?>
