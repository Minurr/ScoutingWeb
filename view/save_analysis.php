<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $analysis = $input['analysis'] ?? '';

    if ($analysis) {
        $filePath = '../resource/data/alz.txt';
        
        file_put_contents($filePath, $analysis . "\n\n");

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => '没有有效的分析数据。']);
    }
    exit;
}
?>
