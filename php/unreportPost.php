<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["postID"]))
    {
        $postID = $_POST["postID"];
        $sql = "UPDATE tbposts SET reports_id = '' WHERE post_id = $postID";
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