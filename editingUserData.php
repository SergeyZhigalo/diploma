<?php
session_start();
require 'request/db.php';
if (!$_SESSION['logged_user']){header('Location: /login.php/');}
if ($_SESSION['logged_user']['role'] == "admin"){header('Location: /admin/index.php');}

$data = $_POST;
if (isset($data["editingData"])){

    $countPhone = 0;
    $countEmail = 0;
    if ($_SESSION['logged_user']["phone"] != $data["phone"]){
        $sql = "SELECT COUNT(`phone`) AS 'count' FROM users WHERE `phone`=:phone";
        $result = requestCount($sql, ["phone" => $data["phone"]]);
        list($countPhone) = $result;
    }
    if ($_SESSION['logged_user']["email"] != $data["email"]){
        $sql = "SELECT COUNT(`email`) AS 'count' FROM users WHERE `email`=:email";
        $result = requestCount($sql, ["email" => $data["email"]]);
        list($countEmail) = $result;
    }

    if (!$countPhone and !$countEmail){
        $sql = "UPDATE `users` SET `login` = :login, `phone` = :phone, `email` = :email WHERE `users`.`id_user` = :id;";
        $result = requestStatus($sql, ["login" => $data["login"], "phone" => $data["phone"], "email" => $data["email"], "id" => $_SESSION['logged_user']['id_user']]);
        if ($result){
            $_SESSION['logged_user']["login"] = $data["login"];
            $_SESSION['logged_user']["phone"] = $data["phone"];
            $_SESSION['logged_user']["email"] = $data["email"];
            echo "<script> alert(`Данные успешно измененны`); document.location.href = '/lk.php' </script>";
        }else{
            echo "<script> alert(`Возникла непредвиденная ошибка!`); document.location.href = '/lk.php' </script>";
        }
    }else{
        if ($countPhone){
            echo "<script> alert(`Пользователь с таким телефоном уже существует!`) </script>";
        }
        if ($countEmail){
            echo "<script> alert(`Пользователь с такой электронной почтой уже существует!`) </script>";
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
    <script src="/script/jquery-3.5.1.min.js"></script>
    <script src="/script/jquery.maskedinput.js"></script>
    <title>Редактирование данных</title>
</head>
<style>
    *{
        padding: 0;
        margin: 0;
    }
    body{
        background-color: #f1f1f1;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    }
    p, label, input, button, a, h2{
        display: block;
    }
    .editing{
        width: 100vw;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .formEditing{
        width: 400px;
        margin: 10% auto;
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
        box-sizing: border-box;
        border: 1px solid black;
        width: 100%;
        padding: 5px 10px;
        font-size: 20px;
        margin-right: 0 !important;
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
    h2{
        text-align: center;
        font-family: "Roboto", sans-serif;
        font-weight: 300;
        color: #000000;
        font-size: 25px;
        margin: 0 0 25px 0;
    }
    a{
        text-align: center;
        margin-top: 13px;
        text-decoration: none;
        color: #555d66;
    }
    a:focus{
        outline: none;
        text-decoration: underline;
    }
</style>
<body>
    <section class="editing">
        <div class="formEditing">
            <form class="formChangePassword" action="" method="post">
                <h2>Данные пользователя</h2>
                <p>
                    <label for="id">Идентификатор</label>
                    <input type="text" name="id" id="id" value="<?php echo $_SESSION['logged_user']["id_user"] ?>" disabled>
                </p>
                <p>
                    <label for="login">Имя пользователя</label>
                    <input type="text" name="login" id="login" value="<?php echo $_SESSION['logged_user']["login"] ?>">
                </p>
                <p>
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" value="<?php echo $_SESSION['logged_user']["email"] ?>">
                </p>
                <p>
                    <label for="phone">Телефон</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $_SESSION['logged_user']["phone"] ?>">
                </p>
                <button type="submit" name="editingData">Изменить</button>

            </form>
            <a href="/lk.php">&larr; Вернуться назад</a>
        </div>
    </section>
    <script>
        $("#phone").mask("+7(999)999-99-99");
    </script>
</body>
</html>