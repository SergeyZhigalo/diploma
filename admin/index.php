<?php
session_start();
if ($_SESSION['logged_user'] == []){header('Location: /admin/auth.php');}
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
require '../request/db.php';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/image/logo/favicon.png" type="image/png">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/styleIndex.css" rel="stylesheet">
    <link href="../css/font-awesome.css" rel="stylesheet">
    <title>Админка - Центр дополнительного образования</title>
</head>
<style>
    .activeTimetable{
        box-shadow: inset 0 0 0 3px #ffffff;
    }
    .sectionSchedule{
        text-align: center;
    }
    .sectionSchedule h3{
        font-family: "Roboto", sans-serif;
        font-size: 60px;
        font-weight: 300;
        color: #000000;
        margin: 50px 0 45px 0;
    }
    .schedule{
        max-width: 1140px;
        margin: auto;
    }
    .schedule picture{
        width: 100%;
    }
    .adminLinks{
        max-width: 800px;
        margin: 0 auto;
        text-align: right;
    }
    .metrics{
        background-color: #f1f1f1;
    }
    .statistics{
        width: 85%;
        margin: 0 auto;
        background-color: #f1f1f1;
        display: flex;
        flex-wrap: wrap;
        align-content: space-between;
    }
    .metrika{
        background-color: #ffffff;
        padding: 25px;
        width: 40%;
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
        margin: 10px;
        flex-grow: 1;
    }
    .headerMetrics, .metrika{
        font-size: 21px;
        font-family: "Trebuchet MS", sans-serif;
        color: #54595f;
        font-weight: 600;
        line-height: 1.4em;
    }
    .headerMetrics{
        text-align: center;
        font-size: 30px;
        font-family: "Roboto", sans-serif;
        padding-top: 15px;
    }
    @media (max-width: 767px) {
        .sectionSchedule h3{
            font-size: 40px;
            margin: 20px 0 15px 0;
        }
    }
</style>
<body>
<?php
require 'headerAdmin.php';

$sql = "SELECT COUNT(*) as courses FROM courses";
$countCourses = requestCount($sql, []);
$sql = "SELECT COUNT(*) as user FROM users";
$countUsers = requestCount($sql, []);
$sql = "SELECT counter FROM courses";
$arrayCounterСourses = request($sql, []);
$counterCourses = 0;
foreach ($arrayCounterСourses as $value){
    $counterCourses += (int)$value["counter"];
}
$counterCourses = $counterCourses / (int)$countCourses[0];
$sql = "SELECT counterMax FROM courses";
$arrayCounterMaxСourses = request($sql, []);
$counterMaxCourses = 0;
foreach ($arrayCounterMaxСourses as $value){
    $counterMaxCourses += (int)$value["counterMax"];
}
$counterMaxCourses = $counterMaxCourses / (int)$countCourses[0];

?>
<section class="sectionNewsIndex">
    <div class="metrics">
        <h2 class="headerMetrics">Статистика</h2>
        <div class="statistics">
            <div class="metrika">Общее количество курсов: <?php echo $countCourses[0] ?></div>
            <div class="metrika">Общее количество студентов: <?php echo $countUsers[0] ?></div>
            <div class="metrika">Среднее количество мест на курс: <?php echo round($counterMaxCourses) ?></div>
            <div class="metrika">Среднее количество учащихся на курсе: <?php echo round($counterCourses) ?></div>
        </div>
    </div>
    <div class="blockNewsIndex" id="indexNews">
<?php
    $sql = "SELECT `id`, `title`, `rubric`, `date`, `preview` FROM `news` where `rubric` != 'null' ORDER BY date DESC LIMIT 3";
    $result =  request($sql, []);
    foreach ($result as &$value){
        $value["date"] = date("d.m.Y", strtotime($value["date"]));
        echo '<article class="newsIndex">';
        echo '<a href="/новость.php?id='.$value["id"].'"><img src="/image/news/'.$value["id"].'/imagePreview/previewPhotoMin.jpg" alt="'.$value["title"].'"></a>';
        echo '<div class="introduction">';
        echo '<a href="/новость.php?id='.$value["id"].'"><h2>'.$value["title"].'</h2></a>';
        echo '<p>'.$value["preview"].'</p>';
        echo '<a href="/новость.php?id='.$value["id"].'" class="readMoreIndex">ЧИТАТЬ ДАЛЕЕ >></a>';
        echo '</div>';
        echo '<div class="dataNews">';
        echo '<span>'.$value["date"].'</span>';
        echo '</div>';
        echo '</article>';
    }
?>
    </div>
</section>
</body>
</html>