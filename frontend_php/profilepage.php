<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    $userID = "";
    $otherUserId = "-1";
    $userFirstName = "";
    $userSurname = "";
    $userProPic = "";
    if(isset($_GET["userId"]))
    {
        $userID= $_GET["userId"];
        $sql = "SELECT * FROM tbusers WHERE user_id=" . $userID;
        $res = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $userFirstName = $row["user_name"];
            $userSurname = $row["user_surname"];
            $userProPic = $row["profile_picture"];
        }
    }
    else if(isset($_POST["submitpropic"]))
    {
        $userID = $_POST["userID"];
        $imagePath = "../images/";   
        $picToUpload = basename($_FILES["userProfilepic"]["name"][0]);
        $tmpFilePath = $_FILES['userProfilepic']['tmp_name'][0];

        if ($tmpFilePath != "") {
            $imagePath = $imagePath . $picToUpload;

            move_uploaded_file($_FILES["userProfilepic"]["tmp_name"][0], $imagePath);
            $updateSql = "UPDATE tbusers SET profile_picture = '$picToUpload' WHERE user_id = $userID";
            $response = $mysqli->query($updateSql);
            if ($response) {
                //TODO:
                //Show snackbar of uploaded?
            }
            else
            {
                //nah fam
            }
        }

        $sql = "SELECT * FROM tbusers WHERE user_id=" . $userID;
        $res = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $userFirstName = $row["user_name"];
            $userSurname = $row["user_surname"];
            $userProPic = $row["profile_picture"];
        }
    }
    else if(isset($_GET["currentUserId"]))
    {
        $userID = $_GET["currentUserId"];
        $otherUserId = $_GET["otherUserId"];

        $sql = "SELECT * FROM tbusers WHERE user_id=" . $otherUserId;
        $res = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $userFirstName = $row["user_name"];
            $userSurname = $row["user_surname"];
            $userProPic = $row["profile_picture"];
        }
    }
?>

<!DOCTYPE html>
<html>

<head lang="en">
  <title>Share You.</title>
  <meta name="author" content="Andrew Wilson">
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/homepageStyles.css">
  <link rel="stylesheet" href="../css/profilepage.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Permanent%20Marker">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source%20Sans%20Pro">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Caveat">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


  <link rel="apple-touch-icon" sizes="180x180" href="../images/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon/favicon-16x16.png">
  <link rel="manifest" href="../images/favicon/site.webmanifest">
</head>

