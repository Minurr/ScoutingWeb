<?php
include '../config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="../favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | LOGIN</title>
    <link href="../css/styles2.css" rel="stylesheet">
    <link href="../css/styles3.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/lo_styles.css" rel="stylesheet">
    <script type="text/javascript" src="../js/log_script.js"></script>
</head>

<body class="dark">

    <header class="text-center p-5">
        <a href="/"><h1 class="text-4xl font-semibold"><?php echo $teamname ?> SCOUT</h1></a>
    </header>
    <section class="hero-section">
        <h2>F<?php echo $com_type ?>#<?php echo $team ?></h2>
        <h2 class="text-2xl">欢迎来到 F<?php echo $com_type ?> 2025</h2>
        <p>这里是<?php echo $teamname ?>的SCOUT网站，你可以在这里找到各种类型的数据和技巧、分类。</p>
    </section>
    <section class="p-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <div id="login-form">
                <div class="input-group">
                    <label for="email">E-Mail</label>
                    <input type="email" id="email" placeholder="Please enter email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Please enter password">
                </div>
                <div class="button-group">
                    <button onclick="login()">Login</button>
                </div>
                <span class="toggle-link" onclick="toggleForm('register')">No Account? Go Register</span>
            </div>

            <div id="register-form" style="display: none;">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Please enter username">
                </div>
                <div class="input-group">
                    <label for="register-email">E-Mail</label>
                    <input type="email" id="register-email" placeholder="Please enter email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Please enter password">
                </div>
                <hr><br>
                <div class="input-group">
                    <label for="register-code">REG-Code</label>
                    <input type="text" id="register-code" placeholder="Please enter register code">
                </div>
                <div class="button-group">
                    <button onclick="register()">Register</button>
                </div>
                <span class="toggle-link" onclick="toggleForm('login')">Have Account? Go Login</span>
            </div>
    </section>
    <?php include '../unify/footer.php'; ?>

</body>

</html>