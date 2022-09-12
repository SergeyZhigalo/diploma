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
    <link href="/css/styleQuestions.css?nocache=<?php echo filectime('css/styleQuestions.css')?>" rel="stylesheet">
    <script src="/script/jquery-3.5.1.min.js?nocache=<?php echo filectime('script/jquery-3.5.1.min.js')?>"></script>
    <script src="/script/script.js?nocache=<?php echo filectime('script/script.js')?>"></script>
    <title>Вопросы — Центр дополнительного образования</title>
</head>
<body>
<?php
    require 'header.php';
?>
<style>
    html, body{
        height: 100%;
    }
    body{
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }
    .sectionQuestions{
        flex: 1 0 auto;
    }
    footer{
        flex: 0 0 auto;
    }
    .sectionColor h2 {
        font-family: "Roboto", sans-serif;
        font-size: 60px;
        font-weight: 300;
        color: #000000;
        margin: 50px 0 45px 0;
        text-align: center;
    }
    @media all and (max-width: 500px) {
        .sectionColor h2 {
            font-size: 48px;
        }
    }
</style>
<section class="sectionColor sectionQuestions">
    <div class="mainHistory">
    <h2>Часто задаваемые вопросы</h2>
        <div class="titleHistory"><h3>Подойдет ли мне направление?</h3></div>
        <div class="hiddenContent">
            <p>Для тех, кто ещё нетвёрдо уверен в своём намерении, имеется вводная часть, которая поможет получить ответ на этот вопрос. Если вы убедитесь, что разработка не для вас, это тоже положительный результат.</p>
        </div>
        <div class="titleHistory"><h3>Каким требованиям я должен соответствовать?</h3></div>
        <div class="hiddenContent">
            <p>Мы ожидаем, что вы уже знакомы с разработкой: писали на другом языке или у вас было программирование в вузе.</p>
        </div>
        <div class="titleHistory"><h3>Как и когда мне учиться?</h3></div>
        <div class="hiddenContent">
            <p>Обучение строится из трёх составляющих: теория, домашнее задание для самостоятельной практики и работа над кодом. В тренажёре вы учитесь в любое удобное время, а выполнение домашнего задания привязано к двухнедельному циклу.</p>
        </div>
        <div class="titleHistory"><h3>Что делать если я не справляюсь с нагрузкой?</h3></div>
        <div class="hiddenContent">
            <p>Если вы понимаете, что нужно сделать паузу или получить дополнительное время для закрепления материала, у вас есть возможность взять академический отпуск на месяц — но только два раза.</p>
        </div>
        <div class="titleHistory borderBottom"><h3>Смогу ли я найти работу после обучения?</h3></div>
        <div class="hiddenContent">
            <p>Сможете, но просто не будет. Рынок требует, чтобы вы умели делать что-то на практике, а не просто обладали набором знаний — мы научим вас применять эти знания, и вы сможете собрать портфолио из реальных проектов. Ещё в процессе обучения вы напишете резюме и мотивационное письмо, пройдёте несколько интервью, поучитесь неформальному поиску работы и нетворкингу. В конечном итоге шансов устроиться на работу в хорошую компанию будет настолько больше, насколько больше тех самых реальных проектов в вашем портфолио.</p>
        </div>
    </div>
</section>
<?php
    require 'footer.php';
?>
</body>
</html>
<script>
    $(document).ready(function() {
        $('.hiddenContent').css({'display':'none'});
        $('.titleHistory').click(function(){
            $(this).next('.hiddenContent').slideToggle(500)
        });
    });
</script>