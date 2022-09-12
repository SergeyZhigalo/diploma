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
    <link href="/css/styleTeachers.css?nocache=<?php echo filectime('css/styleTeachers.css')?>" rel="stylesheet">
    <title>Преподаватели — Центр дополнительного образования</title>
</head>
<body>
<?php
    require 'header.php';
?>
<section class="section max_width_1140px">
    <h3 class="section__h3">Преподаватели</h3>
    <div class="Clergy">
        <div class="Clergy__info">
            <div class="Clergy__heading">
                <h3 class="Clergy__text Clergy__h3 no_margin">Белокрылов Зиновий Святославович</h3>
                <p class="Clergy__text">Разрабатывает IT-решения по автоматизации процессов учета наличия и движения людей и технических средств</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Должность</span></p>
                <p>Преподаватель</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Образование</span></p>
                <p>Московский государственный университет имени М.В.Ломоносова</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Стаж работы по специальности</span></p>
                <p>5 лет, 10 месяцев</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Ведущий курсов</span></p>
                <p>Веб-разработка, Тестирование ПО</p>
            </div>
            <div class="Clergy__text no_margin">
                <p><span class="text_bold">Контакты</span></p>
                <p>belokrilov@mail.com</p>
            </div>
        </div>
        <div class="Clergy__image">
            <img src="/image/Teachers/img1.jpg" alt="">
        </div>
    </div>
    <div class="Clergy">
        <div class="Clergy__info">
            <div class="Clergy__heading">
                <h3 class="Clergy__text Clergy__h3 no_margin">Бородин Николай Кириллович</h3>
                <p class="Clergy__text">Ведущий специалист центра разработки информационных систем</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Должность</span></p>
                <p>Преподаватель</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Образование</span></p>
                <p>НИЯУ МИФИ</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Стаж работы по специальности</span></p>
                <p>2 года, 1 месяц</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Ведущий курсов</span></p>
                <p>iOS-разработка, SEO-продвижение</p>
            </div>
            <div class="Clergy__text no_margin">
                <p><span class="text_bold">Контакты</span></p>
                <p>borodin@mail.com</p>
            </div>
        </div>
        <div class="Clergy__image">
            <img src="/image/Teachers/img2.jpg" alt="">
        </div>
    </div>
    <div class="Clergy">
        <div class="Clergy__info">
            <div class="Clergy__heading">
                <h3 class="Clergy__text Clergy__h3 no_margin">Денисов Алексей Альбертович</h3>
                <p class="Clergy__text">отрудник отдела фундаментальных проблем аэрокосмических технологий Европейского научного центра</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Должность</span></p>
                <p>Преподаватель</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Образование</span></p>
                <p>Московский физико-технический институт</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Стаж работы по специальности</span></p>
                <p>3 года, 2 месяца</p>
            </div>
            <div class="Clergy__text">
                <p><span class="text_bold">Ведущий курсов</span></p>
                <p>Python-разработка, Data Engineering</p>
            </div>
            <div class="Clergy__text no_margin">
                <p><span class="text_bold">Контакты</span></p>
                <p>denisov@mail.com</p>
            </div>
        </div>
        <div class="Clergy__image">
            <img src="/image/Teachers/img3.jpg" alt="">
        </div>
    </div>
</section>
<?php
    require 'footer.php';
?>
</body>
</html>