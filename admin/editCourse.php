<?php
session_start();
if ($_SESSION['logged_user'] == []){header('Location: /admin/auth.php');}
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
require '../request/db.php';

$sql = "SELECT * FROM courses";
$courses = request($sql, []);
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
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <title>Редактирование курсов</title>
</head>
<style>
    body{
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    }
    .editCourse{
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 20px 20px 20px;
    }
    h2{
        padding: 50px 0;
        color: #000000;
        font-family: "Roboto", sans-serif;
        font-size: 40px;
        font-weight: 300;
        text-align: center;
    }
    table{
        border-collapse: collapse;
    }
    th, td{
        border: 1px solid black;
        padding: 10px 15px;
    }
    .tableID, .edit, .delete{
        width: 5%;
        text-align: center;
    }
    .tableCourse{
        width: 45%;
    }
    .tableCounter{
        width: 20%;
    }
    .tableMaxCounter{
        width: 20%;
    }
    .edit{
        color: #137e4c;
        background-color: #d1e7dd;
    }
    .delete{
        color: red;
        background-color: #f8d7da;
    }
    .edit, .delete{

    }
    .edit button, .delete button{
        border: none;
        font-size: 30px;
        cursor: pointer;
    }
    .edit button{
        color: #137e4c;
        background-color: #d1e7dd;
    }
    .delete button{
        color: red;
        background-color: #f8d7da;
    }
    .none{
        display: none;
    }
    .addCourse{
        position: fixed;
        padding: 15px;
        right: 30px;
        bottom: 30px;
        background-color: #137e4c;
        border-radius: 100px;
        text-align: center;
    }
    .addCourse a{
        text-decoration: none;
        color: #FFFFFF;
    }
    .addCourse i{
        font-size: 25px;
        width: 25px;
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

    function checkDeleteCourse (id) {
        let check = prompt('Для удаления курса введите delete');
        (check === 'delete') ? deleteCourse(id) : alert('Проверочное слово введено не верно')
        function deleteCourse(id) {
            let data = {
                id: id,
            }
            let params = "deleteCourse=" + data.id
            httpPost(`../request/requests.php`, params)
                .then(
                    response => {
                        (response === 'true') ? alert('Курс удален') : alert('Возникла непредвиденная ошибка')
                        document.location.href = '/admin/editCourse.php'
                    },
                    error => alert(`Rejected: ${error}`)
                );
        }
    }
</script>
<body>
<?php
    require 'headerAdmin.php';
?>
<div class="addCourse">
    <a href="/admin/newCourse.php">
        <i class="fas fa-plus"></i>
    </a>
</div>
<section class="editCourse">
    <h2>Редактирование курсов</h2>
    <table>
        <tr>
            <th class="tableID">ID</th>
            <th class="tableCourse">Наименование курса</th>
            <th class="tableCounter">Количество зарегистрированных</th>
            <th class="tableMaxCounter">Максимальное количество мест</th>
            <th class="edit"></th>
        </tr>
        <?php
            foreach ($courses as $value){
                echo '<tr><td class="tableID">'.$value["id_courses"].'</td><td>'.$value["name"].' <i class="'.$value["logo"].'"></i></td><td>'.$value["counter"].'</td><td>'.$value["counterMax"].'</td><td class="edit"><form action="/admin/changeCourse.php" method="post"><input type="text" value="'.$value["id_courses"].'" name="id" class="none"><button type="submit"><i class="fas fa-edit"></i></button></form></td></tr>';
            }
        ?>
    </table>
</section>
</body>
</html>