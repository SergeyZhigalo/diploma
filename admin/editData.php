<script>
    function redirect(id) {
        let form = document.createElement('form');
        form.action = '/admin/editPost.php';
        form.method = 'POST';
        form.innerHTML = '<input name="id" value="'+id+'">';
        document.body.append(form);
        form.submit();
    }
</script>
<?php
require '../request/db.php';

$widthPreviewPictureMin = 372;
$widthPreviewPicture = 672;
$fP = "/imagePreview"; //$folderPreview
$fR = "../image/news/".$_POST["id"];
$fV = "/vertical";     //$folderVertical
$fH = "/horizontal";   //$folderHorizontal
$fMS = "/imageMin";    //$folderMiniSize
$fFS = "/image";       //$folderFullSize

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

//превью
if (($_FILES['previewPicture']['tmp_name']) == true){ //превью фото
    list($width, $height) = getimagesize($_FILES['previewPicture']['tmp_name']);
    $factor = $height / $width;
    $width = $widthPreviewPicture;
    $height = intval($widthPreviewPicture * $factor);
    savedImage($_FILES['previewPicture']['tmp_name'], 'previewPhoto.jpg', $width, $height, $fR.$fP.'/');
    $width = $widthPreviewPictureMin;
    $height = intval($widthPreviewPictureMin * $factor);
    savedImage($_FILES['previewPicture']['tmp_name'], 'previewPhotoMin.jpg', $width, $height, $fR.$fP.'/');
    echo '<script>redirect('.$_POST['id'].')</script>';
}

//основа
$sql = 'SELECT `photoCounter` FROM news WHERE id=:id';
if ($_POST['id'] == true) {
    $photoCounter = request($sql, ['id'=>$_POST['id']]);
    $photoCounter = $photoCounter["0"]["photoCounter"];
}

if ($_FILES['picture'] == true)//основные фото
{
    for ($i = 0; $i < count($_FILES['picture']['name']); $i++)
    {
        list($width, $height) = getimagesize($_FILES['picture']['tmp_name'][$i]);
        $size = getimagesize($_FILES['picture']['tmp_name'][$i]);
        $factor = $height / $width;
        if ($width > $height)
        {
            $width = 1920;
            $height = intval(1920 * $factor);
            savedImage($_FILES['picture']['tmp_name'][$i], $photoCounter.'.jpg', $width, $height, $fR . $fH . $fFS . '/');
            savedImage($_FILES['picture']['tmp_name'][$i], $photoCounter.'.jpg', 640, 410, $fR . $fH . $fMS . '/');
            $photoCounter++;
        } else {
            $width = 1920;
            $height = intval(1920 * $factor);
            savedImage($_FILES['picture']['tmp_name'][$i], $photoCounter.'.jpg', $width, $height, $fR . $fV . $fFS . '/');
            savedImage($_FILES['picture']['tmp_name'][$i], $photoCounter.'.jpg', 640, 856, $fR . $fV . $fMS . '/');
            $photoCounter++;
        }
    }
    echo '<script>redirect('.$_POST['id'].')</script>';
}

$sql = 'UPDATE `news` SET `photoCounter` = :photoCounter WHERE `news`.`id` = :id;';
if ($_POST['id'] == true) {
    $photoCounter = request($sql, ["photoCounter"=>$photoCounter,'id'=>$_POST['id']]);
}
?>
<body>
</body>