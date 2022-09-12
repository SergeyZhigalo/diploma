<?php
    session_start();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/image/logo/favicon.png?nocache=<?php echo filectime('image/logo/favicon.png')?>" type="image/png">
    <link href="css/font-awesome.css?nocache=<?php echo filectime('css/font-awesome.css')?>" rel="stylesheet">
    <link href="css/style.css?nocache=<?php echo filectime('css/style.css')?>" rel="stylesheet">
    <link href="css/styleIndex.css?nocache=<?php echo filectime('css/styleIndex.css')?>" rel="stylesheet">
    <script src="script/script.js?nocache=<?php echo filectime('script/script.js')?>"></script>
    <title>Центр дополнительного образования</title>
</head>
<body>
<?php
    require 'header.php';
?>
<section class="sectionNewsIndex">
    <div class="blockNewsIndex" id="indexNews">
        <?php
        require 'request/db.php';
        $sql = "SELECT `id`, `title`, `rubric`, `date`, `preview` FROM `news` where `rubric` != 'null' ORDER BY date DESC LIMIT 3";
        $result =  request($sql, []);

        foreach ($result as &$value){
            $value["date"] = date("d.m.Y", strtotime($value["date"]));
            $nocache = filectime('image/news/'.$value["id"].'/imagePreview/previewPhotoMin.jpg');
            echo '<article class="newsIndex">';
            echo '<a href="/новость.php?id='.$value["id"].'"><img src="/image/news/'.$value["id"].'/imagePreview/previewPhotoMin.jpg?nocache='.$nocache.'" alt="'.$value["title"].'"></a>';
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
<style>
    .sectionLinks h2{
        font-family: "Roboto", sans-serif;
        font-size: 40px;
        font-weight: 400;
        color: #000000;
    }
    #calendar a{
        text-decoration: none;
    }
    #calendar p{
        font-family: "Roboto", sans-serif;
        font-size: 28px;
        font-weight: 300;
        color: #000000;
        margin: 15px 0;
    }
</style>
<section class="sectionLinks">
    <div class="mainLinks">
        <div class="linksImage">
            <div class="interiorLinksImage">
                <h2>Часто задаваемые вопросы</h2>
            </div>
        </div>
        <div id="calendar" class="linksScript">
            <a href="/questions.php"><p>Подойдет ли мне направление?</p></a>
            <a href="/questions.php"><p>Каким требованиям я должен соответствовать?</p></a>
            <a href="/questions.php"><p>Как и когда мне учиться?</p></a>
            <a href="/questions.php"><p>Что делать если я не справляюсь с нагрузкой?</p></a>
            <a href="/questions.php"><p>Смогу ли я найти работу после обучения?</p></a>
        </div>
    </div>
</section>
<style>
    .video img{
        width: 100%;
    }
    .textJustify{
        text-align: justify;
    }
</style>
<section class="sectionTemple">
    <div class="mainTemple">
        <div class="basicInformation">
            <h3>Центр дополнительного образования</h3>
            <div class="Holidays">У нас есть все для успешного профессионального будущего</div>
            <div class='textUniversal infoHolidays textJustify'>Если вы хотите получить новую профессию, обратите внимание на наши курсы. На них вы успеете развить навыки, отточить их на практике и получить сертификат.</div>
            <div class='textUniversal infoHolidays textJustify'>Востребованные направления — выбирайте, в каком из них хотите развиваться.</div>
            <div class="blockIndexSchedule"><a href="/courses.php/" class="indexSchedule">ДОСТУПНЫЕ КУРСЫ&nbsp;<i class="fa fa-angle-double-right"></i></a></div>
        </div>
        <div class="video">
            <img src="image/index/index1.jpg" alt="">
            <img src="image/index/index2.jpg" alt="">
        </div>
    </div>
</section>
<?php
    require 'footer.php';
?>
</body>
</html>