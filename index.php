<?php
include 'config.php';

$data = file_get_contents('scout_data.txt');

preg_match('/Team Code:\s*(\d+)/', $data, $matches);
$teamCode = $matches[1] ?? 'Unknown';
?>

<!--

一定要记得！！
上线之前记得前后端分离！！！
不然越写越臃肿！！！！
结构也要优化，规范一点
 
-->
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <script src="https://c.webfontfree.com/c.js?f=Arial-Black" type="text/javascript"></script>
    <title><?php echo $teamname ?> <?php echo $team ?>| Scouting Website</title>
    <style>
        body {
            font-family: 'Arial-Black', cursive;
            //font-family: Arial Black;
            background-image: url('https://api.lfcup.cn/photo/files/67694b89cc17a.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            //color: #d4d4d4;
            margin: 0;
        }

        h1,
        h2,
        h3 {
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.64);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class='container'>
        <h1><?php echo $teamname ?>-<?php echo $team ?></h1>
        <h2>Scouting Site</h2>
        <hr>
        <!-- <p>TeamCode of Already Have Data:<br><br><?php echo $teamCode ?></p> -->
        <form action="./view.php">
            <label for="team">Team Code:</label>
            <input type="text" id="team" name="team" placeholder="114514">
            <input type="submit" value="Submit">
        </form>
        <p>Put the teamcode and click the button to query the data.</p>
        <p>If you put the teamcode but doesn't have data in database, it will show team list to you.</p>
        <p>(Video Upload's service is being written, and the link NOT the version we want to present.)<br>
            <br><br>
            <!-- 放两个links在这里，后面优化样式。。。 -->
            <a href="https://photo.lfcup.cn">Video Upload</a><br>

            <a href='./scout.php'>Scouting Site</a><br>
            <a href='./admin.php'>Admin Site</a>
    </div>

</body>

</html>