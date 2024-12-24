<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teamCode = $_POST['team_code'] ?? '';
    $scoutData = $_POST['scout_data'] ?? [];

    $filename = "scout_data.txt";
    $fileContent = "Team Code: $teamCode\n";

    foreach ($scoutData as $key => $value) {
        $fileContent .= "$key: $value\n";
        $fileContent .= "---------------\n\n";
    }

    // 这里先存到txt文件里面，后面改数据库，先实现功能为主
    file_put_contents($filename, $fileContent, FILE_APPEND);
    echo "Data saved successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scout</title>
    <style>
        body {
            font-family: Arial Black, sans-serif;
            background-image: url("https://api.lfcup.cn/photo/files/67694b89cc17a.jpeg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        form {
            background: rgba(255, 255, 255, 0.6);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input,
        select,
        button {
            width: calc(100% - 20px);
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: rgb(46, 101, 159);
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(30, 79, 131);
        }

        .form-section {
            margin-bottom: 20px;
        }

        .add-button {
            display: inline-block;
            background-color: #28a745;
        }

        .add-button:hover {
            background-color: #218838;
        }

        .remove-button {
            background-color: #dc3545;
        }

        .remove-button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>


    <form method="POST">
        <div class="form-section">
            <label for="team_code">Team Code:</label>
            <input type="text" id="team_code" name="team_code" required>
        </div>
        <hr><br>
        <!-- 变量显示 -->
        <?php foreach ($variables as $variable): ?>
            <div class="form-section">
                <label for="<?= $variable['name'] ?>"><?= $variable['name'] ?>:</label>
                <?php if ($variable['type'] === 'number'): ?>
                    <input type="number" id="<?= $variable['name'] ?>" name="scout_data[<?= $variable['name'] ?>]">
                <?php elseif ($variable['type'] === 'select' && isset($variable['options'])): ?>
                    <select id="<?= $variable['name'] ?>" name="scout_data[<?= $variable['name'] ?>]">
                        <?php foreach ($variable['options'] as $option): ?>
                            <option value="<?= $option ?>"><?= $option ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit">Submit</button>
    </form>

</body>

</html>