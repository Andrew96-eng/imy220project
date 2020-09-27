<?php
include '../php/mysqllogin.php';
$mysqli = mysqli_connect($server, $username, $password, $database);
$userID = "";
$postID = "";
$postName = "";
$postDesc = "";
$postHashtags = "";
$postimages;
$postUserID = "";

function loadPostInfo()
{
    
}

if (isset($_GET["postID"])) {
    if (isset($_GET["userID"])) {
        $userID = $_GET["userID"];
        $postID = $_GET["postID"];

        $sql = "SELECT * FROM tbposts WHERE post_id = $postID";
        $res = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $postName = $row["post_name"];
            $postDesc = $row["post_description"];
            $postHashtags = $row["post_hashtags"];
            $postimages = $row["post_images"];
            $postUserID = $row["user_id"];
        }
        loadPostInfo();
    } else {
        header("Location: ../index.html", true, 301);
        exit();
    }
} else if (isset($_POST["comment_text"])) {
    $postID = $_POST["post_id"];
    $userID = $_POST["user_id"];
    $commentText = $_POST["comment_text"];
    $sql = "INSERT INTO tbcomments (post_id, comment_text, user_id) VALUES ($postID, '$commentText', $userID)";
    $response = $mysqli->query($sql);
    if ($response) {
        $sql2 = "SELECT * FROM tbposts WHERE post_id = $postID";
        $res = mysqli_query($mysqli, $sql2);
        while ($row = mysqli_fetch_assoc($res)) {
            $postName = $row["post_name"];
            $postDesc = $row["post_description"];
            $postHashtags = $row["post_hashtags"];
            $postimages = $row["post_images"];
            $postUserID = $row["user_id"];
        }
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">
								Failed to insert into gallery table.' . $sql . '
							</div>';
    }
}
else if($postID != "")
{
    $sql = "SELECT * FROM tbposts WHERE post_id = $postID";
        $res = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $postName = $row["post_name"];
            $postDesc = $row["post_description"];
            $postHashtags = $row["post_hashtags"];
            $postimages = $row["post_images"];
            $postUserID = $row["user_id"];
        }
} 
else {
    header("Location: ../index.html", true, 301);
    exit();
}
?>

<!DOCTYPE html>
<html>

<head lang="en">
    <title>Share You.</title>
    <meta name="author" content="Andrew Wilson">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/homepageStyles.css">
    <link rel="stylesheet" href="../css/postpageStyles.css">
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
                        <h3>Home</h3><span class="sr-only">(current)</span>
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
        <div class="offset-lg-4 col-12 activityFeed">
            <h1>Post: <?php echo $postName ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="ml-3 col-lg-3 col-sm-6">
            <h2 id="commentHeading2">Comments. Likes: 
            <?php
                $likesql = "SELECT * FROM tblikes WHERE post_id = $postID"; 
                $likesRes = mysqli_query($mysqli, $likesql);
                while($likeRow = mysqli_fetch_assoc($likesRes))
                {
                    echo $likeRow["number_likes"];
                }
            ?><button class="ml-5 btn btn-outline-secondary" type="button" onclick="likePost(<?php echo $postID ?>)">Like</button></h2>
            <hr>
            <form action="postpage.php" method="POST">
                <div class="comment-input">
                    <div class="input-group mb-3">
                        <input type="text" name="comment_text" class="form-control" placeholder="Comment" aria-label="Comment" aria-describedby="basic-addon2" id="commentInput">
                        <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
                        <input type="hidden" name="post_id" value="<?php echo $postID; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Add Comment</button>
                        </div>
                    </div>
                </div>
            </form>
            <?php
                $commentSql = "SELECT * FROM tbcomments WHERE post_id=$postID";
                $commentRes = mysqli_query($mysqli, $commentSql);
                while ($row = mysqli_fetch_assoc($commentRes))
                {
                    $outString = "";
                    $commentUserSql = "SELECT * FROM tbusers WHERE user_id=" . $row["user_id"];
                    $commentUserRes = mysqli_query($mysqli, $commentUserSql);
                    while($row2 = mysqli_fetch_assoc($commentUserRes))
                    {
                        $outString = "<div class='comment-block'>" . $row["comment_text"] . "<div class='comment-block-user mr-1 mt-2 mb-1' style='float:right;'>-" . $row2["user_name"] . "<i class='ml-2 fa fa-flag' aria-hidden='true'></i>";
                        if ($postUserID == $userID) {
                            $outString = $outString . "<i class='ml-2 fa fa-trash' aria-hidden='true'></i>";
                        }
                        $outString = $outString . "</div></div>";
                    }
                    echo $outString;
                }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="../script/postpageScript.js"></script> 
</body>

</html>