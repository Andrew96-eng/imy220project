<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["cUser"]))
    {
        $currentUser = $_POST["cUser"];
        $toUserId = $_POST["toid"];
        $messageText = $_POST["messageText"];
        $sql = "INSERT INTO tbmessages (to_id, from_id, message_text) VALUES ($toUserId, $currentUser, '$messageText')";
        $response2 = $mysqli->query($sql);
        if ($response2)
        {
            echo 200;
        }

    }
?>