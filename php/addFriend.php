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
?>