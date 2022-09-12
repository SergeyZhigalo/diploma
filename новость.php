<?php
session_start();

if (!$_GET['id'])
    header('Location: /новости.php/');

require 'request/db.php';

$sql = "SELECT `id`, `title`, `date`, `newsText` FROM `news` WHERE id = :id";
$result = request($sql, ["id"=>$_GET['id']]);
$text = explode("\n", $result[0]["newsText"]);
$nocache = filectime('image/news/'.$_GET['id'].'/imagePreview/previewPhoto.jpg');

$files = array();
$imageH = scandir('image/news/'.$_GET['id'].'/horizontal/image');
$imageV = scandir('image/news/'.$_GET['id'].'/vertical/image');
unset($imageH[0], $imageH[1], $imageV[0], $imageV[1]);
array_push($files, $imageH, $imageV);
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
    <link href="/css/jquery.fancybox.min.css?nocache=<?php echo filectime('css/jquery.fancybox.min.css')?>" rel="stylesheet">
    <link href="/css/style.css?nocache=<?php echo filectime('css/style.css')?>" rel="stylesheet">
    <link href="/css/styleMainNews.css?nocache=<?php echo filectime('css/styleMainNews.css')?>" rel="stylesheet">
    <script src="/script/jquery-3.5.1.min.js?nocache=<?php echo filectime('script/jquery-3.5.1.min.js')?>"></script>
    <script src="/script/jquery.fancybox.min.js?nocache=<?php echo filectime('script/jquery.fancybox.min.js')?>"></script>
    <title><?php echo $result[0]["title"] ?></title>
</head>
<body>
<?php
    require 'header.php';
?>
<section class="sectionNews">
    <div class="mainNewsId">
        <div class="newsId">
            <article id="news">
                <div class="articleMain">
                    <img src="/image/news/<?php echo $_GET['id'] ?>/imagePreview/previewPhoto.jpg?nocache=<?php echo $nocache; ?>" alt="">
                    <h3><?php echo $result[0]["title"] ?></h3>
                    <div class="headingData">
                        <span><?php echo date("d.m.Y", strtotime($result[0]["date"])) ?></span>
                    </div>
                    <?php
                    foreach ($text as &$value){
                        echo '<p>'.$value.'</p>';
                    }
                    ?>
                    <div class="gallery">
                        <?php
                        foreach ($files[0] as &$value){
                            echo '<a data-fancybox="galleryNews" href="/image/news/'.$_GET['id'].'/horizontal/image/'.$value.'"><img src="image/news/'.$_GET['id'].'/horizontal/imageMin/'.$value.'" alt="'.$result[0]["title"].'" class="image"></a>';
                        }
                        ?>
                    </div>
                    <div class="gallery">
                        <?php
                        foreach ($files[1] as &$value){
                            echo '<a data-fancybox="galleryNews" href="/image/news/'.$_GET['id'].'/vertical/image/'.$value.'"><img src="image/news/'.$_GET['id'].'/vertical/imageMin/'.$value.'" alt="'.$result[0]["title"].'" class="image"></a>';
                        }
                        ?>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
<?php
    require 'footer.php';
?>
</body>
</html>