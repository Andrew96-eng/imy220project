<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["userId"]) && isset($_POST["currentUser"]))
    {
        $requestsql = "INSERT INTO friend_requests (request_from,request_to) VALUES (" . $_POST["currentUser"] . "," . $_POST["userId"] . ")";
        $response = $mysqli->query($requestsql);
        if ($response) 
        {
            echo 200;
        }
    }
    else if(isset($_POST["uId"]) && isset($_POST["cUser"]))
    {
        $userId = $_POST["uId"];
        $currentID = $_POST["cUser"];
        $requestId = $_POST["rid"];
        $sql = "DELETE FROM friend_requests WHERE request_id = $requestId";
        $insertSQL = "INSERT INTO friends (user_id_1,user_id_2) VALUES($userId,$currentID)";
        $response = $mysqli->query($sql);
        if ($response) {

        }
        $response2 = $mysqli->query($insertSQL);
        if ($response2) {

        }
        echo 200;
    }
?>