<?php
session_start();
if ($_SESSION['logged_user'] == []){header('Location: /admin/auth.php');}
if ($_SESSION['logged_user']['role'] == 'user'){header('Location: /lk.php');}
require '../request/db.php';
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
    <link href="../css/font-awesome.css" rel="stylesheet">
    <title>Добавление новости - Центр дополнительного образования</title>
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
    input[type="text"]{
        width: 400px;
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
</style>
<body>
<?php
    require 'headerAdmin.php';
?>
    <div class="add" id="add">
        <form method="post" enctype="multipart/form-data">
            <p>
                <label for="name">Название статьи</label>
                <input type="text" name="name" id="name" maxlength="255" required>
            </p>
            <p>
                <label for="data">Дата</label>
                <input type="date" name="data" id="data" required></p>
            <p>
                <label for="preview">Превью текст</label>
                <textarea name="preview" id="preview" maxlength="5000"></textarea>
            </p>
            <p>
                <label for="text">Основной текст</label>
                <textarea name="text" id="text" maxlength="5000"></textarea>
            </p>
            <p>
                <label for="previewPicture">
                    Добавить превью изображение
                    <br>
                    <span>Выбрать изображение</span>
                </label>
                <input type="file" name="previewPicture" id="previewPicture" accept="image/jpeg, image/jpeg, image/png">
            </p>
            <div class="demonstrationPreviewPicture">
                <p>Превью изображение не выбрано</p>
            </div>
            <p>
                <label for="picture">
                    Добавить изображения
                    <br>
                    <span>Выбрать изображения</span>
                </label>
                <input type="file" name="picture[]" id="picture" accept="image/jpeg, image/jpeg, image/png" multiple>
            </p>
            <div class="demonstrationPicture">
                <p>Изображения не выбраны</p>
            </div>
            <p>
                <button type="submit" name="addNews" id="addNews" value="Загрузить">Добавить новость</button>
            </p>
        </form>
    </div>
</body>
</html>
<script>
    const previewPicture = document.querySelector('#previewPicture');
    const demonstrationPreviewPicture = document.querySelector('.demonstrationPreviewPicture');
    previewPicture.addEventListener('change', updateDemonstrationPreviewPicture);
    function updateDemonstrationPreviewPicture() {
        while(demonstrationPreviewPicture.firstChild) {
            demonstrationPreviewPicture.removeChild(demonstrationPreviewPicture.firstChild);
        }
        const curFiles = previewPicture.files;
        if(curFiles.length === 0) {
            const para = document.createElement('p');
            para.textContent = 'Превью изображение не выбрано';
            demonstrationPreviewPicture.appendChild(para);
        } else {
            for(const file of curFiles) {
                const div = document.createElement('div');
                div.className = 'image'
                if(validFileType(file)) {
                    const image = document.createElement('img');
                    image.src = URL.createObjectURL(file);
                    div.appendChild(image);
                    demonstrationPreviewPicture.appendChild(div);
                } else {
                    const para = document.createElement('p');
                    para.innerHTML = `Файл <span>${file.name}</span> имеет неверный формат`;
                    demonstrationPreviewPicture.appendChild(para);
                }
            }
        }
    }
    const picture = document.querySelector('#picture');
    const demonstrationPicture = document.querySelector('.demonstrationPicture');
    picture.addEventListener('change', updateDemonstrationPicture);
    function updateDemonstrationPicture() {
        while(demonstrationPicture.firstChild) {
            demonstrationPicture.removeChild(demonstrationPicture.firstChild);
        }
        const curFiles = picture.files;
        if(curFiles.length === 0) {
            const para = document.createElement('p');
            para.textContent = 'Изображения не выбраны';
            demonstrationPicture.appendChild(para);
        } else {
            for(const file of curFiles) {
                const div = document.createElement('div');
                div.className = 'image'
                if(validFileType(file)) {
                    const image = document.createElement('img');
                    image.src = URL.createObjectURL(file);
                    div.appendChild(image);
                    demonstrationPicture.appendChild(div);
                } else {
                    demonstrationPicture.style.display = 'block';
                    const para = document.createElement('p');
                    para.innerHTML = `Файл <span>${file.name}</span> имеет неверный формат`;
                    demonstrationPicture.appendChild(para);
                }
            }
        }
    }
    const fileTypes = [
        'image/jpeg',
        'image/png',
    ];
    function validFileType(file) {
        return fileTypes.includes(file.type);
    }
</script>
<?php
$quality = 100;
$fP = "/imagePreview"; //$folderPreview
$fV = "/vertical";     //$folderVertical
$fH = "/horizontal";   //$folderHorizontal
$fMS = "/imageMin";    //$folderMiniSize
$fFS = "/image";       //$folderFullSize
$widthPreviewPictureMin = 372;
$widthPreviewPicture = 672;

function imageResize($outfile,$infile,$neww,$newh,$quality) { //изменение размера изображений
    $im=imagecreatefromjpeg($infile);
    $im1=imagecreatetruecolor($neww,$newh);
    imagecopyresampled($im1,$im,0,0,0,0,$neww,$newh,imagesx($im),imagesy($im));
    imagejpeg($im1,$outfile,$quality);
    imagedestroy($im);
    imagedestroy($im1);
}

function savedImage ($tmp_name, $name, $neww, $newh, $dest){ //сохранение изображений
    imageResize($tmp_name, $tmp_name, $neww, $newh, 100);
    echo (!@copy($tmp_name, $dest.$name)) ? '<div>Что-то пошло не так</div><hr>' : '<div>Загрузка изображения прошла удачно</div><hr>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['addNews'])
{
    $sql = "SHOW TABLE STATUS LIKE 'news'";
    $result = request($sql, []);

    $nextNumber = (intval($result[0]['Auto_increment']));
    $fR = "../image/news/".$nextNumber;

    //создание папок
    echo (mkdir($fR) and mkdir($fR.$fP) and mkdir($fR.$fV) and mkdir($fR.$fH) and mkdir($fR.$fV.$fMS) and mkdir($fR.$fV.$fFS) and mkdir($fR.$fH.$fMS) and mkdir($fR.$fH.$fFS)) ? '<hr>Папка успешно создана<hr>' : '<hr>Папка не создана<hr>';

    if (($_FILES['previewPicture']['tmp_name'][0]) != ''){ //превью фото
        list($width, $height) = getimagesize($_FILES['previewPicture']['tmp_name']);
        $factor = $height / $width;
        $width = $widthPreviewPicture;
        $height = intval($widthPreviewPicture * $factor);
        savedImage($_FILES['previewPicture']['tmp_name'], 'previewPhoto.jpg', $width, $height, $fR.$fP.'/');
        $width = $widthPreviewPictureMin;
        $height = intval($widthPreviewPictureMin * $factor);
        savedImage($_FILES['previewPicture']['tmp_name'], 'previewPhotoMin.jpg', $width, $height, $fR.$fP.'/');
    }

    $i = 0;
    if (($_FILES['picture']['tmp_name'][0]) != '')//основные фото
    {
        for ($i; $i < count($_FILES['picture']['name']); $i++)
        {
            list($width, $height) = getimagesize($_FILES['picture']['tmp_name'][$i]);
            $size = getimagesize($_FILES['picture']['tmp_name'][$i]);
            $factor = $height / $width;
            $width = 1920;
            $height = intval(1920 * $factor);
            if ($width > $height)
            {
                savedImage($_FILES['picture']['tmp_name'][$i], $i.'.jpg', $width, $height, $fR . $fH . $fFS . '/');
                savedImage($_FILES['picture']['tmp_name'][$i], $i.'.jpg', 640, 410, $fR . $fH . $fMS . '/');
            } else {
                savedImage($_FILES['picture']['tmp_name'][$i], $i.'.jpg', $width, $height, $fR . $fV . $fFS . '/');
                savedImage($_FILES['picture']['tmp_name'][$i], $i.'.jpg', 640, 856, $fR . $fV . $fMS . '/');
            }
        }
    }

    function removeDir($path) {
        if (file_exists($path) AND is_dir($path))
        {
            $dir = opendir($path);
            while (false !== ( $element = readdir($dir))) {
                if ($element != '.' AND $element != '..')
                {
                    $tmp = $path.'/'.$element;
                    chmod($tmp, 0777);
                    if (is_dir($tmp))
                    {
                        removeDir($tmp);
                    } else {
                        unlink($tmp);
                    }
                }
            }
            closedir($dir);
            if (file_exists($path)){
                rmdir($path);
            }
        }
    }

    $sql = "INSERT INTO `news` (`id`, `title`, `rubric`, `date`, `preview`, `newsText`, `video`, `photoCounter`) VALUES (NULL, :title, 'Без рубрики', :dateCreate, :preview, :newsText, '', :photoCounter);";
    $result = requestStatus($sql, ['title' => $_POST['name'], /*'rubric' => $_POST['rubric'],*/ 'dateCreate' => $_POST['data'], 'preview' => $_POST['preview'], 'newsText' => $_POST['text'], /*'video' => $_POST['video'],*/ 'photoCounter' => $i]);
    if ($result){
        echo "<script> alert(`Новость успешно создана`); document.location.href = '/admin/index.php' </script>";

    }else{
        removeDir($fR);
        echo "<script> alert(`Возникла непредвиденная ошибка`); document.location.href = '/admin/index.php' </script>";
    }
}