<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["postID"]))
    {
        $postId = $_POST["postID"];
        $sql = "DELETE FROM tbposts WHERE post_id = $postId";
        $response = $mysqli->query($sql);
        if ($response)
        {
            $commentSql = "DELETE FROM tbcomments WHERE post_id = $postId";
            $response2 = $mysqli->query($commentSql);
            if ($response2)
            {
                $albumSql = "SELECT * From tbalbums";
                $albumres = mysqli_query($mysqli, $albumSql);
                while ($row = mysqli_fetch_assoc($albumres)) {
                    $postArray = explode(';', $row["posts_id"]);
                    if(in_array($postId, $postArray))
                    {
                        $deleteAlbum = "DELETE FROM tbalbums WHERE albumId = " . $row["albumId"];
                        $response3 = $mysqli->query($deleteAlbum);
                    }   
                }
                echo "Deleted";
            }
        }
        else
        {
            echo "Failed to delete.";
        }
    }
?>