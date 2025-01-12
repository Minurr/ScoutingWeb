<?php
session_start();
include '../config.php';
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teamCode = $_POST['team_code'] ?? '';
    $matchCode = $_POST['match_code'] ?? '';
    $matchType = $_POST['match_type'] ?? '';
    $scoutData = $_POST['scout_data'] ?? [];

    $filename = "../resource/data/scout_data.txt";
    $fileContent = "Team Code: $teamCode\nMatch Code: $matchCode\nMatch Type: $matchType\n";

    foreach ($scoutData as $key => $value) {
        $fileContent .= "$key: $value\n";
    }

    // 这里先存到txt文件里面，后面改数据库，先实现功能为主
    file_put_contents($filename, $fileContent, FILE_APPEND);
    echo "Data saved successfully.";
}
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | SCOUTING</title>
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/sco_styles.css" rel="stylesheet">
</head>

<body class="dark">
    <?php include '../unify/header.php'; ?>
    <form class="f1orm" method="POST">
        <div class="form-section">
            <label for="team_code">Team Code:
            <input type="text" id="team_code" name="team_code" required></label>

            <label for="match_code">Match Type:
            <input type="text" id="match_type" name="match_type" required></label>

            <label for="match_code">Match Code:
            <input type="number" id="match_code" name="match_code" required></label>
        </div>
        <hr><br>
        <?php foreach ($variables as $variable): ?>
            <div class="form-section">
                <label for="<?= $variable['name'] ?>"><?= $variable['name'] ?>:</label>
                <?php if ($variable['type'] === 'number'): ?>
                    <input type="number" id="<?= $variable['name'] ?>" name="scout_data[<?= $variable['name'] ?>]">
                <?php elseif ($variable['type'] === 'select' && isset($variable['options'])): ?>
                    <select style="color:black" id="<?= $variable['name'] ?>" name="scout_data[<?= $variable['name'] ?>]">
                        <?php foreach ($variable['options'] as $option): ?>
                            <option style="color:black" value="<?= $option ?>"><?= $option ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <input type="submit" value="Submit">
    </form>

    <?php include '../unify/footer.php'; ?>
</body>

</html>