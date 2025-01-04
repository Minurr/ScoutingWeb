<?php
include 'config.php';

$data = file_get_contents('scout_data.txt');

preg_match('/Team Code:\s*(\d+)/', $data, $matches);
$teamCode = $matches[1] ?? 'Unknown';
?>

<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $teamname ?> <?php echo $team ?> | SCOUT <?php echo $com_type ?></title>
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

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #4a565f;
        }
    </style>
</head>

<body class="dark">
    <br>
    <header class="text-center p-5">
        <a href="./"><h1 class="text-4xl font-semibold"><?php echo $teamname ?> SCOUT</h1></a>
        <form action="./view.php" class="inline-form">
            <label for="team">Search Team:</label>
            <input type="text" id="team" name="team" placeholder="114514">
            <input type="submit" value="Submit">
        </form>
    </header>
    <section class="hero-section">
        <h2>F<?php echo $com_type ?>#<?php echo $team ?></h2>
        <h2 class="text-2xl">欢迎来到 F<?php echo $com_type ?> 2025</h2>
        <p>这里是<?php echo $teamname ?>的SCOUT网站，你可以在这里找到各种类型的数据和技巧、分类。</p>
    </section>
    <section class="p-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <div class="card">
            <h3 class="text-xl font-bold">Scout Page</h3>
            <p><br>Record the performance of the robots on the field accurately in the questionnaire, observing their performance in various aspects.<br>记录场上机器人的比赛情况如实记录到问卷中，观察各方面的表现。</p>
            <br>
            <a href="./scout.php" class="button">Cilck to jump</a>
            <br>
        </div>
        <div class="card">
            <h3 class="text-xl font-bold">Video Upload</h3>
            <p><br>The Media Team is responsible for capturing video footage of each team's robot competitions and uploading them here with proper labeling.<br>媒体组拍摄各队伍机器的比赛视频资料，并上传到此处做好标记。</p>
            <br>
            <a href="./video.php" class="button">Cilck to jump</a>
            <br>
        </div>
        <div class="card">
            <h3 class="text-xl font-bold">Data List</h3>
            <p><br>View and analyze data uploaded by the Outreach Media Team here.<br>在此查看外联媒体组上传的数据并进行分析。</p>
            <br>
            <a href="./view.php" class="button">Cilck to jump</a>
            <br>
        </div>
        <div class="card">
            <h3 class="text-xl font-bold">Admin Page</h3>
            <p><br>Change the team type, nickname, and number, as well as modify variables such as Scout Question.<br>更改队伍类型、昵称及编号，以及修改观察手的问卷的变量等。</p>
            <br>
            <a href="./admin.php" class="button">Cilck to jump</a>
            <br>
        </div>
        <div class="card">
            <h3 class="text-xl font-bold">Github Library</h3>
            <p><br>Adhering to the spirit of open source, we release 90% of our source code to Github for others to reference.<br>遵循开源精神，释放90%源代码至Github供他人参考。</p>
            <br>
            <a href="https://github.com/Minurr/ScoutWeb" class="button">Cilck to jump</a>
            <br>
        </div>
        <div class="card">
            <h3 class="text-xl font-bold">Offical Website</h3>
            <p><br>FRC5516's website, a group of high school students from Shenzhen (Nanshan) Concord College of Sino-Canada formed a team with passion.<br>FRC5516的官方网站，一群来自深圳（南山）中加学校的高中生，用激情组建的一支队伍。</p>
            <br>
            <a href="https://frc5516.com.cn" class="button">Cilck to jump</a>
            <br>
        </div>
    </section>
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
</body>

</html>