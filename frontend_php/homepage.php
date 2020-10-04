<?php
include '../php/mysqllogin.php';
$mysqli = mysqli_connect($server, $username, $password, $database);
$userFirstName;
$userSurname;
$userID;
$userProPic;
if (isset($_GET["id"])) {
  $userID = $_GET["id"];
  $sql = "SELECT * FROM tbusers WHERE user_id=" . $_GET["id"];
  $res = mysqli_query($mysqli, $sql);
  while ($row = mysqli_fetch_assoc($res)) {
    $userFirstName = $row["user_name"];
    $userSurname = $row["user_surname"];
    $userProPic = $row["profile_picture"];
  }
} else if (isset($_POST["postSubmit"])) {
  $postImages = "";
  $userID = $_POST['userID'];
  $sql = "SELECT * FROM tbusers WHERE user_id=" . $userID;
  $res = mysqli_query($mysqli, $sql);
  while ($row = mysqli_fetch_assoc($res)) {
    $userFirstName = $row["user_name"];
    $userSurname = $row["user_surname"];
    $userProPic = $row["profile_picture"];
  }
  $imagePath = "../images/";

  // User folder



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
  $response = $mysqli->query($insertPost);
  if ($response) {
  }
} else {
  die("No user logged in");
}
?>

<!DOCTYPE html>
<html>

