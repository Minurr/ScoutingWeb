<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team = $_POST['team'] ?? '';
    $teamname = $_POST['teamname'] ?? '';
    $variables = [];

    foreach ($_POST['variable_name'] as $index => $name) {
        $type = $_POST['variable_type'][$index];
        $variable = ["name" => $name, "type" => $type];

        if ($type == 'select' && isset($_POST['variable_options'][$index])) {
            $variable['options'] = array_filter($_POST['variable_options'][$index], fn($option) => !empty($option));
        } else {
            $variable['options'] = [];
        }

        $variables[] = $variable;
    }

    $php_code = "<?php\n\$team = '$team';\n\$teamname = '$teamname';\n\$variables = " . var_export($variables, true) . ";";

    if (eval('?>' . $php_code) === false) {
        die('114(nooooo<br>check the configs php');
    }

    file_put_contents('config.php', $php_code);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IronMaple Scout Admin</title>
    <style>
        body {
            font-family: Arial Black;
            background-image: url("https://api.lfcup.cn/photo/files/67694b89cc17a.jpeg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        form {
            background: rgba(255, 255, 255, 0.64);
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
            background-color: #33bfe4;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #31a8c7;
        }

        .variable,
        .options {
            margin-bottom: 20px;
        }

        .options-container {
            padding-left: 15px;
            border-left: 2px solid #ddd;
        }

        .add-button {
            display: inline-block;
            margin-top: 10px;
            background-color: #15b8e2;
        }

        .add-button:hover {
            background-color: #18a5c9;
        }

        .remove-button {
            background-color: rgb(206, 33, 85);
            margin-top: 10px;
        }

        .remove-button:hover {
            background-color: rgb(153, 15, 54);
        }
    </style>
</head>

<body>
    <form method="POST">
        <h1>IM Scout Admin</h1>
        <label>Team Code (No Required):</label>
        <input type="text" name="team" />

        <label>Team Name (No Required):</label>
        <input type="text" name="teamname" />
        <br>
        <hr>
        <br>
        <div id="variables">
            <?php foreach ($variables as $index => $variable): ?>
                <div class="variable">
                    <label>Variable Name:</label>
                    <input type="text" name="variable_name[]" value="<?= $variable['name'] ?>" required />

                    <label>Type:</label>
                    <select name="variable_type[]" onchange="updateOptions(this)" required>
                        <option value="number" <?= $variable['type'] == 'number' ? 'selected' : '' ?>>Number</option>
                        <option value="select" <?= $variable['type'] == 'select' ? 'selected' : '' ?>>Select</option>
                    </select>

                    <div class="options-container" style="display: <?= $variable['type'] == 'select' ? 'block' : 'none' ?>;">
                        <label>Options:</label>
                        <?php foreach ($variable['options'] as $option): ?>
                            <input type="text" name="variable_options[<?= $index ?>][]" value="<?= $option ?>" placeholder="Option" />
                        <?php endforeach; ?>
                        <button type="button" onclick="addOption(this)">Add Option</button>
                    </div>

                    <button type="button" class="remove-button" onclick="removeVariable(this)">Remove Variable</button>
                </div>
                <hr><br>
            <?php endforeach; ?>
        </div>

        <button type="button" onclick="addVariable()">Add Variable</button>
        <button type="submit">Save</button>
    </form>

    <script>
        function addVariable() {
            const variablesDiv = document.getElementById('variables');
            const variableCount = document.querySelectorAll('.variable').length;
            const variableTemplate = `
                <div class="variable">
                    <label>Variable Name:</label>
                    <input type="text" name="variable_name[]" required />

                    <label>Type:</label>
                    <select name="variable_type[]" onchange="updateOptions(this)" required>
                        <option value="number">Number</option>
                        <option value="select">Select</option>
                    </select>

                    <div class="options-container" style="display: none;">
                        <label>Options:</label>
                        <div class="options">
                            <input type="text" name="variable_options[${variableCount}][]" placeholder="Option" />
                            <button type="button" onclick="addOption(this)">Add Option</button>
                        </div>
                    </div>

                    <button type="button" class="remove-button" onclick="removeVariable(this)">Remove Variable</button>
                    <hr><br>
                </div>`;
            variablesDiv.insertAdjacentHTML('beforeend', variableTemplate);
        }

        function addOption(button) {
            const optionsDiv = button.parentElement;
            const variableIndex = Array.from(optionsDiv.parentElement.parentElement.children).indexOf(optionsDiv.parentElement);
            const optionTemplate = `<input type="text" name="variable_options[${variableIndex}][]" placeholder="Option" />`;
            optionsDiv.insertAdjacentHTML('beforeend', optionTemplate);
        }

        function removeVariable(button) {
            button.parentElement.remove();
        }

        function updateOptions(select) {
            const optionsContainer = select.parentElement.querySelector('.options-container');
            optionsContainer.style.display = select.value === 'select' ? 'block' : 'none';
        }
    </script>
</body>
</html>
