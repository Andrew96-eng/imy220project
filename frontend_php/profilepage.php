<?php
    include '../php/mysqllogin.php';
    $mysqli = mysqli_connect($server, $username, $password, $database);
    $userID = "";
    if(isset($_GET["userId"]))
    {
        $userID= $_GET["userId"];
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
    
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="../script/profilepageScript.js"></script>
</body>

</html>