<?php
$GLOBALS["host"] = 'localhost';
$GLOBALS["dbname"] = 'root';
$GLOBALS["username"] = 'root';
$GLOBALS["password"] = 'diploma';
//запрос который возвращает данные в JSON
function requestJSON($request, $param){
    try {
        $db = new PDO('mysql:host='.$GLOBALS["host"].';dbname='.$GLOBALS["dbname"], $GLOBALS["username"], $GLOBALS["password"]);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $db->prepare($request);
        $result->execute($param);
        $result = ($result->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($result);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
//запрос который возвращает данные ($result[0])
function request($request, $param){
    try {
        $db = new PDO('mysql:host='.$GLOBALS["host"].';dbname='.$GLOBALS["dbname"], $GLOBALS["username"], $GLOBALS["password"]);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $db->prepare($request);
        $result->execute($param);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
//запрос для возвращения одного объекта
function requestCount($request, $param){
    try {
        $db = new PDO('mysql:host='.$GLOBALS["host"].';dbname='.$GLOBALS["dbname"], $GLOBALS["username"], $GLOBALS["password"]);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $db->prepare($request);
        $result->execute($param);
        return $result->fetch(PDO::FETCH_NUM);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
//запрос который возвращает статус операции (true/false)
function requestStatus($request, $param){
    try {
        $db = new PDO('mysql:host='.$GLOBALS["host"].';dbname='.$GLOBALS["dbname"], $GLOBALS["username"], $GLOBALS["password"]);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $db->prepare($request);
        return $result->execute($param);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}