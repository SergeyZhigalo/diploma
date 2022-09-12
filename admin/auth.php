<?php
session_start();
require '../request/db.php';
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
if ($_SESSION['logged_user']){header('Location: /');}
$data = $_POST;
if (isset($data['authorization'])) {
    $errors = array();
    $sql = "SELECT * FROM administration WHERE login = :login;";
    $result = requestCount($sql, ["login"=>$data['login']]);
    if ($result){
        if (password_verify($data['password'], $result[2])){
            $logged_user = array(
                "id_user" => (int)$result[0],
                "login" => $result[1],
                "role" => "admin",
            );
            $_SESSION['logged_user'] = $logged_user;
            header('Location: /admin/index.php');
        }else{
            $errors[] = 'Неверно введен пароль!';
        }
    }else{
        $errors[] = 'Пользователь с таким логином не найден!';
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
    <title>Войти - Центр дополнительного образования</title>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        body{
            background-color: #f1f1f1;
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
        }
        p, label, input, button, a{
            display: block;
        }
        .auth{
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .authorization{
            max-width: 400px;
            margin: 10% auto;
        }
        .authorization > a{
            text-align: center;
        }
        .authorization img{
            width: 100%;
        }
        .formAuthorization{
            width: calc(100% - 50px);
            background-color: #ffffff;
            padding: 25px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,.2);
        }
        .formAuthorization label{
            margin-bottom: 3px;
        }
        .formAuthorization p{
            margin-bottom: 20px;
        }
        .formAuthorization input{
            border: 1px solid black;
            width: 95%;
            padding: 5px 2.5%;
            font-size: 20px;
        }
        input:focus, button:focus{
            outline: 1px solid black;
        }
        .formAuthorization button{
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
        .errorAuthorization{
            width: calc(100% - 28px);
            background-color: #ffffff;
            margin: 10px 0;
            border-left: 4px solid red;
            border-right: 4px solid red;
            padding: 10px;
        }
    </style>
</head>
<body>
<section class="auth">
    <div class="authorization">
        <img src="../image/logo/logo.png" alt="logo">
        <?php
        if (!empty($errors)) {
            echo '<div class="errorAuthorization">'.array_shift($errors).'</div>';
        }
        ?>
        <form class="formAuthorization" action="" method="post">
            <p>
                <label for="login">Имя пользователя</label>
                <input type="text" name="login" id="login">
            </p>
            <p>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password">
            </p>
            <button type="submit" name="authorization">Войти</button>
        </form>
        <a href="/">&larr; Назад к сайту "Центр дополнительного образования"</a>
    </div>
</section>
</body>
</html>