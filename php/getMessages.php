<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["cUser"]))
    {
        $currentUser = $_POST["cUser"];
        $toUserId = $_POST["toid"];
        $returnString = "";
        $sql = "SELECT * FROM tbmessages WHERE to_id = $currentUser AND from_id = $toUserId";
        $res2 = mysqli_query($mysqli, $sql);
        while($row = mysqli_fetch_assoc($res2))
        {
            $returnString = "<p> User sent: " . $row["message_text"] . "</p>";
        }
        echo $returnString;

        $deleteSql = "DELETE FROM tbmessages WHERE to_id = $currentUser AND from_id = $toUserId";
        $response2 = $mysqli->query($deleteSql);
        if ($response2)
        {
            
        }
    }
?>