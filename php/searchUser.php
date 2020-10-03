<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    if(isset($_POST["searchText"]))
    {
        $currentUser = $_POST["currentUser"];
        $sql2 = "SELECT * FROM tbusers";
        $res = mysqli_query($mysqli, $sql2);
        $output = "";
        $friendRequestPending = false;
        $areFriends1 = false;
        $areFriends2 = false;
        while ($row = mysqli_fetch_assoc($res)) 
        {
            $name = $row["user_name"];
            if(strpos(strtolower($name),strtolower($_POST["searchText"])) !== false)
            {
                $surname = $row["user_surname"];
                $userID = $row["user_id"];
                $requests = "SELECT * FROM friend_requests WHERE request_from = $currentUser AND WHERE request_to = $userID";
                
                if ($res2 = mysqli_query($mysqli, $requests)) 
                {
                    $rowcount=mysqli_num_rows($res2);
                    if($rowcount > 0)
                    {
                        //friend request not pending
                        $friendRequestPending = true;
                    }
                }
                $friends = "SELECT * FROM friends WHERE user_id_1 = $currentUser AND WHERE user_id_2 = $userID";
                $friends2 = "SELECT * FROM friends WHERE user_id_1 = $userID AND WHERE user_id_2 = $currentUser";
                
                if ($res3 = mysqli_query($mysqli, $friends)) 
                {
                    $rowcount2=mysqli_num_rows($res3);
                    if($rowcount2 > 0)
                    {
                        // not friends 1
                        $areFriends1 = true;
                    }
                }

                if ($res4 = mysqli_query($mysqli, $friends2)) 
                {
                    $rowcount3=mysqli_num_rows($res4);
                    if($rowcount3 > 0)
                    {
                        // not friends 2
                        $areFriends2 = true;
                    }
                }
            }
        }
        if($friendRequestPending)
        {
            $output = $output . "<div class='searchUser'><a style='color: black;text-decoration: none;' href='profilepage.php?currentUserId=$currentUser&otherUserId=$userID'><h2>$name $surname</h2></a><i id='requestpending' class='fa fa-clock-o' aria-hidden='true'></i></div>";
        }
        else if($areFriends1 || $areFriends2)
        {
            $output = $output . "<div class='searchUser'><a style='color: black;text-decoration: none;' href='profilepage.php?currentUserId=$currentUser&otherUserId=$userID'><h2>$name $surname</h2></a><div onclick='messageFriend($currentUser,$userID)'><i class='fa fa-envelope' aria-hidden='true'></i></div></div>";
        }
        else
        {
            $output = $output . "<div class='searchUser'><a style='color: black;text-decoration: none;' href='profilepage.php?currentUserId=$currentUser&otherUserId=$userID'><h2>$name $surname</h2></a><div onclick='addFriend($userID)'><i class='fa fa-user-plus' aria-hidden='true'></i></div></div>";
        }
        echo $output;
    }
?>