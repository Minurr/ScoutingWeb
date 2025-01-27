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
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/sco_styles.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            background:rgba(24, 112, 134, 0.205);
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 30px;
        }
    </style>
</head>

<body class="dark">
    <?php include '../unify/header.php'; ?>
    <div class="container">
        <form class="f1orm" method="POST">
            <s-page theme="dark" style="background-color:rgba(255, 255, 255, 0)">
                <s-dialog>
                    <s-button slot="trigger"> Can't understand form? Click me. </s-button>
                    <div slot="headline"> Tips </div>
                    <div slot="text">
                        Regarding the [L(1-4) Coral] in the Scout form, <br>Refer to the following diagram for explanation:<br><br>
                        <img src="../resource/222.png" alt="L1-4" />
                    </div>
                    <s-button slot="action" type="text" id="button1">STILL NOT...</s-button>
                    <s-button slot="action" type="text">YES!</s-button>
                </s-dialog>
            </s-page><br>
            <div class="form-section">
                <label for="team_code">
                <input type="text" id="team_code" name="team_code" placeholder="Team Code" required></label>

                <label for="match_code">
                <input type="text" id="match_type" name="match_type" placeholder="Match Type" value="Qualification" required></label>

                <label for="match_code">
                <input type="number" id="match_code" name="match_code" placeholder="Match Code" required></label>
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
    </div>
    <?php include '../unify/footer.php'; ?>
    <script>
        const buttons = document.querySelectorAll('s-button');

        buttons.forEach(button => {
            button.onclick = function () {
                const buttonId = button.id;

                if (buttonId === 'button1') {
                    alert("What?.. Can't you just go and read the document yourself? Who will teach you?!");
                    window.location.href = 'https://firstfrc.blob.core.windows.net/frc2025/Manual/2025GameManual.pdf';
                }
            };
        });
    </script>
</body>

</html>