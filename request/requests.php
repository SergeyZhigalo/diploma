<?php
require '../request/db.php';
$requests = array(
    "getNewsForIndex" => "SELECT `id`, `title`, `rubric`, `date`, `preview` FROM `news` where `rubric` != 'null' ORDER BY date DESC LIMIT 3",
    "getNumberOfRecordsFound" => "SELECT COUNT(*) as kolvo FROM news WHERE title LIKE :search",
    "getSearchRecords" => "SELECT `id`, `title`, `date`, `preview` FROM `news` WHERE `title` LIKE :search ORDER BY date DESC",
    "getNews" => "SELECT `id`, `title`, `date`, `newsText` FROM `news` WHERE id = :id",
    "getAllRubric" => "SELECT * FROM `rubric`",
    "deletePost" => "DELETE FROM `news` WHERE `news`.`id` = :id",
    "changeNews" => "UPDATE `news` SET `title` = :title, `date` = :date, `preview` = :preview, `newsText` = :newsText WHERE `news`.`id` = :id;",
);
if ($_GET['getAllNews'] == true) { //getNewsForPage
    $from = 5 * --$_GET['getAllNews'];
    $sql = "SELECT `id`, `title`, `date`, `preview` FROM `news` ORDER BY date DESC LIMIT ".$from.", 5";
    requestJSON($sql, []);
}
if ($_GET['getIndexNews'] == true) { //getNewsForIndex
    requestJSON($requests["getNewsForIndex"], []);
}
if ($_GET['checkSearch'] == true) { //getNumberOfRecordsFound
    $_GET['checkSearch'] = "%".$_GET['checkSearch']."%";
    requestJSON($requests["getNumberOfRecordsFound"], ['search' => $_GET['checkSearch']]);
}
if ($_GET['getSearch'] == true) { // getSearchRecords
    $_GET['getSearch'] = "%".$_GET['getSearch']."%";
    requestJSON($requests["getSearchRecords"], ['search' => $_GET['getSearch']]);
}
if ($_GET['getNews'] == true) {
    requestJSON($requests["getNews"], ['id'=>$_GET['getNews']]);
}
if ($_GET['getNewsImage'] == true) {
    $files = array();
    $imageH = scandir('../image/news/'.$_GET['getNewsImage'].'/horizontal/image');
    $imageV = scandir('../image/news/'.$_GET['getNewsImage'].'/vertical/image');
    unset($imageH[0], $imageH[1], $imageV[0], $imageV[1]);
    array_push($files, $imageH, $imageV);
    echo json_encode($files);
}
if ($_GET['getAllRubric'] == true) {
    requestJSON($requests["getAllRubric"], []);
}

if ($_POST['deletePost'] == true) {
    requestJSON($requests["deletePost"], ['id'=>$_POST['deletePost']]);
}

if ($_POST['deletePhoto'] == true){
    $path = '../image/news/'.$_POST['deletePhoto'].'/'.$_POST['dir'].'/image/'.$_POST['deleteImage'];
    $pathMin = '../image/news/'.$_POST['deletePhoto'].'/'.$_POST['dir'].'/imageMin/'.$_POST['deleteImage'];
    if (unlink($path) and unlink($pathMin)){
        echo 'удачно';
    }else{
        echo 'провал';
    }
}

if ($_POST['idChangeNews'] == true){
    requestJSON($requests["changeNews"], ['title'=>$_POST['name'], 'date'=>$_POST['data'], 'preview'=>$_POST['preview'], 'newsText'=>$_POST['text'], /*'video'=>$_POST['video'],*/ 'id'=>$_POST['idChangeNews']] );
}

if ($_POST['inactiveStatusID'] == true){
    $sql = 'SELECT `status` FROM enrollment WHERE `enrollment`.`id_record` = :id';
    $result = requestCount($sql, ["id"=>$_POST['inactiveStatusID']]);

    if ((bool)$result[0]){
        $sql = 'SELECT `id_courses` FROM enrollment WHERE `enrollment`.`id_record` = :id';
        $result = requestCount($sql, ["id"=>$_POST['inactiveStatusID']]);
        list($coursesID) = $result;

        $sql = 'SELECT * FROM courses WHERE `id_courses`=:id';
        $result = requestCount($sql, ["id"=>(int)$coursesID]);

        if ((int)--$result[4] >= 0){
            $sql = "UPDATE `enrollment` SET `status` = '0' WHERE `enrollment`.`id_record` = :id;";
            if (requestStatus($sql, ["id"=>$_POST['inactiveStatusID']])){
                $sql = 'UPDATE `courses` SET `counter` = :counter WHERE `courses`.`id_courses` = :id;';
                echo json_encode(requestStatus($sql, ["counter"=>(int)$result[4], "id"=>$coursesID]));
            }
        }
    }
}

if ($_POST['deleteCourse'] == true){
    $sql = "DELETE FROM `courses` WHERE `courses`.`id_courses` = :id";
    echo json_encode(requestStatus($sql, ["id"=>$_POST['deleteCourse']]));
}

if ($_GET['searchEnrollment'] == true) {
    $sql = "SELECT `enrollment`.`id_record`, `enrollment`.`status`,`users`.`login`,`users`.`phone`, `users`.`email`, `courses`.`name`, `courses`.`id_courses` FROM `enrollment` LEFT JOIN `courses` ON `enrollment`.`id_courses` = `courses`.`id_courses` LEFT JOIN `users` ON `enrollment`.`id_user` = `users`.`id_user` WHERE `users`.`login` LIKE '%".$_GET['name']."%' and `users`.`phone` LIKE '%".$_GET['phone']."%' and `users`.`email` LIKE '%".$_GET['email']."%'";
    requestJSON($sql, []);
}

if ($_POST['deleteEntries'] == true) {
    $sql = 'SELECT `id_courses` FROM enrollment WHERE `enrollment`.`id_record` = :id';
    $result = requestCount($sql, ["id"=>$_POST['deleteEntries']]);
    list($coursesID) = $result;

    $sql = 'SELECT * FROM courses WHERE `id_courses`=:id';
    $result = requestCount($sql, ["id"=>(int)$coursesID]);

    if ((int)--$result[4] >= 0){
        $sql = "DELETE FROM `enrollment` WHERE `enrollment`.`id_record` = :id;";
        if (requestStatus($sql, ["id"=>$_POST['deleteEntries']])){
            $sql = 'UPDATE `courses` SET `counter` = :counter WHERE `courses`.`id_courses` = :id;';
            echo json_encode(requestStatus($sql, ["counter"=>(int)$result[4], "id"=>$coursesID]));
        }
    }
}