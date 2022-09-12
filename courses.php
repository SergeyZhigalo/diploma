<?php
session_start();
require 'request/db.php';
//убирает вложенность
function flat ($argument){
    $newArray = array();
    if ($argument){
        foreach ($argument as &$value){
            array_push($newArray, (int)$value["id_courses"]);
        }
        return $newArray;
    }else{
        return false;
    }
}

$sql = "SELECT * FROM `courses`";
$courses = request($sql, []);
//курсы на которые записан пользователь
if ($_SESSION['logged_user']){
    $sql = "SELECT `id_courses` FROM `enrollment` WHERE `id_user` = :id";
    $result = request($sql, ["id"=>$_SESSION['logged_user']["id_user"]]);
}
$activeCourses = flat($result);

$data = $_POST;
if (isset($data['enrollCourse'])){
    $sql = "SELECT `id_courses` FROM `enrollment` WHERE `id_user` = :id";
    $result1 = request($sql, ["id"=>$_SESSION['logged_user']["id_user"]]);
    $activeCourses = flat($result);

    $sql = "SELECT `counter`, `counterMax` FROM courses WHERE `id_courses` = :id";
    $result2 = requestCount($sql, ["id"=>(int)$data['id_courses']]);
    list($counter, $counterMax) = $result2;

    if (!in_array((int)$data['id_courses'], $activeCourses) and $counterMax - $counter > 0){
        $sql = "INSERT INTO `enrollment` (`id_record`, `id_courses`, `id_user`) VALUES (NULL, :id_courses, :id_user);";
        $result = requestStatus($sql, ["id_courses"=>(int)$data['id_courses'], "id_user"=>$_SESSION['logged_user']["id_user"]]);
        if ($result){
            if (++$counter > $counterMax){
                echo "<script> alert(`Возникла непредвиденная ошибка`); document.location.href = '/courses.php' </script>";
            }else{
                $sql = "UPDATE `courses` SET `counter` = :counter WHERE `courses`.`id_courses` = :id_courses;";
                $result = requestStatus($sql, ["counter"=>$counter, "id_courses"=>(int)$data['id_courses']]);
            }
            echo "<script> alert(`Вы зарегистрированы на курс`); document.location.href = '/courses.php' </script>";
        }else{
            echo "<script> alert(`Возникла непредвиденная ошибка`); document.location.href = '/courses.php' </script>";
        }
    }
}
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
    <link href="/css/font-awesome-modal.min.css?nocache=<?php echo filectime('css/font-awesome-modal.min.css')?>" rel="stylesheet">
    <link href="/css/style.css?nocache=<?php echo filectime('css/style.css')?>" rel="stylesheet">
    <script src="/script/jquery-3.5.1.min.js?nocache=<?php echo filectime('script/jquery-3.5.1.min.js')?>"></script>
    <script src="/script/jquery.fancybox.min.js?nocache=<?php echo filectime('script/jquery.fancybox.min.js')?>"></script>
    <title>Курсы - Центр дополнительного образования</title>
