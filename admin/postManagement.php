<?php
session_start();
if ($_SESSION['logged_user'] == []){header('Location: /admin/auth.php');}
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
require '../request/db.php';
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
    <title>Редактирование новостей - Центр дополнительного образования</title>
</head>
<style>
    .change, .delete{
        color: white;
        border-radius: 100px ;
        padding: 9px;
        border: none;
    }
    .change{
        background-color: green ;
    }
    .change:hover{
        background-color: darkgreen ;
    }
    .delete{
        background-color: red ;
        text-align: center ;
        margin-left: 10px ;
    }
    .delete:hover{
        background-color: darkred ;
    }
    .controls button, i{
        color: white;
        font-weight: 500;
        font-size: 15px !important;
    }
    .controls{
        position: absolute;
        bottom: 0;
        right: 0;
        margin: 0 10px 5px ;
        color: #ffffff;
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        text-transform: uppercase;
        padding: 0;
        line-height: 1;
        border-radius: 300px;
        z-index: 100;
    }
    .newsIndex:last-child{
        display: block;
    }
    .none{
        display: none;
    }
    .testForm{
        display: inline;
    }
    .page{
        max-width: 1200px;
        margin: 15px auto 10px;
        display: block;
    }
    .page a{
        text-align: center;
        width: 40px;
        height: 40px;
        padding: 10px;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
        font-family: "Trebuchet MS", sans-serif;
        color: #54595f;
        font-weight: 600;
        box-sizing: border-box;
    }
    .activePage{
        border: 3px solid white;
    }
</style>
<body>
<script>
    function httpGet(url) {
        return new Promise(function(resolve, reject) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    resolve(JSON.parse(this.response));
                } else {
                    const error = new Error(this.statusText);
                    error.code = this.status;
                    reject(error);
                }
            };
            xhr.onerror = function() {
                reject(new Error("Network Error"));
            };
            xhr.send();
        });
    }

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

    const checkDeletePost = (id) => {
        let check = prompt('Для удаления записи введите delete');
        (check === 'delete') ? deletePost(id) : alert('Проверочное слово введено не верно')
        function deletePost(id) {
            let data = {
                id: id,
            }
            let params = "deletePost="+data.id
            httpPost(`../request/requests.php`, params)
                .then(
                    response => {
                        (response !== []) ? alert('Запись удалена') : alert(response)
                        document.location.href = '/admin/postManagement.php'
                    },
                    error => alert(`Rejected: ${error}`)
                );
        }
    }
</script>
<?php
require 'headerAdmin.php';

$sql = "SELECT COUNT(*) as quantity FROM `news`";
$numberRecords = request($sql, []);
$numberRecords = ceil((int)$numberRecords[0]['quantity'] / 12);

if (!$_GET['getAllNews']){
    $_GET['getAllNews'] = 0;
}

$page = $_GET['getAllNews']++;

if ($_GET['getAllNews'] == true) { //getNewsForPage
    $from = 12 * --$_GET['getAllNews'];
    $sql = "SELECT `id`, `title`, `date`, `preview` FROM `news` ORDER BY date DESC LIMIT ".$from.", 12";
    $result = request($sql, []);
}

echo '<section class="sectionNewsIndex">';
echo '<div class="page">';
//$numberRecords = 100;
for ($i = 0; $i < $numberRecords; $i++){
    $i2 = $i + 1;
    if ($page == $i){
        echo '<span><a href="/admin/postManagement.php?getAllNews='.$i.'" id="page'.$i.'" class="activePage">'.$i2.'</a></span>';
    }else{
        echo '<span><a href="/admin/postManagement.php?getAllNews='.$i.'" id="page'.$i.'">'.$i2.'</a></span>';
    }
}

echo '</div>';
echo '<div class="blockNewsIndex" id="indexNews">';

foreach ($result as &$value){
    $value["date"] = date("d.m.Y", strtotime($value["date"]));
    echo '<article class="newsIndex">';
    echo '<a href="/новость.php?id='.$value[id].'"><img src="../image/news/'.$value[id].'/imagePreview/previewPhoto.jpg" alt="'.$value[title].'"></a>';
    echo '<div class="introduction">';
    echo '<a href="/новость.php?id='.$value[id].'"><h2>'.$value[title].'</h2></a>';
    echo '<p>'.$value[preview].'</p>';
    echo '<a href="/новость.php?id='.$value[id].'" class="readMoreIndex">ЧИТАТЬ ДАЛЕЕ >></a>';
    echo '</div>';
    echo '<span class="controls">';
    echo '<form method="post" action="/admin/editPost.php" class="testForm"><input type="text" value="'.$value[id].'" name="id" class="none">';
    echo '<button class="change" onclick="editPost('.$value[id].')">Изменить&nbsp;&nbsp;<i class="far fa-edit"></i></button>';
    echo '</form>';
    echo '<button class="delete" onclick="checkDeletePost('.$value[id].')">&nbsp;<i class="fas fa-trash-alt"></i>&nbsp;</button>';
    echo '</span>';
    echo '<div class="dataNews">';
    echo '<span class="data">'.$value[date].'</span>';
    echo '</div>';
    echo '</article>';
}
echo '</div>';
echo '</section>';
?>
</body>
</html>