<body style="background-image: url(../images/repeated-square/repeated-square.png);">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-2">
    <a class="navbar-brand" href="homepage.php?id=<?php echo $userID; ?>">
      <h1>Share You.</h1>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="homepage.php?id=<?php echo $userID; ?>">
            <h3>Home</h3>
          </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">
            <h3>My Profile</h3><span class="sr-only">(current)</span>
          </a>
        </li>

        <li class="navbar-item pull-right">
          <a class="nav-link" href="../php/logout.php" style="float: right;">
            <h3>Logout</h3>
          </a>
        </li>
      </ul>
    </div>
  </nav>
    <div class="row">
        <div class="col-2"> 
            <div class="row">
                <div class="offset-1 offset-lg-3 col-12 mt-4">
                    <img src="../images/<?php echo $userProPic;?>" alt="profile picture" class="profilePicture">
                </div>
                <div class="col-11 offset-1 offset-lg-2 mt-4">
                    <h2><?php echo $userFirstName . " " . $userSurname ?></h2>
                    <h2>Followers: <?php
                        $followerSql = "";
                        if($otherUserId == "-1")
                        {
                            $followerSql = "SELECT * FROM tbfollowers WHERE follows_userId = $userID";
                        }
                        else
                        {
                            $followerSql = "SELECT * FROM tbfollowers WHERE follows_userId = $otherUserId";
                        }
                        $res = mysqli_query($mysqli, $sql);
                        echo mysqli_num_rows($res)-1;
                    ?></h2> 
                <?php
                    if($otherUserId != "-1")
                    {
                        $followSQL = "SELECT * FROM tbfollowers WHERE follows_userId = $otherUserId AND follower_userId = $userID";
                        $followres = mysqli_query($mysqli, $followSQL);
                        $outputFollowers = "";
                        if(mysqli_num_rows($followres) > 0)
                        {
                            $outputFollowers = "<h3>You Follow this user</h3>";
                        }
                        else
                        {
                            $outputFollowers = "<button class='btn mt-1' style='width: 100%;background-color: rgba(4, 187, 187, 0.733);' name='follow' type='button' onclick='followUser($userID,$otherUserId)'>Follow</button>";
                        }
                        echo $outputFollowers;
                    }
                ?>
                <?php
                    if($otherUserId != "-1")
                    {
                        $areFriends = false;
                        $sql = "SELECT * FROM friends";
                        $areFriendsRes = mysqli_query($mysqli, $sql);
                        while ($row9 = mysqli_fetch_assoc($areFriendsRes)) 
                        {
                            if($row9["user_id_1"] == $userID && $row9["user_id_2"] == $otherUserId)
                            {
                                $areFriends = true;
                            }
                            else if($row9["user_id_1"] == $otherUserId && $row9["user_id_2"] == $userID)
                            {
                                $areFriends = true;
                            }
                        }

                        if($areFriends == true)
                        {
                            echo "<h4>You are Friends!</h4>";
                        }
                    } 
                ?>
                </div>
                <div class="col-11 offset-1 friendsList">
                    <h3>Friends List</h3>
                    <?php
                        if($otherUserId != "-1")
                        {
                            $outputFriends = "";
                            // own profile page
                            $sql = "SELECT * FROM friends";
                            $res = mysqli_query($mysqli, $sql);
                            while ($row = mysqli_fetch_assoc($res)) 
                            {
                                if($row["user_id_1"] == $userID)
                                {
                                    $friendUserId = $row["user_id_2"];
                                    $friendDetails = "SELECT * FROM tbusers WHERE user_id = $friendUserId";
                                    $friendRes = mysqli_query($mysqli, $friendDetails);
                                    while ($row3 = mysqli_fetch_assoc($friendRes)) 
                                    {
                                        $friendName = $row3["user_name"];
                                        $friendSurname = $row3["user_surname"];
                                    }
                                    $outputFriends = $outputFriends . "<div class='searchUser'><h2>$friendName $friendSurname</h2><div onclick='messageFriend($userID,$friendUserId)'><i class='fa fa-envelope' aria-hidden='true'></i></div></div>";
                                }
                                else if($row["user_id_2"] == $userID)
                                {
                                    $friendUserId = $row["user_id_1"];
                                    $friendDetails = "SELECT * FROM tbusers WHERE user_id = $friendUserId";
                                    $friendRes = mysqli_query($mysqli, $friendDetails);
                                    while ($row3 = mysqli_fetch_assoc($friendRes)) 
                                    {
                                        $friendName = $row3["user_name"];
                                        $friendSurname = $row3["user_surname"];
                                    }
                                    $outputFriends = $outputFriends . "<div class='searchUser'><h2>$friendName $friendSurname</h2><div onclick='messageFriend($userID,$friendUserId)'><i class='fa fa-envelope' aria-hidden='true'></i></div></div>";
                                }
                            }
                            echo $outputFriends;
                        }
                        else
                        {
                            // someone else's page
                            $outputFriends = "";
                            // own profile page
                            $sql = "SELECT * FROM friends";
                            $res = mysqli_query($mysqli, $sql);
                            while ($row = mysqli_fetch_assoc($res)) 
                            {
                                if($row["user_id_1"] == $otherUserId)
                                {
                                    $friendUserId = $row["user_id_2"];
                                    $friendDetails = "SELECT * FROM tbusers WHERE user_id = $friendUserId";
                                    $friendRes = mysqli_query($mysqli, $friendDetails);
                                    while ($row3 = mysqli_fetch_assoc($friendRes)) 
                                    {
                                        $friendName = $row3["user_name"];
                                        $friendSurname = $row3["user_surname"];
                                    }
                                    $outputFriends = $outputFriends . "<div class='searchUser'><h2>$friendName $friendSurname</h2></div>";
                                }
                                else if($row["user_id_2"] == $otherUserId)
                                {
                                    $friendUserId = $row["user_id_1"];
                                    $friendDetails = "SELECT * FROM tbusers WHERE user_id = $friendUserId";
                                    $friendRes = mysqli_query($mysqli, $friendDetails);
                                    while ($row3 = mysqli_fetch_assoc($friendRes)) 
                                    {
                                        $friendName = $row3["user_name"];
                                        $friendSurname = $row3["user_surname"];
                                    }
                                    $outputFriends = $outputFriends . "<div class='searchUser'><h2>$friendName $friendSurname</h2></div>";
                                }
                            }
                            echo $outputFriends;
                        }
                    ?>
                    <hr>
                    <?php
                        if($otherUserId == "-1")
                        {
                            $outputRequests = "<h3>Friend Requests</h3>";
                            $sql2 = "SELECT * FROM friend_requests WHERE request_to = $userID";
                            $res2 = mysqli_query($mysqli, $sql2);
                            while ($row2 = mysqli_fetch_assoc($res2)) 
                            {
                                $potentialFriend = $row["request_from"];
                                $friendDetails = "SELECT * FROM tbusers WHERE user_id = $potentialFriend";
                                $friendRes = mysqli_query($mysqli, $friendDetails);
                                $friendName = "";
                                $friendSurname = "";
                                while ($row3 = mysqli_fetch_assoc($friendRes)) 
                                {
                                    $friendName = $row3["user_name"];
                                    $friendSurname = $row3["user_surname"];
                                }
                                $outputRequests = $outputRequests . "<div class='searchUser'><h2>$friendName $friendSurname</h2><div onclick='acceptFriendRequest($userID,$potentialFriend)'><i class='fa fa-check' aria-hidden='true'></i></i></div></div>";
                            }
                            $outputRequests = $outputRequests . "<hr>";
                            echo $outputRequests;
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-7 useractivityfeed">

        </div>
        <div class="col-2">
            <?php
                if($otherUserId == "-1")
                {
                    echo "<form action='profilepage.php' method='post' enctype='multipart/form-data'>
                            <div class='uploadpp'>
                                <span class='uploadpp_prompt'>Drop picture here or click to upload a profile picture</span>
                                <input type='file' name='userProfilepic[]' id='userProfilepic' class='uploadpp-input'>
                                <input type='hidden' id='hiddenUserId' name='userID' value='$userID'> 
                            </div>
                            <button class='btn mt-1' style='width: 100%;background-color: rgba(4, 187, 187, 0.733);' name='submitpropic' type='submit'>Submit</button>
                            <p id='filenamep' class='filenamep_text'></p>
                        </form>";
                }
            ?>
        </div>
    </div>
    
    <button onclick="topFunction()" id="backtotopButton" title="Go to top">Top</button>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="../script/profilepageScript.js"></script>
</body>

</html>