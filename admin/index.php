<?php
session_start();
include '../config.php';
include './permissions.php';
checkPermission(['管理员']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team = $_POST['team'] ?? '';
    $teamname = $_POST['teamname'] ?? '';
    $com_type = $_POST['com_type'] ?? '';
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

    $php_code = "<?php\n\$team = '$team';\n\$teamname = '$teamname';\n\$com_type = '$com_type';\n\$variables = " . var_export($variables, true) . ";";

    if (eval ('?>' . $php_code) === false) {
        die('114(nooooo<br>check the configs php');
    }

    file_put_contents('../config.php', $php_code);
}
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="../favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | Admin Site</title>
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/a_styles.css" rel="stylesheet">
    <script type="text/javascript" src="../js/adm_script.js"></script>
</head>

<body class="dark">
    <br>
    <container>
        <header class="text-center p-5">
            <a href="/">
                <h1 class="text-4xl font-semibold"><?php echo $teamname ?> SCOUT</h1>
            </a>
            <br>
            <h2>A group of high school students from Shenzhen (Nanshan) Concord College of Sino-Canada.</h2>
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
                        <input type="text" name="variable_name[]" value="<?= htmlspecialchars($variable['name']) ?>"
                            required /><br>

                        <label>Type:<br></label>
                        <select style="color:black" name="variable_type[]" data-index="<?= $index ?>"
                            onchange="updateOptions(this)" required><br>
                            <option style="color:black" value="number" <?= $variable['type'] == 'number' ? 'selected' : '' ?>>
                                Number</option>
                            <option style="color:black" value="select" <?= $variable['type'] == 'select' ? 'selected' : '' ?>>
                                Select</option>
                        </select>

                        <div class="options-container" data-index="<?= $index ?>"
                            style="display: <?= $variable['type'] == 'select' ? 'block' : 'none' ?>;">
                            <label>Options:<br></label>
                            <?php foreach ($variable['options'] as $option): ?>
                                <input type="text" name="variable_options[<?= $index ?>][]"
                                    value="<?= htmlspecialchars($option) ?>" placeholder="Option" />
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
    </container>
    <?php include '../unify/footer.php'; ?>
    </div>

</body>

</html>