<?php
include '../php/mysqllogin.php';
$mysqli = mysqli_connect($server, $username, $password, $database);
$userID;
$isadminaccount = true;
if (isset($_GET["userID"])) {
  $userID = $_GET["userID"];
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
  <link rel="stylesheet" href="../css/reports.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Permanent%20Marker">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source%20Sans%20Pro">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Caveat">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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
        <li class="nav-item active">
          <a class="nav-link" href="profilepage.php?userId=<?php echo $userID; ?>">
            <h3>My Profile</h3>
          </a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="albumpage.php?userId=<?php echo $userID; ?>">
            <h3>Albums</h3>
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
    <div class="col-lg-3 col-sm-12 mt-1 offset-lg-1 offset-sm-0">
      <h1>Reported Comments</h1>
      <?php
      $commentSql = "SELECT * FROM tbcomments WHERE reports > 0";
      $commentRes = mysqli_query($mysqli, $commentSql);
      while ($row = mysqli_fetch_assoc($commentRes)) {
        $outString = "";
        $commentID = $row["comment_id"];
        $commentUserSql = "SELECT * FROM tbusers WHERE user_id=" . $row["user_id"];
        $commentUserRes = mysqli_query($mysqli, $commentUserSql);
        while ($row2 = mysqli_fetch_assoc($commentUserRes)) {
          $outString = "<div id='comment$commentID' class='comment-block'>" . $row["comment_text"] . "<div class='comment-block-user mr-1 mt-2 mb-1' style='float:right;'>-" . $row2["user_name"] . "<span onclick='unreport($commentID, $userID)'> <i class='ml-2 fa fa-check' aria-hidden='true'></i></span>";
          if ($isadminaccount) {
            $outString = $outString . "<span onclick='deleteComment($commentID)'> <i class='ml-2 fa fa-trash' aria-hidden='true'></i></span>";
          }
          $outString = $outString . "</div></div>";
        }
        echo $outString;
      }
      ?>
    </div>
    <div class="col-lg-5 col-sm-12 offset-sm-0">
      <div class="row">
        <div class="col-12">
          <h1>Reported Posts:</h1>
        </div>
        <div class="col-12">
          <?php
          $postOut = "";
          $sql = "SELECT * FROM tbposts WHERE reports_id <> ''";
          $res = mysqli_query($mysqli, $sql);
          $postcount = 0;
          while ($row = mysqli_fetch_assoc($res)) {
            $imagenames = explode(':', $row["post_images"]);
            $imageLength = count($imagenames);
            $postID = $row["post_id"];
            $imageout = "";
            $reportDesc = "";
            if (strpos($row["reports_id"], ":") !== false) {
              $thereports = explode(':', $row["reports_id"]);
              for ($k = 0; $k < count($thereports); $k++) {
                $getReportDesc = "SELECT report_desc FROM reports WHERE reports_id = $thereports[$k]";
                $getReportRes = mysqli_query($mysqli, $getReportDesc);
                while ($rowReport = mysqli_fetch_assoc($getReportRes)) {
                  if ($k + 1 < count($thereports)) {
                    $reportDesc = $reportDesc . $rowReport["report_desc"] . ", ";
                  } else {
                    $reportDesc = $reportDesc . $rowReport["report_desc"];
                  }
                }
              }
            } else {
              $getReportDesc = "SELECT report_desc FROM reports WHERE reports_id =" . $row["reports_id"];
              $getReportRes = mysqli_query($mysqli, $getReportDesc);
              while ($rowReport = mysqli_fetch_assoc($getReportRes)) {
                $reportDesc = $rowReport["report_desc"];
              }
            }

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
                                  <div class='col-12'>
                                    <button type='button' class='btn btn-danger mt-2 managementButton' onclick='deletePost($postID, $userID)'>Delete Post</button>
                                    <button type='button' class='btn btn-success mt-2 managementButton' onclick='unreportPost($postID, $userID)'>Un-Report</button>
                                    <p class = 'ml-1 mt-1'>Reported For: $reportDesc</p>
                                  </div>
                                </div>
                              </div>
                            </div>";
          }

          echo $postOut;
          ?>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-sm-12">
      <form class="w3-container">
        <h3>
          <label>New Report Reason</label>
          <input id="addreportreason" class="w3-input" type="text">
        </h3>
        <button type="button" class='btn btn-success addReport mt-2' onclick='addnewReportReason(<?php echo $userID; ?>)' Style='background-color:  rgba(4, 187, 187, 0.733); width:100%;'>Add</button>
      </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="../script/reportScript.js"></script>
</body>

</html>