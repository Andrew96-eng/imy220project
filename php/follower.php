<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["uId"]) && isset($_POST["cUser"]))
    {
        $userId = $_POST["uId"];
        $currentUser = $_POST["cUser"];
        $sql = "INSERT INTO tbfollowers (follower_userId,follows_userId) VALUES ($currentUser,$userId)";
        $response = $mysqli->query($sql);
        if ($response) {
        }
        echo 200;
    }
?>