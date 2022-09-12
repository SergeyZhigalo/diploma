<?php
session_start();
if ($_SESSION['logged_user'] == []){header('Location: /admin/auth.php');}
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
require '../request/db.php';
if (!$_POST["id"]){header('Location: /');}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/image/logo/favicon.png" type="image/png">
    <link href="../css/style.css" rel="stylesheet">
    <link href="/css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="../css/font-awesome.css" rel="stylesheet">
    <title>Изменение новости - Центр дополнительного образования</title>
</head>
<style>
    body{
        background-color: #f1f1f1;
        overflow-y: scroll;
    }
    body, input, textarea{
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    }
    .add{
        max-width: 1140px;
        margin: auto;
        padding: 25px;
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
    .w800{
        width: 800px;
    }
    .w100{
        width: 100px;
    }
    input[type="text"], input[type="date"], textarea{
        border: 1px solid black;
        font-size: 20px;
        padding: 5px;
    }
    input[type="text"]:focus, input[type="date"]:focus, textarea:focus{
        outline: 1px solid black;
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
    input[type="file"]{
        display: none;
    }
    input[type="file"]:focus{
        outline: none;
    }
    label{
        margin-bottom: 3px;
    }
    .demonstrationPreviewPicture, .demonstrationPicture{
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }
    .demonstrationPreviewPicture p, .demonstrationPicture p{
        border-left: 4px solid red;
        padding-left: 10px;
    }
    .demonstrationPreviewPicture span, .demonstrationPicture span{
        display: inline;
    }
    .image{
        width: 25%;
    }
    .image img{
        width: 95%;
        margin: 2.5% 2.5% 0;
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
    .gallery {
        margin: 0 auto;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }
    .gallery:nth-child(1n){
        padding-top: 5px;
    }
    .gallery:last-child{
        padding-bottom: 6%;
    }
    .gallery .rel{
        width: 33.333%;
        flex-grow: 1;
    }
    .gallery img {
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        padding: 5px;
    }
    .previewPhoto{
        width: 100%;
    }
    .editPreviewPicture{
        margin-bottom: 50px;
    }
    .none{
        display: none;
    }
    .delete{
        color: white;
        border-radius: 100px ;
        padding: 9px;
        border: none;
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
        margin: 0 15px 15px ;
        color: #ffffff;
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        text-transform: uppercase;
        padding: 0;
        line-height: 1;
        border-radius: 300px;
        z-index: 1000000;
    }
    .rel{
        position: relative;
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

    checkDeletePhoto = (id, value, dir) =>{
        let check = prompt('Для удаления записи введите delete');
        (check === 'delete') ? deletePhoto(id, value) : alert('Проверочное слово введено не верно')
        function deletePhoto() {
            let data = {
                id: id,
                value: value,
                dir: dir,
            }
            let params = "deletePhoto="+data.id+"&deleteImage="+data.value+"&dir="+data.dir
            httpPost(`../request/requests.php`, params)
                .then(
                    response => {
                        (response !== []) ? alert('Фотография удалена') : alert(response)
                        let form = document.createElement('form');
                        form.action = '/admin/editPost.php';
                        form.method = 'POST';
                        form.innerHTML = '<input name="id" value="'+id+'">';
                        document.body.append(form);
                        form.submit();
                    },
                    error => alert(`Rejected: ${error}`)
                );
        }
    }

    editPost = () => {
        let data = {
            id: document.getElementById("id").value,
            name: document.getElementById("name").value,
            data: document.getElementById("data").value,
            preview: document.getElementById("preview").value,
            text: document.getElementById("text").value,
        }
        let params = "idChangeNews="+data.id+"&name="+data.name+"&data="+data.data+"&preview="+data.preview+"&text="+data.text+"&video="+data.video
        httpPost(`../request/requests.php`, params)
            .then(
                response => {
                    (response !== []) ? alert('Данные измененны') : alert(response)
                },
                error => alert(`Rejected: ${error}`)
            )
    }
</script>
<body>
<?php
require 'headerAdmin.php';

if ($_POST["id"] == true) {
    $sql = "SELECT * FROM news WHERE id = :id";
    $result = request($sql, ["id"=>$_POST["id"]]);
    $result = $result[0];
    $files = array();
    $imageH = scandir('../image/news/'.$_POST["id"].'/horizontal/image');
    $imageV = scandir('../image/news/'.$_POST["id"].'/vertical/image');
    unset($imageH[0], $imageH[1], $imageV[0], $imageV[1]);
    array_push($files, $imageH, $imageV);
}
?>
<div class="add" id="add">
    <p>
        <label for="id">ID новости</label>
        <input type="text" class="w100" name="id" id="id" value="<?php echo $result["id"] ?>" disabled>
    </p>

    <p>
        <label for="name">Название новости</label>
        <input type="text" class="w800" name="name" id="name" value="<?php echo $result["title"] ?>" maxlength="255" required>
    </p>
    <p>
        <label for="data">Дата</label>
        <input type="date" name="data" id="data" value="<?php echo $result["date"] ?>" required></p>
    <p>
        <label for="preview">Превью текст</label>
        <textarea name="preview" id="preview" maxlength="5000"><?php echo $result["preview"] ?></textarea>
    </p>
    <p>
        <label for="text">Основной текст</label>
        <textarea name="text" id="text" maxlength="5000"><?php echo $result["newsText"] ?></textarea>
    </p>
    <p>
        <button type="button" onclick="editPost()">Принять изменения</button>
    </p>
    <p>
        <label for="">Превью фото</label>
        <img class="previewPhoto" src="<?php echo'../image/news/'.$_POST["id"].'/imagePreview/previewPhoto.jpg?nocache='.filectime('../image/news/'.$_POST["id"].'/imagePreview/previewPhoto.jpg')?>" alt="">
    </p>
    <p class="editPreviewPicture">
        <label for="previewPicture">
            Изменить превью изображение
            <br>
            <span>Выбрать изображение</span>
        </label>
        <form method="post" enctype="multipart/form-data" action="/admin/editData.php">
            <input type="text" value="<?php echo $result["id"] ?>" name="id" class="none">
            <input type="file" name="previewPicture" onchange="this.form.submit();" id="previewPicture" accept="image/jpeg, image/jpeg, image/png">
        </form>
    </p>
    <p>
    <?php
    if ($files[0] != []){
        echo '<label for="">Горизонтальные фото</label>';
    }
    ?>
        <div class="gallery">
        <?php
            foreach ($files[0] as &$value){
                echo '<span class="rel"><span class="controls"><button class="delete" onclick="checkDeletePhoto('.$result["id"].',`'.$value.'`,`/horizontal`)">&nbsp;<i class="fas fa-trash-alt"></i>&nbsp;</button></span><img src="../image/news/'.$_POST["id"].'/horizontal/image/'.$value.'"></span>';
            }
        ?>
        </div>
    </p>
    <p>
    <?php
        if ($files[1] != []){
            echo '<label for="">Вертикальные фото</label>';
        }
    ?>
        <div class="gallery">
        <?php
            foreach ($files[1] as &$value){
                echo '<span class="rel"><span class="controls"><button class="delete" onclick="checkDeletePhoto('.$result["id"].',`'.$value.'`,`/vertical`)")">&nbsp;<i class="fas fa-trash-alt"></i>&nbsp;</button></span><img src="../image/news/'.$_POST["id"].'/vertical/image/'.$value.'"></span>';
            }
        ?>
        </div>
    </p>
    <?php
        echo '<p>';
        echo '<label for="picture">';
        echo 'Добавить изображения';
        echo '<br>';
        echo '<span>Выбрать изображения</span>';
        echo '</label>';
        echo '<form method="post" enctype="multipart/form-data" action="/admin/editData.php">';
        echo '<input type="text" value="'.$result["id"].'" name="id" class="none">';
        echo '<input type="file" name="picture[]" onchange="this.form.submit();" id="picture" accept="image/jpeg, image/jpeg, image/png" multiple>';
        echo '</form>';
        echo '</p>';
    ?>
</div>
</body>
</html>