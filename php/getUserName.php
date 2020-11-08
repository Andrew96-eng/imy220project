<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["userId"]))
    {
        $sql = "SELECT user_name FROM tbusers WHERE user_id = " . $_POST["userId"];
        $res2 = mysqli_query($mysqli, $sql);
        while($row = mysqli_fetch_assoc($res2))
        {
            echo $row["user_name"];
        }
    }
?>