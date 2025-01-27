<?php
session_start();
include 'config.php';

$data = file_get_contents('./resource/data/scout_data.txt');

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
            <p><br>Record the performance of the robots on the field accurately in the questionnaire, observing their performance in various aspects.</p>
            <br>
            <s-button slot="action" id="button1" class="button" style="float: right;">Cilck to jump</s-button>
            <br>
        </div>
        
        <div class="card">
            <h3 class="text-xl font-bold">Video Upload</h3>
            <p><br>The Media Team is responsible for capturing video footage of each team's robot competitions and uploading them here with proper labeling.</p>
            <br>
            <s-button slot="action" id="button2" class="button" style="float: right;">Cilck to jump</s-button>
            <br>
        </div>

        <div class="card">
            <h3 class="text-xl font-bold">Data List</h3>
            <p><br>View and analyze data uploaded by the Outreach Media Team here.</p>
            <br>
            <s-button slot="action" id="button3" class="button" style="float: right;">Cilck to jump</s-button>
            <br>
        </div>

        <div class="card">
            <h3 class="text-xl font-bold">User Manage</h3>
            <p><br>View the total number of users, change user groups, etc.</p>
            <br>
            <s-button slot="action" id="button4" class="button" style="float: right;">Cilck to jump</s-button>
            <br>
        </div>
        
        <div class="card">
            <h3 class="text-xl font-bold">Admin Page</h3>
            <p><br>Change the team type, nickname, and number, as well as modify variables such as Scout Question.</p>
            <br>
            <s-button slot="action" id="button5" class="button" style="float: right;">Cilck to jump</s-button>
            <br>
        </div>

        <div class="card">
            <h3 class="text-xl font-bold">Github Library</h3>
            <p><br>Adhering to the spirit of open source, we release 90% of our source code to Github for others to reference.</p>
            <br>
            <s-button slot="action" id="button6" class="button" style="float: right;">Cilck to jump</s-button>
            <br>
        </div>

        <div class="card">
            <h3 class="text-xl font-bold">Offical Website</h3>
            <p><br>FRC5516's website, a group of high school students from Shenzhen (Nanshan) Concord College of Sino-Canada formed a team with passion.</p>
            <br>
            <s-button slot="action" id="button7" class="button" style="float: right;">Cilck to jump</s-button>
            <br>
        </div>

    </section>
    <?php include './unify/footer.php';?>
  </div>
  <script><?php include './js/button.js'; ?></script>
</body>

</html>