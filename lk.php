<?php
session_start();
require 'request/db.php';

if (!$_SESSION['logged_user']){header('Location: /login.php/');}
if ($_SESSION['logged_user']['role'] == "admin"){header('Location: /admin/index.php');}

$sql = "SELECT `courses`.`name`, `enrollment`.`id_record`, `enrollment`.`status` FROM `courses` RIGHT JOIN `enrollment` ON `enrollment`.`id_courses` = `courses`.`id_courses` WHERE `enrollment`.`id_user` = :id_user";
$result = request($sql, ["id_user"=>$_SESSION['logged_user']["id_user"]]);
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
    <script src="/script/jquery-3.5.1.min.js?nocache=<?php echo filectime('script/jquery-3.5.1.min.js')?>"></script>
    <title>Личный кабинет — Центр дополнительного образования</title>
</head>
<style>
    html, body{
        height: 100%;
    }
    body{
        display: flex;
        flex-direction: column;
        min-height: 100%;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
        background-color: #f1f1f1;
    }
    .sectionLK{
        box-sizing: border-box;
        flex: 1 0 auto;
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
        padding: 20px;
    }
    .sectionLK h2, .infoStudent h4, .courseStudent h4{
        font-family: "Roboto", sans-serif;
        font-size: 60px;
        font-weight: 300;
        color: #000000;
        margin: 50px 0 45px 0;
        text-align: center;
    }
    .infoStudent h4, .courseStudent h4{
        font-size: 25px;
        margin: 0 0 25px 0;
    }
    .mainLK{
        display: flex;
    }
    .courses, .infoStudent{
        box-sizing: border-box;
    }
    .courses{
        flex: 6;
        padding: 0 10px 0 0;
    }
    .infoStudent{
        flex: 4;
    }
    footer {
        flex: 0 0 auto;
    }
    .infoStudent, .courseStudent{
        padding: 25px;
        background-color: #ffffff;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .infoStudent p,  .infoStudent label, .infoStudent input, .infoStudent button, .infoStudent a{
        display: block;
    }
    .infoStudent label{
        margin-bottom: 3px;
    }
    .infoStudent p{
        margin-bottom: 20px;
    }
    .infoStudent input{
        border: 1px solid black;
        width: 95%;
        padding: 5px 2.5%;
        font-size: 20px;
    }
    .infoStudent button, .infoStudent a{
        margin: 10px auto 0;
        text-align: center;
        text-decoration: none;
        color: #000000;
        padding: 10px;
        font-size: 20px;
        border: none;
        background-color: lightgray;
        height: auto;
        cursor: pointer;
    }
    input:focus, button:focus{
        outline: 1px solid black;
    }
    .courseStudent{
        min-height: 504px;
        box-sizing: border-box;
    }
    .border{
        border: 1px solid black;
        padding: 10px 5px;
    }
    table{
        border: 1px solid black;
        width: 100%;
        border-collapse: collapse;
    }
    .columnOne{
        width: 10%;
        text-align: center;
    }
    .columnTwo{
        width: 60%;
    }
    .columnThree{
        width: 20%;
        text-align: center;
    }
    .columnFour{
        width: 10%;
        text-align: center;
    }
    .columnFour button{
        border: none;
        font-size: 20px;
        background-color: #FFFFFF;
        cursor: pointer;
    }
    .columnFour button i{
        color: red;
    }
    .activeCourses{
        background-color: rgb(212, 237, 218);
        color: rgb(21, 87, 36);
    }
    .inactiveCourses{
        background-color: #f8d7da;
        color: #721c24;
    }
    .notCourses{
        background-color: #ffffff;
        text-align: center;
        margin: 10px 0;
        border-left: 4px solid red;
        border-right: 4px solid red;
        padding: 10px;
        font-size: 18px;
    }
    @media all and (max-width:767px){
        .sectionLK{
            padding: 20px 0;
        }
        .mainLK{
            flex-direction: column;
        }
        .infoStudent{
            box-sizing: border-box;
        }
        .courses{
            padding: 0 10px 10px;
        }
        .courseStudent{
            min-height: 50px;
        }
        .infoStudent{
            margin: 0 10px 10px;
        }
        .courses, .infoStudent{
            flex: 1;
        }
    }
</style>
<script>
    function httpPost(url, requestBody) {
        return new Promise(function(resolve, reject) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    resolve(this.responseText);
                } else {
                    const error = new Error(this.statusText);
                    error.code = this.status;
                    reject(error);
                }
            };
            xhr.onerror = function() {
                reject(new Error("Network Error"));
            };
            xhr.send(requestBody);
        });
    }
    function inactiveStatus(id) {
        let check = confirm('Если вы откажетесь от курса, то не сможете повторно на него записаться');
        if (check){
            let data = {
                id: id,
            }
            let params = "inactiveStatusID="+data.id
            httpPost(`/request/requests.php`, params)
                .then(
                    response => {
                        if (response){
                            alert("Вы успешно отписались от курса");
                            document.location.href = '/lk.php'
                        }else{
                            alert("Возникла непредвиденая ошибка");
                            document.location.href = '/lk.php'
                        }
                    },
                    error => alert(`Rejected: ${error}`)
                );
        }
    }
</script>
<body>
<?php
    require 'header.php';
?>
<section class="sectionLK">
    <h2>Личный кабинет</h2>
    <div class="mainLK">
        <div class="courses">
            <div class="courseStudent">
                <h4>Курсы на которые вы зарегистрированы</h4>
                <?php
                    if (!$result[0]) {
                        echo '<div class="notCourses">Вы еще не зарегистрированы не на одном из курсов</div>';
                    }else{
                        echo '<table>';
                        echo '<tr><th class="border">ID</th><th class="border">Название курса</th><th class="border">Статус</th><th class="border"></th></tr>';
                        foreach ($result as $value) {
                            echo '<tr><td class="columnOne border">'.$value["id_record"].'</td><td class="columnTwo border">'.$value["name"].'</td>';
                            if ($value["status"]){
                                echo '<td class="columnThree border activeCourses">Активный</td>';
                                echo '<td class="columnFour border"><button type="button" onclick="inactiveStatus('.$value["id_record"].')"><i class="fas fa-times"></i></button></td></tr>';
                            }else{
                                echo '<td class="columnThree border inactiveCourses">Неактивный</td>';
                                echo '<td class="columnFour border"><button type="button" ><i class="fas fa-times"></i></button></td></tr>';
                            }
                        }
                        echo '</table>';
                    }
                ?>
            </div>
        </div>
        <div class="infoStudent">
            <h4>Данные пользователя</h4>
            <p>
                <label for="id">Идентификатор</label>
                <input type="text" name="id" id="id" value="<?php echo $_SESSION['logged_user']["id_user"] ?>" disabled>
            </p>
            <p>
                <label for="login">Имя пользователя</label>
                <input type="text" name="login" id="login" value="<?php echo $_SESSION['logged_user']["login"] ?>" disabled>
            </p>
            <p>
                <label for="email">Телефон</label>
                <input type="text" name="email" id="email" value="<?php echo $_SESSION['logged_user']["phone"] ?>" disabled>
            </p>
            <p>
                <label for="phone">E-mail</label>
                <input type="text" name="phone" id="phone" value="<?php echo $_SESSION['logged_user']["email"] ?>" disabled>
            </p>
            <a href="/editingUserData.php">Изменить данные</a>
            <a href="/logout.php">Выйти</a>
        </div>
    </div>
</section>
<?php
    require 'footer.php';
?>
</body>