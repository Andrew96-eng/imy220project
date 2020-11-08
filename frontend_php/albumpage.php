<?php
include '../php/mysqllogin.php';
$mysqli = mysqli_connect($server, $username, $password, $database);
$userID;
$postIdsToInsert = array();
if (isset($_GET["userId"])) {
    $userID = $_GET["userId"];
} else if (isset($_POST["postSubmit"])) {
    $postsSize = $_POST["posts"];
    for ($j = 0; $j < $postsSize; $j++) {
        $tempText = "hiddenInput$j";
        array_push($postIdsToInsert, $_POST[$tempText]);
    }
    $postImages = "";
    $userID = $_POST['userID'];
    $imagePath = "../images/";

    $totalfiles = count($_FILES['postimages']['name']);

    for ($i = 0; $i < $totalfiles; $i++) {
        $imagePath = "../images/";

        $picToUpload = basename($_FILES["postimages"]["name"][$i]);
        $tmpFilePath = $_FILES['postimages']['tmp_name'][$i];

        if ($tmpFilePath != "") {
            $imagePath = $imagePath . $picToUpload;

            move_uploaded_file($_FILES["postimages"]["tmp_name"][$i], $imagePath);

            $insertSql = "INSERT INTO tbgallery (user_id, filename) VALUES ($userID, '$picToUpload')";

            $response = $mysqli->query($insertSql);
            if ($response) {
                //success
                if ($postImages == "") {
                    $postImages = $postImages . $picToUpload;
                } else {
                    $postImages = $postImages . ":" . $picToUpload;
                }
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">
                                  Failed to insert into gallery table.
                              </div>';
            }
        }
    }
    $insertPost = "INSERT INTO tbposts (post_name, post_description, post_hashtags, post_images, user_id) VALUES ('" . $_POST["postname"] . "','" . $_POST["descripbtions"] . "','" . $_POST["hashtag"] . "','" . $postImages . "'," . $userID . ")";
    $response2 = $mysqli->query($insertPost);
    if ($response2) {
        $getPostId = "SELECT post_id FROM tbposts WHERE post_name = '" . $_POST["postname"] . "' AND post_description = '" .  $_POST["descripbtions"] . "'";
        $res = mysqli_query($mysqli, $getPostId);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($postIdsToInsert, $row["post_id"]);
        }
    }
} else if (isset($_GET["uId"]) && isset($_GET["posts"]) && isset($_GET["friends"])) {
    $userID = $_GET["uId"];
    $numberoffriends = $_GET["friends"];
    $numberofposts = $_GET["posts"];
    $friendIds = "";
    $albumDesc = $_POST["albumDesc"];
    $albumHas = $_POST["albumHashags"];
    $albumname = $_POST["albumName"];
    if ($numberoffriends != 0) {
        for ($k = 0; $k < $numberoffriends; $k++) {
            if (($k + 1) == $numberoffriends) {
                $friendIds = $friendIds . $_POST["friend$k"];
            } else {
                $friendIds = $friendIds . $_POST["friend$k"] . ";";
            }
        }
    }
    $postIds = "";
    for ($l = 0; $l < $numberofposts; $l++) {
        if (($l + 1) == $numberofposts) {
            $postIds = $postIds . $_POST["hiddenInput$l"];
        } else {
            $postIds = $postIds . $_POST["hiddenInput$l"] . ";";
        }
    }
    $albumInsert = "INSERT INTO tbalbums (owner_id,album_name,friends_id,posts_id,description,hastags) VALUES($userID,'$albumname','$friendIds','$postIds','$albumDesc','$albumHas')";
    $albumRes = $mysqli->query($albumInsert);
    if ($albumRes) {
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
    <link rel="stylesheet" href="../css/albumpageStyle.css">
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
                    <a class="nav-link" href="profilepage.php?userId=<?php echo $userID; ?>">
                        <h3>My Profile</h3>
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
        <div class="offset-md-1 offset-sm-0 col-lg-3 upload mt-5">
            <?php
            $size = count($postIdsToInsert);
            $hiddenOuts = "";
            if (empty($postIdsToInsert) == false) {

                for ($i = 0; $i < $size; $i++) {
                    $hiddenOuts = $hiddenOuts . "<input type='hidden' name='hiddenInput$i' value=" . $postIdsToInsert[$i] . ">";
                }
            }
            $friendSql = "SELECT * FROM friends WHERE user_id_1 = $userID OR user_id_2 = $userID";
            $res3 = mysqli_query($mysqli, $friendSql);
            $friendList = "";
            $counter = 0;
            while ($row3 = mysqli_fetch_assoc($res3)) {
                $friendId;
                if ($row3["user_id_1"] == $userID) {
                    $friendId = $row3["user_id_2"];
                } else {
                    $friendId = $row3["user_id_1"];
                }
                $friendDetails = "SELECT * FROM tbusers WHERE user_id = $friendId";
                $res4 = mysqli_query($mysqli, $friendDetails);
                
                while ($row4 = mysqli_fetch_assoc($res4)) {
                    $friendName = $row4["user_name"];
                    $friendSurname = $row4["user_surname"];
                    $friendList = $friendList . "<input type='checkbox' class='colabFriend' id='friend$counter' name='friend$counter' value='$friendId'>
                                        <label class='colabFriend' for='friend$counter'>$friendName $friendSurname</label><br>";
                    $counter = $counter + 1;
                }
            }
            echo "<h3>Number of posts to insert:$size</h3>
                            <form method='post' action='albumpage.php?uId=$userID&posts=$size&friends=$counter'><h3>Friends You can Add:</h3>" . $friendList . $hiddenOuts . "<input class='form-control mb-2' type='text' name='albumName' placeholder='Album Name'><input class='form-control mb-2' type='text' name='albumDesc' placeholder='Album Describtion'><input class='form-control mb-2' type='text' name='albumHashags' placeholder='Album Hashtags'><button type='submit' class='btn' style='width: 100%;background-color: rgba(4, 187, 187, 0.733);' id='SaveAlbumnBtn' name='saveAlbum'>Save Album</button></form>";
            ?>

            <div class="card mt-2">
                <div class="card-body">
                    <form action="albumpage.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="inputgroup input-group-md">
                                <label for="descripbtions">Upload Post</label>
                                <input type="text" class="form-control mb-2" placeholder="Name" name="postname">
                                <input type="text" class="form-control mb-2" placeholder="Describtions" name="descripbtions">
                                <input type="text" class="form-control mb-2" placeholder="Hashtags" name="hashtag">
                                <?php echo "<input type='hidden' id='hiddenUserId' name='userID' value='$userID'>" ?>
                                <?php echo "<input type='hidden' id='hiddenPosts' name='posts' value='" . count($postIdsToInsert) . "'>" ?>
                                <?php
                                if (empty($postIdsToInsert) == false) {
                                    $size = count($postIdsToInsert);
                                    $hiddenOuts = "";
                                    for ($i = 0; $i < $size; $i++) {
                                        $hiddenOuts = $hiddenOuts . "<input type='hidden' name='hiddenInput$i' value=" . $postIdsToInsert[$i] . ">";
                                    }
                                    echo $hiddenOuts;
                                }
                                ?>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" name="postimages[]" id="customFile" multiple="multiple">
                                    <label class="custom-file-label" for="customFile">Upload images</label>
                                </div>

                            </div>
                            <button type="submit" class="btn" style="width: 100%;background-color: rgba(4, 187, 187, 0.733);" id="postSubmitButton" name="postSubmit">Upload</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-lg-7 col-sm-12 mt-5 ml-5">
            <div class="row">
                <?php
                $selectAlbums = "SELECT * FROM tbalbums";
                $albumRes = mysqli_query($mysqli, $selectAlbums);
                $ablumsOut = "";
                while ($row = mysqli_fetch_assoc($albumRes)) {
                    $albumotherIds = explode(';', $row["friends_id"]);
                    if ($userID == $row["owner_id"] || in_array($userID, $albumotherIds)) {
                        $ownerName = "";
                        $getOwnerSql = "SELECT * FROM tbusers WHERE user_id= " . $row["owner_id"];
                        $ownerRes = mysqli_query($mysqli, $getOwnerSql);
                        while ($ownerRow = mysqli_fetch_assoc($ownerRes)) {
                            $ownerName = $ownerRow["user_name"] . " " . $ownerRow["user_surname"];
                        }
                        $ablumsOut = "<div class='col-12 albumCard'><span class='albumposts'>";
                        $albumName = $row["album_name"];
                        $albumDescDB = $row["description"];
                        $albumHash = $row["hastags"];
                        $ablumsOut = $ablumsOut . "<span class='albuminfo'>
                                                <h2>$albumName - Owned by $ownerName</h2>
                                                <p>$albumName</p>
                                                <h3>$albumName</h3>
                                                </span><span class = 'albumposts'><div class='row'>";
                        $postsIDS = explode(';', $row["posts_id"]);
                        $postCount = count($postsIDS);
                        for ($a = 0; $a < $postCount; $a++) {
                            $postSQL = "SELECT * FROM tbposts WHERE post_id=" . $postsIDS[$a];
                            $postRes = mysqli_query($mysqli, $postSQL);
                            $postOut = "";
                            while ($postRow = mysqli_fetch_assoc($postRes)) {
                                $imagenames = explode(':', $postRow["post_images"]);
                                $imageLength = count($imagenames);
                                $imageout = "";
                                for ($j = 0; $j < $imageLength; $j++) {
                                    if ($j == 0) {
                                        $imageout = $imageout . "<div class='carousel-item active'>
                                                                    <img class='d-block w-100 postImage' src='../images/" . $imagenames[$j] . "' alt='" . $imagenames[$j] . "'>
                                                                    </div>";
                                    } else {
                                        $imageout = $imageout . "<div class='carousel-item'>
                                                                    <img class='d-block w-100 postImage' src='../images/" . $imagenames[$j] . "' alt='" . $imagenames[$j] . "'>
                                                            </div>";
                                    }
                                }
                                $postOut = $postOut . "<div class='col-sm-12 col-md-5 mb-5' id='post" . $postRow["post_id"] . "'>
                                                            <div class='card userImageFeed'>
                                                            <div id='carouselExampleControls' class='carousel slide mb-1' data-ride='carousel'>
                                                                <div class='carousel-inner'>" .
                                    $imageout
                                    . "</div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-6'>
                                                                <a class='postnamelink' href='postpage.php?postID=" . $postRow["post_id"] . "&userID=" . $postRow["user_id"] . "' ><h3 class='ml-1'>" . $postRow["post_name"] . "</h3></a> 
                                                                </div>
                                                                <div class='col-6 mb-1'>
                                                                <h5>" . $postRow["post_hashtags"] . "</h5>
                                                                </div>
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-12'>
                                                                <p class='ml-1'>" . $postRow["post_description"] . "</p>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>";
                            }
                            $ablumsOut = $ablumsOut . $postOut;
                        }
                        $ablumsOut = $ablumsOut . "</div></span></div>";
                        echo $ablumsOut;
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <button onclick="topFunction()" id="backtotopButton" title="Go to top">Top</button>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="../script/albumpageScript.js"></script>
</body>

</html>