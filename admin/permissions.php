<?php
// 权限检查函数，接收一个包含多个组别的数组
function checkPermission($allowedGroups) {
    // 启动会话管理
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // 确保 $_SESSION['group'] 已设置，并检查用户组是否在允许的组别中
    if (!isset($_SESSION['group']) || !in_array($_SESSION['group'], $allowedGroups)) {
        // 如果不在允许的组别中，显示访问被拒绝的消息
        header("HTTP/1.1 403 Forbidden");
        echo '
            <?php
            header("HTTP/1.1 403 Forbidden");
            ?>
            <!DOCTYPE html>
            <html lang="zh">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>403 Forbidden</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f2f2f2;
                        color: #333;
                        text-align: center;
                    }
                    .container {
                        padding: 20px;
                        background-color: white;
                        border-radius: 8px;
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                        max-width: 600px;
                        margin: 50px auto;
                        text-align: left;
                    }
                    h1 {
                        color: #e74c3c;
                    }
                    p {
                        font-size: 16px;
                        line-height: 1.6;
                    }
                    hr {
                        border: 0;
                        border-top: 1px solid #ddd;
                        margin: 20px 0;
                    }
                    footer {
                        font-size: 14px;
                        color: #888;
                    }
                    @media (max-width: 600px) {
                        .container {
                            padding: 15px;
                            margin: 20px;
                        }
                        h1 {
                            font-size: 24px;
                        }
                        p {
                            font-size: 14px;
                        }
                    }
                </style>
                <script>
                    setTimeout(function() {
                        window.location.href = "../";
                    }, 10000);
                </script>
            </head>
            <body>
                <div class="container">
                    <h1>403 Forbidden</h1>
                    <p>Access Denied.<br>You do not have permission to access this page.<br><br>To prevent unrelated people from opening the admin interface to modify the SCOUT table and team data, this page is only open to the administrator group.<br><br>为防止无关人员打开管理界面修改Scout表和队伍数据，该页面仅开放给管理员组别。<br><br>Redirected back after 10 seconds.</p>
                    <hr>
                    <footer>IronMaple@Minur_</footer>
                </div>
            </body>
            </html>

        ';
        exit;
    }
}
?>
