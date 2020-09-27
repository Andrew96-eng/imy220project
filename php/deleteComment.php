<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["commentID"]))
    {
        $commentId = $_POST["commentID"];
        $sql = "DELETE FROM tbcomments WHERE comment_id=$commentId";
        $response = $mysqli->query($sql);
      
        if ($response) 
        {
            echo "Ok";
        }
        else
        {
            echo "No such comment found.";
        }
    }
    else
    {
        echo "No ID";
    }
?>