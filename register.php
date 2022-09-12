<?php
session_start();
require 'request/db.php';
if ($_SESSION['logged_user']){header('Location: /');}
if ($_SESSION['logged_user']['role'] == 'admin'){header('Location: /admin/index.php');}
$data = $_POST;
if (isset($data['register'])) {
    $errors = array();

    if (strlen($data["login"]) < 2){
        $errors[] = 'Слишком короткое имя!';
    }

    if (strlen($data["login"]) > 255){
        $errors[] = 'Слишком длинное имя!';
    }

    if (!preg_match("/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/", $data["phone"])){
        $errors[] = 'Номер телефона введен некорректно!';
    }

    if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Почта введена некорректно!';
    }

    if (strlen($data["password"]) < 8){
        $errors[] = 'Слишком короткий пароль!';
    }

    if (strlen($data["password"]) > 30){
        $errors[] = 'Слишком длинный пароль!';
    }

    if (!preg_match("#[0-9]+#", $data["password"])){
        $errors[] = 'Пароль должен содержать хотя бы одну цифру!';
    }

    if (!preg_match("#[a-z]+#", $data["password"])){
        $errors[] = 'Пароль должен содержать хотя бы одну латинскую букву нижнего регистра!';
    }

    if (!preg_match("#[A-Z]+#", $data["password"])){
        $errors[] = 'Пароль должен содержать хотя бы одну латинскую букву верхнего регистра!';
    }

    if (!$data["password"] == $data["password2"]){
        $errors[] = 'Пароли не совпадают!';
    }

    if (empty($errors)){
        $sql = "SELECT COUNT(`phone`) AS 'count' FROM users WHERE `phone`=:phone";
        $result = requestCount($sql, ["phone" => $data["phone"]]);
        list($countPhone) = $result;

        $sql = "SELECT COUNT(`email`) AS 'count' FROM users WHERE `email`=:email";
        $result = requestCount($sql, ["email" => $data["email"]]);
        list($countEmail) = $result;

        if (!$countPhone and !$countEmail){
            $sql = "INSERT INTO `users` (`id_user`, `login`, `phone`, `email`, `password`) VALUES (NULL, :login, :phone, :email, :password)";
            $result = requestStatus($sql, ["login" => $data["login"], "phone" => $data["phone"], "email" => $data["email"], "password" => password_hash($data["password"], PASSWORD_DEFAULT)]);
            if ($result){
                echo "<script> alert(`Вы успешно зарегистрированы`); document.location.href = '/login.php' </script>";
            }else{
                $errors[] = 'Возникла непредвиденная ошибка!';
            }
        }else{
            if ($countPhone){
                $errors[] = 'Пользователь с таким телефоном уже существует!';
            }
            if ($countEmail){
                $errors[] = 'Пользователь с такой электронной почтой уже существует!';
            }
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
    <script src="/script/jquery-3.5.1.min.js"></script>
    <script src="/script/jquery.maskedinput.js"></script>
    <title>Регистрация - Центр дополнительного образования</title>
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
        .register{
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .authorization{
            max-width: 400px;
            margin: 0 auto;
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
<section class="register">
    <div class="authorization">
        <img src="image/logo/logo.png" alt="logo">
        <?php
        if (!empty($errors)) {
            echo '<div class="errorAuthorization">'.array_shift($errors).'</div>';
        }
        ?>
        <form class="formAuthorization" action="" method="post">
            <p>
                <label for="login">Имя</label>
                <input type="text" name="login" id="login" value="<?php echo $data["login"] ?>" minlength="2" maxlength="255" required>
            </p>
            <p>
                <label for="phone">Телефон</label>
                <input type="text" name="phone" id="phone" value="<?php echo $data["phone"] ?>" class="phone" required>
            </p>
            <p>
                <label for="email">E-mail</label>
                <input type="text" name="email" id="email" value="<?php echo $data["email"] ?>" required>
            </p>
            <p>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
            </p>
            <p>
                <label for="password2">Повторите пароль</label>
                <input type="password" name="password2" id="password2" required>
            </p>
            <button type="submit" name="register">Зарегистрироваться</button>
        </form>
        <a href="/login.php">&larr; Войти</a>
        <br>
        <a href="/">&larr; Назад к сайту "Центр дополнительного образования"</a>
    </div>
</section>
    <script>
        $(".phone").mask("+7(999)999-99-99");
    </script>
</body>
</html>