<?php
session_start();
if ($_SESSION['logged_user'] == []){header('Location: /admin/auth.php');}
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
$idCourse = $_POST["id"];
if ($idCourse == []){header('Location: /admin/editCourse.php');}
require '../request/db.php';

$sql = "SELECT * FROM courses WHERE `id_courses` = :id";
$courses = requestCount($sql, ["id"=>$idCourse]);

$data = $_POST;
if (isset($data["changeCourse"])){
    if ($data["counterMax"]>=$data["counter"]){
        $sql = "UPDATE `courses` SET `name` = :name, `logo` = :logo, `description` = :description, `counterMax` = :counterMax WHERE `courses`.`id_courses` = :id;";
        $result = requestStatus($sql, ["name"=>$data["course"], "logo"=>$data["logo"], "description"=>$data["description"], "counterMax"=>$data["counterMax"], "id"=>$data["id"]]);

        if ($result){
            echo "<script> alert(`Данные о курсе успешно изменены`); document.location.href = '/admin/editCourse.php' </script>";
        }else{
            echo "<script> alert(`Возникла непредвиденная ошибка`); document.location.href = '/admin/editCourse.php' </script>";
        }
    }
}
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
    <title>Редактирование курса</title>
</head>
<style>
    body{
        background-color: #f1f1f1;
        overflow-y: scroll;
    }
    body, input, textarea{
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    }
    .changeCourse{
        max-width: 1140px;
        margin: auto;
        padding: 25px;
    }
    h2{
        font-family: "Roboto", sans-serif;
        font-size: 60px;
        font-weight: 300;
        color: #000000;
        margin: 50px 0 45px 0;
        text-align: center;
    }
    p, label, input, textarea, span{
        display: block;
    }
    textarea{
        width: 100%;
        min-height: 150px;
        max-height: 500px;
        resize: vertical;
        box-sizing: border-box;
    }
    p{
        margin-bottom: 12px;
    }
    input[type="text"], input[type="number"]{
        width: 400px;
        border: 1px solid black;
        font-size: 20px;
        padding: 5px;
    }
    input[type="text"]:focus, input[type="number"]:focus, textarea:focus{
        outline: 1px solid black;
    }
    textarea{
        border: 1px solid black;
        font-size: 20px;
        padding: 5px;
    }
    span{
        font-weight: 700;
    }
    label span{
        margin-top: 10px;
        cursor: pointer;
        font-weight: 700;
    }
    label span:hover{
        text-decoration: underline;
    }
    label{
        margin-bottom: 3px;
    }
    button{
        margin: 10px auto 0;
        padding: 10px;
        font-size: 20px;
        border: none;
        background-color: lightgray;
    }
    button:hover, button:focus{
        outline: 2px solid black;
        cursor: pointer;
    }
</style>
<body>
<section class="changeCourse">
    <h2>Редактирование курса</h2>
    <form method="post">
        <p>
            <label for="id">Идентификатор</label>
            <input type="text" name="id" id="id" maxlength="255" value="<?php echo $courses[0] ?>" readonly>
        </p>
        <p>
            <label for="course">Название курса</label>
            <input type="text" name="course" id="course" maxlength="255" value="<?php echo $courses[1] ?>" required>
        </p>
        <p>
            <label for="logo">Логотип</label>
            <input type="text" name="logo" id="logo" maxlength="255" value="<?php echo $courses[2] ?>" required>
        </p>
        <p>
            <label for="description">Описание курса</label>
            <textarea name="description" id="description" maxlength="5000"><?php echo $courses[3] ?></textarea>
        </p>
        <p>
            <label for="counterMax">Максимальное количество участников</label>
            <input type="number" name="counterMax" id="counterMax" min="<?php echo $courses[4] ?>" value="<?php echo $courses[5] ?>" required>
        </p>
        <p>
            <label for="counter">Количество зарегистрированных</label>
            <input type="number" name="counter" id="counter" value="<?php echo $courses[4] ?>" readonly>
        </p>
        <p>
            <button type="submit" name="changeCourse" id="changeCourse">Изменить</button>
        </p>
    </form>
</section>
</body>
</html>