<head lang="en">
  <title>Share You.</title>
  <meta name="author" content="Andrew Wilson">
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/homepageStyles.css">
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
    <a class="navbar-brand" href="#">
      <h1>Share You.</h1>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">
            <h3>Home</h3><span class="sr-only">(current)</span>
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
    <div class="col-lg-3 profile">
      <div class="row">
        <div class="offset-1 offset-lg-3 col-12 mt-4">
          <img src="../images/<?php echo $userProPic; ?>" alt="profile picture" class="profilePicture">
        </div>
        <div class="col-11 offset-1 offset-lg-2 mt-4">
          <h2><?php echo $userFirstName . " " . $userSurname ?></h2>
        </div>
        <div class="col-11 offset-1 mt-4">
          <div class="input-group mb-3">
            <input type="text" name="searchFriend_text" class="form-control" placeholder="Search Users" aria-label="Search Users" aria-describedby="basic-addon2" id="searchUsersInput">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" onclick="searchUser(<?php echo $userID; ?>)">Search</button>
            </div>
          </div>
        </div>
        <div class="col-11 offset-1 mt-4">
          <div class="searchResult">

          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 activityFeed">
      <h1>Activity Feed</h1>

      <div class="row">
        <?php
        $postOut = "";
        $sql = "SELECT * FROM tbposts WHERE user_id=$userID";
        $res = mysqli_query($mysqli, $sql);
        $postcount = 0;
        while ($row = mysqli_fetch_assoc($res)) {
          $imagenames = explode(':', $row["post_images"]);
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
          $postOut = $postOut . "<div class='col-sm-12 col-md-6 mb-5' id='post" . $row["post_id"] . "'>
                        <div class='card userImageFeed'>
                          <div id='carouselExampleControls' class='carousel slide mb-1' data-ride='carousel'>
                              <div class='carousel-inner'>" .
            $imageout
            . "</div>
                          </div>
                          <div class='row'>
                            <div class='col-6'>
                              <a class='postnamelink' href='postpage.php?postID=" . $row["post_id"] . "&userID=$userID' ><h3 class='ml-1'>" . $row["post_name"] . "</h3></a> 
                            </div>
                            <div class='col-6 mb-1'>
                              <h5>" . $row["post_hashtags"] . "</h5>
                            </div>
                          </div>
                          <div class='row'>
                            <div class='col-12'>
                              <p class='ml-1'>" . $row["post_description"] . "</p>
                            </div>
                          </div>
                        </div>
                      </div>";
        }

        $freindsql = "SELECT * FROM friends WHERE user_id_1 = $userID";
        $freindsql2 = "SELECT * FROM friends WHERE user_id_2 = $userID";
        $res2 = mysqli_query($mysqli, $freindsql);
        while ($row2 = mysqli_fetch_assoc($res2)) {
          $sql2 = "SELECT * FROM tbposts WHERE user_id=" . $row2["user_id_2"];
          $res3 = mysqli_query($mysqli, $sql2);
          while ($row3 = mysqli_fetch_assoc($res3)) {
            $imagenames = explode(':', $row3["post_images"]);
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
            $postOut = $postOut . "<div class='col-sm-12 col-md-6 mb-5' id='post" . $row3["post_id"] . "'>
                            <div class='card userImageFeed'>
                              <div id='carouselExampleControls' class='carousel slide mb-1' data-ride='carousel'>
                                  <div class='carousel-inner'>" .
              $imageout
              . "</div>
                              </div>
                              <div class='row'>
                                <div class='col-6'>
                                  <a class='postnamelink' href='postpage.php?postID=" . $row3["post_id"] . "&userID=$userID' ><h3 class='ml-1'>" . $row3["post_name"] . "</h3></a> 
                                </div>
                                <div class='col-6 mb-1'>
                                  <h5>" . $row3["post_hashtags"] . "</h5>
                                </div>
                              </div>
                              <div class='row'>
                                <div class='col-12'>
                                  <p class='ml-1'>" . $row3["post_description"] . "</p>
                                </div>
                              </div>
                            </div>
                          </div>";
          }
        }
        $res4 = mysqli_query($mysqli, $freindsql2);
        while ($row4 = mysqli_fetch_assoc($res4)) {
          $sql5 = "SELECT * FROM tbposts WHERE user_id=" . $row4["user_id_1"];
          $res4 = mysqli_query($mysqli, $sql5);
          while ($row4 = mysqli_fetch_assoc($res4)) {
            $imagenames = explode(':', $row4["post_images"]);
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
            $postOut = $postOut . "<div class='col-sm-12 col-md-6 mb-5' id='post" . $row4["post_id"] . "'>
                            <div class='card userImageFeed'>
                              <div id='carouselExampleControls' class='carousel slide mb-1' data-ride='carousel'>
                                  <div class='carousel-inner'>" .
              $imageout
              . "</div>
                              </div>
                              <div class='row'>
                                <div class='col-6'>
                                  <a class='postnamelink' href='postpage.php?postID=" . $row4["post_id"] . "&userID=$userID' ><h3 class='ml-1'>" . $row4["post_name"] . "</h3></a> 
                                </div>
                                <div class='col-6 mb-1'>
                                  <h5>" . $row4["post_hashtags"] . "</h5>
                                </div>
                              </div>
                              <div class='row'>
                                <div class='col-12'>
                                  <p class='ml-1'>" . $row4["post_description"] . "</p>
                                </div>
                              </div>
                            </div>
                          </div>";
          }
        }
        echo $postOut;

        ?>
      </div>
      <div class="row">
        <hr>
        <h3>People You Follow's Posts:</h3>
        <?php
        $followSql = "SELECT * FROM tbfollowers WHERE follower_userId= $userID";
        $resFollow = mysqli_query($mysqli, $followSql);
        while ($row66 = mysqli_fetch_assoc($resFollow)) {
          $otherUserID = $row66["follows_userId"];
          $sql6 = "SELECT * FROM tbposts WHERE user_id=$otherUserID";
          $res7 = mysqli_query($mysqli, $sql6);
          while ($row6 = mysqli_fetch_assoc($res7)) {
            $imagenames = explode(':', $row6["post_images"]);
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
            $postOut = $postOut . "<div class='col-sm-12 col-md-6 mb-5' id='post" . $row6["post_id"] . "'>
                              <div class='card userImageFeed'>
                                <div id='carouselExampleControls' class='carousel slide mb-1' data-ride='carousel'>
                                    <div class='carousel-inner'>" .
              $imageout
              . "</div>
                                </div>
                                <div class='row'>
                                  <div class='col-6'>
                                    <a class='postnamelink' href='postpage.php?postID=" . $row6["post_id"] . "&userID=$userID' ><h3 class='ml-1'>" . $row6["post_name"] . "</h3></a> 
                                  </div>
                                  <div class='col-6 mb-1'>
                                    <h5>" . $row6["post_hashtags"] . "</h5>
                                  </div>
                                </div>
                                <div class='row'>
                                  <div class='col-12'>
                                    <p class='ml-1'>" . $row6["post_description"] . "</p>
                                  </div>
                                </div>
                              </div>
                            </div>";
          }
        }
        ?>
      </div>

    </div>

    <div class="col-lg-3 upload mt-5">

      <div class="card">
        <div class="card-body">
          <form action="homepage.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <div class="inputgroup input-group-md">
                <label for="descripbtions">Upload Post</label>
                <input type="text" class="form-control mb-2" placeholder="Name" name="postname">
                <input type="text" class="form-control mb-2" placeholder="Describtions" name="descripbtions">
                <input type="text" class="form-control mb-2" placeholder="Hashtags" name="hashtag">
                <?php echo "<input type='hidden' id='hiddenUserId' name='userID' value='$userID'>" ?>
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

      <a href="albumpage.php?userId=<?php echo $userID; ?>">
        <h3>Albums</h3>
      </a>
    </div>
  </div>

  <button onclick="topFunction()" id="backtotopButton" title="Go to top">Top</button>
  <div id="snackbar">Friend request sent.</div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="../script/hompageScript.js"></script>
</body>

</html>