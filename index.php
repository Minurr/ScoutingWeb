<?php
include 'config.php';

$data = file_get_contents('./resourse/data/scout_data.txt');

preg_match('/Team Code:\s*(\d+)/', $data, $matches);
$teamCode = $matches[1] ?? 'Unknown';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="favicon.ico">
    <title><?php echo $teamname ?> <?php echo $team ?> | SCOUT <?php echo $com_type ?></title>
    <link href="./css/styles2.css" rel="stylesheet">
    <link href="./css/styles3.css" rel="stylesheet">
    <link href="./css/styles4.css" rel="stylesheet">
    <link href="./css/styles.css" rel="stylesheet">
</head>

<body class="dark">
    <?php include './unify/header.php'; ?>
    <section class="p-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <div class="card">
            <h3 class="text-xl font-bold">Scout Page</h3>
            <p><br>Record the performance of the robots on the field accurately in the questionnaire, observing their performance in various aspects.<br>记录场上机器人的比赛情况如实记录到问卷中，观察各方面的表现。</p>
            <br>
            <a href="./scout" class="button">Cilck to jump</a>
            <br>
        </div>
        <div class="card">
            <h3 class="text-xl font-bold">Video Upload</h3>
            <p><br>The Media Team is responsible for capturing video footage of each team's robot competitions and uploading them here with proper labeling.<br>媒体组拍摄各队伍机器的比赛视频资料，并上传到此处做好标记。</p>
            <br>
            <a href="./video" class="button">Cilck to jump</a>
            <br>
        </div>
        <div class="card">
            <h3 class="text-xl font-bold">Data List</h3>
            <p><br>View and analyze data uploaded by the Outreach Media Team here.<br>在此查看外联媒体组上传的数据并进行分析。</p>
            <br>
            <a href="./view" class="button">Cilck to jump</a>
            <br>
        </div>
        <div class="card">
            <h3 class="text-xl font-bold">Admin Page</h3>
            <p><br>Change the team type, nickname, and number, as well as modify variables such as Scout Question.<br>更改队伍类型、昵称及编号，以及修改观察手的问卷的变量等。</p>
            <br>
            <a href="./admin" class="button">Cilck to jump</a>
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
    <?php include './unify/footer.php';?>
  </div>
</body>

</html>