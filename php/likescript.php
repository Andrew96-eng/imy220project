<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["postID"]))
    {
        $postID = $_POST["postID"];
        $sql = "UPDATE tblikes SET number_likes = number_likes + 1 WHERE post_id = $postID";
      
        $response = $mysqli->query($sql);
      
        if ($response) 
        {
            $result = "";
            $selectSQL = "SELECT number_likes FROM tblikes WHERE post_id = $postID";
            $res2 = mysqli_query($mysqli, $selectSQL);
            
            if(mysqli_num_rows($res2) == 0)
            {
                $insertSql = "INSERT INTO tblikes (post_id, number_likes) VALUES ($postID, 1)";
                $response = $mysqli->query($insertSql);
                if ($response)
                {
                    echo 1;
                }
                else
                {
                    echo $sql;
                }
            }
            else
            {
                while ($row = mysqli_fetch_assoc($res2)) 
                {
                    $result = $row["number_likes"];
                    if($result !== '')
                    {
                    
                    }
                    else
                    {
                        $insertSql = "INSERT INTO tblikes (post_id, number_likes) VALUES ($postID, 1)";
                        $response = $mysqli->query($insertSql);
                        if ($response)
                        {
                            $result = '1';
                        }
                        else
                        {
                            $result = $sql;
                        }
                    }
                }
            }
        }
        else
        {
            
        } 
    }
