<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["commentID"]))
    {
        $commentId = $_POST["commentID"];
        $sql = "UPDATE tbcomments SET reports = reports + 1 WHERE comment_id = $commentId";
      
        $response = $mysqli->query($sql);
        if ($response) 
        {
            $selectSql = "SELECT reports FROM tbcomments WHERE comment_id = $commentId";
            $res2 = mysqli_query($mysqli, $selectSql);
            $result = '';
            while ($row = mysqli_fetch_assoc($res2)) 
            {
                $result = $row["reports"];
            }
        }

        echo $result;
    }
    else
    {
        echo "No ID";
    }
?>