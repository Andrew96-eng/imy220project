<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["text"]))
    {
        $text = $_POST["text"];
        $sql = "INSERT INTO reports (report_desc) VALUES ('$text')";
        $result;
        $response = $mysqli->query($sql);
        if ($response) 
        {
            $result = 200;    
        }

        echo $result;
    }
    else
    {
        echo "No ID";
    }
?>