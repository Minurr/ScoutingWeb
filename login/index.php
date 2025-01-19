<?php session_start(); include '../config.php'; ?>

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
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/styles4.css" rel="stylesheet">
    <link href="../css/lo_styles.css" rel="stylesheet">
    <script type="text/javascript" src="../js/log_script.js"></script>
    <script src="https://unpkg.com/sober/dist/sober.min.js"></script>
    <script>
    console.log(sober)
    </script>
</head>

<body class="dark">
    <br>
    <header class="text-center p-5">
        <a href="/">
            <h1 class="text-4xl font-semibold"><?php echo $teamname ?> SCOUT</h1>
        </a>
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
                <label for="register-password">Password</label>
                <input type="password" id="register-password" placeholder="Please enter password">
            </div>
            <label for="group">选择组别</label>
            <select id="group" name="group" style="color:black" required>
                <option value="程序组">程序组</option>
                <option value="机械组">机械组</option>
                <option value="外联组">外联组</option>
                <option value="媒体组">媒体组</option>
            </select>
            <br><br>
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

    <script>
        // 切换显示表单的函数
        function toggleForm(formType) {
            if (formType === 'login') {
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('register-form').style.display = 'none';
            } else {
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('register-form').style.display = 'block';
            }
        }

        // 注册函数
        async function register() {
            try {
                const username = document.getElementById('username').value;
                const email = document.getElementById('register-email').value;
                const password = document.getElementById('register-password').value;
                const group = document.getElementById('group').value;
                const regCode = document.getElementById('register-code').value;

                if (!username || !email || !password || !regCode) {
                    alert("All fields are required!");
                    return;
                }

                const response = await fetch('../backend/index.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'register',
                        username,
                        email,
                        password,
                        group,
                        reg_code: regCode,
                    }),
                });

                const result = await response.json();
                alert(result.message);
            } catch (error) {
                console.error("Error during registration:", error);
            }
        }

        // 登录函数
        async function login() {
            try {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!email || !password) {
                    alert("Both email and password are required!");
                    return;
                }

                const response = await fetch('../backend/index.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'login',
                        email,
                        password,
                    }),
                });

                const result = await response.json();
                if (result.success) {
                    alert('Welcome!');
                    window.location.href = '../profile';
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error("Error during login:", error);
            }
        }
    </script>

</body>
</html>
