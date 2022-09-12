<?php
session_start();
if ($_SESSION['logged_user'] == []){header('Location: /admin/auth.php');}
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
require '../request/db.php';

$data = $_POST;
if (isset($data['changePassword'])) {

    $sql = "SELECT `password` FROM administration WHERE `login`=:login";
    $result = request($sql, ["login"=>$_SESSION["logged_user"]["login"]]);

    if (password_verify($_POST["oldPassword"], $result[0]["password"])){
        echo 'ok';
        if ($_POST["newPassword"] == $_POST["newPassword2"]){
            $sql = "UPDATE `administration` SET `password` = :newPassword WHERE `administration`.`id_user` = :id;";
            $result = request($sql, ["newPassword"=>password_hash($_POST["newPassword"], PASSWORD_DEFAULT), "id"=>$_SESSION["logged_user"]["id_user"]]);
        }else{
            echo 'Новый пароль введен не верно';
        }
    }else{
        echo 'Старый пароль введен не верно';
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
    <link href="../css/font-awesome.css" rel="stylesheet">
    <title>Смена пароля - Центр дополнительного образования</title>
</head>
<style>
    *{
        padding: 0;
        margin: 0;
    }
    body{
        background-color: #f1f1f1;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
        padding: 15px;
    }
    p, label, input, button, a{
        display: block;
    }
    .changePassword{
        max-width: 400px;
        margin: 10% auto;
    }
    .changePassword > a{
        text-align: center;
    }
    .changePassword img{
        width: 100%;
        margin-bottom: 10px;
    }
    .formChangePassword{
        width: calc(100% - 50px);
        background-color: #ffffff;
        padding: 25px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .formChangePassword label{
        margin-bottom: 3px;
    }
    .formChangePassword p{
        margin-bottom: 20px;
    }
    .formChangePassword input{
        border: 1px solid black;
        width: 95%;
        padding: 5px 2.5%;
        font-size: 20px;
    }
    input:focus, button:focus{
        outline: 1px solid black;
    }
    .formChangePassword button{
        margin: 10px auto 0;
        padding: 10px;
        font-size: 20px;
        border: none;
        background-color: lightgray;
    }
    a{
        margin-top: 8px;
        text-decoration: none;
        color: #555d66;
    }
    a:focus{
        outline: none;
        text-decoration: underline;
    }
</style>
<body>
    <div class="changePassword">
        <form class="formChangePassword" action="" method="post">
            <p>
                <label for="oldPassword">введите старый пароль</label>
                <input type="text" class="" name="oldPassword" id="oldPassword" minlength="5" maxlength="50" required>
            </p>
            <p>
                <label for="newPassword">введите новый пароль</label>
                <input type="text" class="" name="newPassword" id="newPassword" minlength="5" maxlength="50" required>
            </p>
            <p>
                <label for="newPassword2">повторите новый пароль</label>
                <input type="text" class="" name="newPassword2" id="newPassword2" minlength="5" maxlength="50" required>
            </p>
            <button type="submit" name="changePassword">Сменить</button>
        </form>
        <a href="/admin/index.php">&larr; Вернуться назад</a>
    </div>
</body>
</html>