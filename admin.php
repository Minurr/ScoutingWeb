<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team = $_POST['team'] ?? '';
    $teamname = $_POST['teamname'] ?? '';
    $com_type = $_POST['com_type'] ?? '';
    $variables = [];

    foreach ($_POST['variable_name'] as $index => $name) {
        $type = $_POST['variable_type'][$index];
        $variable = ["name" => $name, "type" => $type];

        if ($type == 'select' && isset($_POST['variable_options'][$index])) {
            $variable['options'] = array_filter($_POST['variable_options'][$index], fn($option) => !empty ($option));
        } else {
            $variable['options'] = [];
        }

        $variables[] = $variable;
    }

    $php_code = "<?php\n\$team = '$team';\n\$teamname = '$teamname';\n\$com_type = '$com_type';\n\$variables = " . var_export($variables, true) . ";";

    if (eval ('?>' . $php_code) === false) {
        die('114(nooooo<br>check the configs php');
    }

    file_put_contents('config.php', $php_code);
}
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $teamname ?> <?php echo $team ?> | Admin Site</title>
    <link href="./styles2.css" rel="stylesheet">
    <link href="./styles3.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #eaeaea;
            font-family: 'Poppins', sans-serif;
        }

        h1 {
            text-transform: uppercase;
        }

        .hero-section {
            background-image: url('https://api4.lfcup.cn/photo/bj.jpg');
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(8px);
            padding: 50px;
            border-radius: 20px;
            color: white;
            margin: 8px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 30px;
            margin: 8px;
            backdrop-filter: blur(6px);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.04);
        }

        .button {
            background-color: #FF5722;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #FF784E;
        }

        footer {
            margin-top: 30px;
            border-top: 2px solid #fff;
            padding-top: 20px;
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .footer-logo img {
            max-width: 150px;
        }

        .footer-sponsor {
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #ccc;
        }
        .inline-form {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .inline-form label {
            font-size: 16px;
            font-weight: bold;
            color: #e0e0e0;
        }

        .inline-form input[type="text"] {
            flex: 1;
            max-width: 300px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            outline: none;
            transition: all 0.3s;
        }

        .inline-form input[type="text"]:focus {
            background-color: #444;
        }

        .inline-form input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #5e6f78;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .inline-form input[type="submit"]:hover {
            background-color: #4a565f;
        }
        form {
            margin-top: 20px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #e0e0e0;
        }

        input[type="text"] {
            width: 60%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            outline: none;
            transition: all 0.3s;
        }

        input[type="text"]:focus {
            background-color: #444;
        }

        .i2nput[type="submit"] {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #5e6f78;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .i2nput[type="submit"]:hover {
            background-color: #4a565f;
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

<body class="dark">
    <br>
    <header class="text-center p-5">
        <a href="./"><h1 class="text-4xl font-semibold"><?php echo $teamname ?> SCOUT</h1></a>
<br><h2>A group of high school students from Shenzhen (Nanshan) Concord College of Sino-Canada formed a team with passion.</h2>
    </header>
    <section class="hero-section">
        <h2>F<?php echo $com_type ?>#<?php echo $team ?></h2>
        <h2 class="text-2xl">欢迎来到 F<?php echo $com_type ?> 2025</h2>
        <p>这里是<?php echo $teamname ?>的SCOUT网站，你可以在这里找到各种类型的数据和技巧、分类。</p>
    </section>
    <form method="POST">
        <label>Team Code (No Required):</label><br>
        <input type="text" name="team" value="<?= htmlspecialchars($team) ?>" /><br>

        <label>Team Name (No Required):</label><br>
        <input type="text" name="teamname" value="<?= htmlspecialchars($teamname) ?>" /><br>

        <label>Competition Type (No Required):<br></label>
        <input type="text" name="com_type" value="<?= htmlspecialchars($com_type) ?>" /><br>
        <br>
        <hr>
        <br>
        <div id="variables">
            <?php foreach ($variables as $index => $variable): ?>
                <div class="variable">
                    <label>Variable Name:</label>
                    <input type="text" name="variable_name[]" value="<?= htmlspecialchars($variable['name']) ?>" required /><br>

                    <label>Type:<br></label>
                    <select style="color:black" name="variable_type[]" data-index="<?= $index ?>" onchange="updateOptions(this)" required><br>
                        <option style="color:black" value="number" <?= $variable['type'] == 'number' ? 'selected' : '' ?>>Number</option>
                        <option style="color:black" value="select" <?= $variable['type'] == 'select' ? 'selected' : '' ?>>Select</option>
                    </select>

                    <div class="options-container" data-index="<?= $index ?>"
                        style="display: <?= $variable['type'] == 'select' ? 'block' : 'none' ?>;">
                        <label>Options:<br></label>
                        <?php foreach ($variable['options'] as $option): ?>
                            <input type="text" name="variable_options[<?= $index ?>][]" value="<?= htmlspecialchars($option) ?>"
                                placeholder="Option" />
                        <?php endforeach; ?>
                        <button type="button" onclick="addOption(this, <?= $index ?>)">Add Option</button>
                    </div>

                    <button type="button" class="remove-button" onclick="removeVariable(this)">Remove Variable</button>
                </div>
                <hr><br>
            <?php endforeach; ?>
        </div>
        <button type="button" onclick="addVariable()">Add Variable</button>
        <button type="submit">Save</button>
    </form>
    <footer>
        <div class="footer-content">
            <div class="footer-sponsor">
                <b>
                    <p>Sponsors 鸣谢赞助: </p>
                </b>
            </div>
            <div class="footer-logo">
                <a href="https://www.zyhost.cn/"><img src="https://api4.lfcup.cn/files/logo2.png" alt="Logo"
                        class="logo" width="150" height="auto"></a>
            </div>
        </div>
        <p>Current Server: Aliyun-Shanghai</p>
    </footer>
    <footer class="text-center p-5">
        <p>Copyright &copy; 2025 IronMaple@Minur.</p>
    </footer>

    <script>
        function addVariable() {
            const variablesDiv = document.getElementById('variables');
            const variableIndex = variablesDiv.children.length;
            const newVariable = `
        <div class="variable">
            <label>Variable Name:</label>
            <input type="text" name="variable_name[]" required /><br>

            <label>Type:</label>
            <select style="color:black" name="variable_type[]" data-index="${variableIndex}" onchange="updateOptions(this)" required>
                <option style="color:black" value="number">Number</option>
                <option style="color:black" value="select">Select</option>
            </select>

            <div class="options-container" data-index="${variableIndex}" style="display: none;">
                <label>Options:</label><br>
                <button type="button" onclick="addOption(this, ${variableIndex})">Add Option</button><br>
            </div>

            <button type="button" class="remove-button" onclick="removeVariable(this)">Remove Variable</button>
        </div>
        <hr><br>
    `;
            variablesDiv.insertAdjacentHTML('beforeend', newVariable);
        }

        function updateOptions(selectElement) {
            const optionsContainer = selectElement.parentElement.querySelector('.options-container');
            optionsContainer.style.display = selectElement.value === 'select' ? 'block' : 'none';
        }

        function addOption(button, index) {
            const container = document.querySelector(`.options-container[data-index="${index}"]`);
            const newOption = `<input type="text" name="variable_options[${index}][]" placeholder="Option" />`;
            container.insertAdjacentHTML('beforeend', newOption);
        }

        function removeVariable(button) {
            button.parentElement.remove();
        }
    </script>
</body>

</html>