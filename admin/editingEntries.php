<?php
session_start();
if ($_SESSION['logged_user'] == []){header('Location: /admin/auth.php');}
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
require '../request/db.php';

$sql = "SELECT `enrollment`.`id_record`, `enrollment`.`status`,`users`.`login`,`users`.`phone`, `users`.`email`, `courses`.`name`, `courses`.`id_courses` FROM `enrollment` LEFT JOIN `courses` ON `enrollment`.`id_courses` = `courses`.`id_courses` LEFT JOIN `users` ON `enrollment`.`id_user` = `users`.`id_user`";
$result = request($sql, []);

$sql = "SELECT `courses`.`id_courses`, `courses`.`name` FROM courses";
$course = request($sql, []);

if ($_POST["editEntries"]){
    $sql = 'SELECT `id_courses` FROM enrollment WHERE `enrollment`.`id_record` = :id';
    $result = requestCount($sql, ["id"=>$_POST['editEntries']]);
    list($coursesID) = $result;

    $sql = 'SELECT * FROM courses WHERE `id_courses`=:id';
    $result = requestCount($sql, ["id"=>(int)$coursesID]);

    if ((int)$_POST["status"]){
        if ((int)--$result[4] >= 0){
            $sql = "UPDATE `enrollment` SET `status` = '0' WHERE `enrollment`.`id_record` = :id;";
            if (requestStatus($sql, ["id"=>$_POST["editEntries"]])){
                $sql = 'UPDATE `courses` SET `counter` = :counter WHERE `courses`.`id_courses` = :id;';
                requestStatus($sql, ["counter"=>(int)$result[4], "id"=>$coursesID]);
            }
            header('Location: /admin/editingEntries.php');
        }
    }else{
        if ((int)$result[5]>(int)$result[4]){
            $sql = "UPDATE `enrollment` SET `status` = '1' WHERE `enrollment`.`id_record` = :id;";
            if (requestStatus($sql, ["id"=>$_POST["editEntries"]])){
                $sql = 'UPDATE `courses` SET `counter` = :counter WHERE `courses`.`id_courses` = :id;';
                requestStatus($sql, ["counter"=>(int)++$result[4], "id"=>$coursesID]);
            }
        }
        header('Location: /admin/editingEntries.php');
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
    <script src="../script/script.js"></script>
    <title>Редактироание записавшихся</title>
</head>
<style>
    body{
        background-color: #f1f1f1;
        overflow-y: scroll;
    }
    body, input, textarea, select{
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    }
    .sort{
        padding: 15px 10px;
    }
    .sort form{
        display: flex;
        justify-content: space-between;
    }
    .sort input, .sort select, .search button{
        font-size: 18px;
        border: 1px solid black;
        padding: 5px;
    }
    .sort input:focus, .sort select:focus{
        outline: 1px solid black;
    }
    .enrollment{
        max-width: 1140px;
        margin: auto;
        padding: 25px;
    }
    .search button{
        background-color: #ffffff;
        padding: 0 15px;
    }
    table{
        width: 100%;
        border-collapse: collapse;
    }
    th, td{
        border: 1px solid black;
        padding: 10px 15px;
    }
    .tableID{
        text-align: center;
        width: 5%;
    }
    .tableCourse{
        width: 25%;
    }
    .tableName, .tablePhone, .tablePost{
        width: 20%;
    }
    .tableStatus{
        width: 10%;
        box-sizing: border-box;
        min-width: 124px;
    }
    .change, .delete{
        box-sizing: border-box;
        padding: 5px 10px;
    }
    .change{
        min-width: 53px;
        color: rgb(21, 87, 36);
    }
    .delete{
        min-width: 41px;
    }
    .change button i{
        color: #137e4c;
    }
    .delete button i{
        color: red;
    }
    .change button, .delete button{
        cursor: pointer;
        font-size: 28px;
        border: none;
        background-color: #f1f1f1;
    }
    .statusActive{
        text-align: center;
        background-color: rgb(212, 237, 218);
        color: rgb(21, 87, 36);
    }
    .statusInactive{
        text-align: center;
        background-color: #f8d7da;
        color: #721c24;
    }
    .noMatches{
        text-align: center;
        padding: 20px;
        font-weight: bold;
        text-transform: uppercase;
        background-color: #f8d7da;
        color: #721c24;
    }
    .none{
        display: none;
    }
</style>
<script>
    var result, table, value, data = {
        course: "",
        name: "",
        email: "",
        phone: "",
        status: "",
    }

    function searchEntries() {
        value = {
            course: document.getElementById("course").value,
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            status: document.getElementById("status").value,
        }
        if (JSON.stringify(data)===JSON.stringify(value)){
            return
        }

        data = value

        httpPost(`/request/requests.php?searchEnrollment=${1}&name=${data.name}&email=${data.email}&phone=${data.phone}`)
            .then(
                response => {
                    result = JSON.parse(response)
                    result.map((currentValue, index)=>{
                        if (data.course !== ''){
                            if (currentValue.id_courses != data.course){
                                delete result[index];
                            }
                        }
                        if(data.status !== ''){
                            if (currentValue.status != data.status){
                                delete result[index];
                            }
                        }
                    })
                    if (result.length === 0){
                        table = `<tr><td class="noMatches" colspan="8">совпадений не найденно</td></tr>`
                        document.getElementById('tbody').innerHTML = table
                        return
                    }
                    table = '<tbody id="tbody">'
                    result.map((currentValue)=>{
                        table += `<tr><td class="tableID">${currentValue.id_record}</td><td>${currentValue.name}</td><td>${currentValue.login}</td><td>${currentValue.email}</td><td>${currentValue.phone}</td>`
                        if (Number(currentValue.status)){
                            table += `<td class="statusActive">Активный</td>`
                        }else{
                            table += `<td class="statusInactive">Неактивный</td>`
                        }
                        table += `<td class="change"><form action="" method="post"><input type="text" class="none" name="editEntries" value="${currentValue.id_record}"><input type="text" class="none" name="status" value="${currentValue.status}"><button type="submit"><i class="fas fa-edit"></i></button></form></td><td class="delete"><button type="button" onclick="checkDeleteEntries(${currentValue.id_record})"><i class="fas fa-times"></i></button></td></tr>`
                    })
                    table += '</tbody>'
                    if (table === '<tbody id="tbody"></tbody>'){
                        table = `<tr><td class="noMatches" colspan="8">совпадений не найденно</td></tr>`
                        document.getElementById('tbody').innerHTML = table
                        return
                    }
                    document.getElementById('tbody').innerHTML = table
                },
                error => alert(`Rejected: ${error}`)
            );
    }

    function checkDeleteEntries (id) {
        let check = prompt('Для удаления записи введите delete');
        (check === 'delete') ? deleteEntries(id) : alert('Проверочное слово введено не верно')
        function deleteEntries(id) {
            let data = {
                id: id,
            }
            let params = "deleteEntries=" + data.id
            httpPost(`../request/requests.php`, params)
                .then(
                    response => {
                        (response === 'true') ? alert('Запись удалена') : alert('Возникла непредвиденная ошибка')
                        document.location.href = '/admin/editingEntries.php'
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
<section class="enrollment">
    <div class="sort">
        <form action="" method="post" class="search">
            <select name="" id="course" onchange="searchEntries()">
                <option value="">Все курсы</option>
                <?php
                foreach ($course as $item) {
                    echo '<option value="'.$item["id_courses"].'">'.$item["name"].'</option>';
                }
                ?>
            </select>
            <input type="text" id="name" placeholder="Имя" onchange="searchEntries()">
            <input type="text" id="email" placeholder="Почта" onchange="searchEntries()">
            <input type="text" id="phone" placeholder="Телефон" onchange="searchEntries()">
            <select name="" id="status" onchange="searchEntries()">
                <option value="">Все статусы</option>
                <option value="1">Активный</option>
                <option value="0">Неактивный</option>
            </select>
            <button type="button" onclick="searchEntries()"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <table>
        <thead>
        <tr>
            <th class="tableID">ID</th>
            <th class="tableCourse">Наименование курса</th>
            <th class="tableName">Имя</th>
            <th class="tablePost">Почта</th>
            <th class="tablePhone">Телефон</th>
            <th class="tableStatus">Статус</th>
            <th class="change"></th>
            <th class="delete"></th>
        </tr>
        </thead>
        <tbody id="tbody">
        <?php
            foreach ($result as &$value){
                echo '<tr><td class="tableID">'.$value["id_record"].'</td><td>'.$value["name"].'</td><td>'.$value["login"].'</td><td>'.$value["email"].'</td><td>'.$value["phone"].'</td>';
                if ((int)$value["status"]){
                    echo '<td class="statusActive">Активный</td>';
                }else{
                    echo '<td class="statusInactive">Неактивный</td>';
                }
                echo '<td class="change"><form action="" method="post"><input type="text" class="none" name="editEntries" value="'.$value["id_record"].'"><input type="text" class="none" name="status" value="'.(int)$value["status"].'"><button type="submit"><i class="fas fa-edit"></i></button></form></td><td class="delete"><button type="button" onclick="checkDeleteEntries('.$value["id_record"].')"><i class="fas fa-times"></i></button></td></tr>';
            }
        ?>
        </tbody>
    </table>
</section>
</body>
</html>