</head>
<style>
    .sectionCourses{
        text-align: center;
    }
    .courses{
        max-width: 1140px;
        margin: auto;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        text-align: left;
    }
    .sectionCourses h3{
        font-family: "Roboto", sans-serif;
        font-size: 60px;
        font-weight: 300;
        color: #000000;
        margin: 50px 0 45px 0;
    }
    .course{
        width: 33%;
        flex-grow: 1;
        margin: 10px;
        border-radius: 10px;
        text-decoration: none;
    }
    .card{
        padding: 80px 25px;
        position: relative;
    }
    .card span{
        color: white;
        font-family: "Trebuchet MS", sans-serif;
        font-size: 30px;
        font-weight: 300;
    }
    .places{
        margin-top: 20px;
        font-size: 20px !important;
    }
    .card button{
        position: absolute;
        bottom: 0;
        right: 0;
        margin: 20px;
        cursor: pointer;
        border-radius: 5px;
        padding: 10px;
        font-family: "Roboto", sans-serif;
        font-size: 16px;
        font-weight: 300;
        color: #000000;
        background-color: #ffffff;
        border: none;
    }
    button:focus{
        outline: none;
    }
    .cardLogo{
        position: absolute;
        top: 20px;
        right: 20px;
        width: 30px;
        color: white;
        border-radius: 5px;
        background-color: rgba(103, 103, 103, 0.4);
        text-align: center;
        font-size: 30px;
        padding: 15px;
    }
    .card{
        border-radius: 10px;
        background: rgba(0,0,0,.15);
    }
    .card:hover{
        background: rgba(0,0,0,.0);
    }
    .course:nth-child(6n+1){
        background-image: linear-gradient(285.41deg,#d22063,#f6c41f);
    }
    .course:nth-child(6n+2) {
        background-image: linear-gradient(153.43deg, #3600a8, #29abe2 83.33%);
    }
    .course:nth-child(6n+3) {
        background-image: linear-gradient(153.43deg,#006ceb,#a5ff5e 83.33%);
    }
    .course:nth-child(6n+4) {
        background-image: linear-gradient(135deg,#ea98da,#5b6cf9);
    }
    .course:nth-child(6n+5) {
        background-image: linear-gradient(285.41deg,#480ef4,#ff78ab);
    }
    .course:nth-child(6n+6) {
        background-image: linear-gradient(153.43deg,#02e9ff,#020aa4 83.33%);
    }
    .course:nth-child(6n+7) {
        background-image: linear-gradient(105.41deg,#01904d,#36a5ea);
    }
    .course:nth-child(6n+8) {
        background-image: linear-gradient(285.41deg,#ca28ff,#02d2e2);
    }
    .course:nth-child(6n+9) {
        background-image: linear-gradient(153.43deg,#4ba5f7,#f3fd53 83.33%);
    }
    .course:nth-child(6n+10) {
        background-image: linear-gradient(333.43deg,#1aa0e8 16.67%,#0138ff);
    }
    .course:nth-child(6n+11) {
        background-image: linear-gradient(285.41deg,#d22063,#f6c41f);
    }
    .course:nth-child(6n+12) {
        background-image: linear-gradient(333.43deg,#a786f2 16.67%,#4937d1);
    }
    a:focus{
        outline: none;
    }
    .modal{
        max-width: 600px;
        font-family: "Roboto", sans-serif;
        font-size: 18px;
        font-weight: 400;
        color: #3a3a3a;
        background-color: #ffffff;
        line-height: 1.85714285714286;
    }
    .modal h3{
        margin-bottom: 15px;
    }
    .modal .btnMain{
        margin: 10px auto 0;
        padding: 10px;
        font-size: 20px;
        border: none;
        cursor: pointer;
    }
    .activeBtn{
        color: #000000;
    }
    .activeBtn:hover{
        background-color: darkgrey;
    }
    .buttonDisabled{
        cursor: not-allowed !important;
        background-color: lightgray !important;
        color: grey !important;
    }
    .none{
        display: none;
    }
    @media all and (max-width:767px){
        .course{
            width: 50%;
        }
        .modal{
            font-size: 16px;
        }
    }
</style>
<body>
<?php
    require 'header.php';
?>
<section class="sectionCourses">
    <h3>Доступные курсы</h3>
    <div class="courses">
        <?php
        foreach ($courses as &$value){
            $seats = $value["counterMax"] - $value["counter"];
            echo '<a data-fancybox data-src="#trueModal'.$value["id_courses"].'" href="javascript:;" class="course btn btn-primary">';
            echo '<div class="card">';
            echo '<div class="cardLogo">';
            echo '<i class="'.$value["logo"].'"></i>';
            echo '</div>';
            echo '<span>курс</span><br>';
            echo '<span>'.$value["name"].'</span><br>';
            if ($seats <= 0){
                echo '<span class="places">Группы сформированны</span>';
            }else{
                echo '<span class="places">Осталось '.$seats.' мест</span>';
            }
            echo '</div>';
            echo '</a>';

            echo '<div style="display: none;" id="trueModal'.$value["id_courses"].'" class="modal">';
            echo '<h3>курс '.$value["name"].'</h3>';
            echo '<p>'.$value["description"].'</p>';
            if ($_SESSION['logged_user']['role'] == "admin"){
                echo '<button type="button" class="btnMain buttonDisabled">Вы зарегистрированны как администратор</button>';
            }elseif (!$_SESSION['logged_user']){
                echo '<button type="button" class="btnMain buttonDisabled">Зарегистрируйтесь для записи на курс</button>';
            }elseif (in_array($value["id_courses"], $activeCourses)){
                echo '<button type="button" class="btnMain buttonDisabled">Вы уже записанны на данный курс</button>';
            }elseif ($seats <= 0){
                echo '<button type="button" class="btnMain buttonDisabled">Группы сформированны</button>';
            }else{
                echo '<form action="" method="post">';
                echo '<input type="text" name="id_courses" value="'.$value["id_courses"].'" class="none">';
                echo '<button type="submit" name="enrollCourse" class="btnMain activeBtn">Записаться на курс</button>';
                echo '</form>';
            }
            echo '</div>';
        }
        ?>
    </div>
</section>
<?php
    require 'footer.php';
?>
</body>
</html>