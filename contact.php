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
    <link rel="shortcut icon" href="/image/logo/favicon.png" type="image/png">
    <link href="/css/font-awesome.css?nocache=<?php echo filectime('css/font-awesome.css')?>" rel="stylesheet">
    <link href="/css/style.css?nocache=<?php echo filectime('css/style.css')?>" rel="stylesheet">
    <link href="/css/styleContacts.css?nocache=<?php echo filectime('css/styleContacts.css')?>" rel="stylesheet">
    <script src="/script/jquery-3.5.1.min.js?nocache=<?php echo filectime('script/jquery-3.5.1.min.js')?>"></script>
    <title>Контакты — Центр дополнительного образования</title>
</head>
<body>
<?php
    require 'header.php';
?>
<section class="sectionContacts">
    <div class="mainContacts">
        <h3 class="heading">Контакты</h3>
        <div class="leftContacts">
            <div class="doubleContacts">
                <div class="addressContacts">
                    <p class="subtitleContacts">АДРЕС</p>
                    <p class="textContacts">г. Москва, Малая Пироговская, дом 13, строение 2</p>
                </div>
                <div class="communicationContacts">
                    <p class="subtitleContacts">СВЯЗЬ</p>
                    <p class="textContacts"><a href="tel:+79991234567">+7 (999) 123-45-67</a> — учебный отдел</p>
                    <p class="textContacts">Почта: <a title="help@site.ru" href="mailto:help@site.ru">help@site.ru</a></p>
                </div>
            </div>
            <div class="DrivingDirectionsContacts">
                <p class="subtitleContacts">СХЕМА ПРОЕЗДА</p>
                <p class="textContacts">Общественным транспортом:</p>
                <p class="textContacts">Проезд на метро до станции «Спортивная». От станции метро «Спортивная» пройти пешком по улице 10-летия Октября, на втором перекрестке повернуть на Малую Пироговскую улицу и пройти 500 метров</p>
                <p class="textContacts">Проезд на автомобиле:</p>
                <p class="textContacts">С Комсомольского проспекта в сторону области повернуть на дублер, затем на Хамовнический Вал, затем повернуть направо на улицу Ефремова после проехать 500 метров и повернуть налево на Кооперативную улицу и двагиться по ней 400 метров, после повернуть на Усачёвскую улицу, затем повернуть во дворы.</p>
            </div>
        </div>
        <div class="rightContacts">
            <iframe src="https://yandex.ru/map-widget/v1/-/CCUUVBQ1HB" width="560" height="600" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
        </div>
        <div class="leftContacts">
            <div class="requisitesContacts">
                <p class="subtitleContacts">РЕКВИЗИТЫ</p>
                <p class="textContacts">Образовательные услуги оказываются ООО «ЦДО».</p>
                <p class="textContacts">Услуги оказываются на основании Лицензии № 036031 от 17 марта 2018 года.</p>
                <p class="textContacts">Документ о прохождении обучения по программе дополнительного профессионального образования выдается ООО «ЦДО».</p>
            </div>
        </div>
    </div>
</section>
<?php
    require 'footer.php';
?>
</body>
</html>
