<?php
session_start();
require 'request/db.php';

$sql = "SELECT COUNT(*) as quantity FROM `news`";
$result = request($sql, []);
$result = ceil((int)$result[0]['quantity'] / 5);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/image/logo/favicon.png" type="image/png">
    <link href="/css/font-awesome.css?nocache=<?php echo filectime('css/font-awesome.css')?>" rel="stylesheet">
    <link href="/css/style.css?nocache=<?php echo filectime('css/style.css')?>" rel="stylesheet">
    <link href="/css/styleNews.css?nocache=<?php echo filectime('css/styleNews.css')?>" rel="stylesheet">
    <script src="/script/jquery-3.5.1.min.js?nocache=<?php echo filectime('script/jquery-3.5.1.min.js')?>"></script>
    <script src="/script/script.js?nocache=<?php echo filectime('script/script.js')?>"></script>
    <title>Новости — Центр дополнительного образования</title>
</head>
<body onload="generateNews(1)">
<?php
    require 'header.php';
?>
<section class="section">
    <div class="news" id="news"></div>
    <div class="sidebar">
        <aside class="aside">
            <div class="aside__search">
                <input type="text" class="aside__search__input" placeholder="Поиск..." minlength="4" onchange="search()" id="searchValue">
                <button class="aside__search__button" onclick="search()" title="Поиск новостей"> <i class="fas fa-search"></i> </button>
            </div>
            <div class="aside__result-search"></div>
            <div class="aside__pages">
                <h3 class="aside__pages__h3">Страницы</h3>
                <?php
                for ($i = 1; $i <= $result; $i++)
                    echo '<button id="'.$i.'" onclick="generateNews(this.value)" value="'.$i.'" class="aside__pages__page"><span>'.$i.'</span></button>';
                ?>
            </div>
        </aside>
    </div>
    <div class="up" onclick="window.scrollTo( 0, 0 )">
        <span class="up__span">В начало &uarr;</span>
    </div>
</section>
<?php
    require 'footer.php';
?>
</body>
</html>