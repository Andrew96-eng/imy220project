<?php
	// See all errors and warnings
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "dbProject";
	$mysqli = mysqli_connect($server, $username, $password, $database);

	$name = $_POST["regName"];
	$surname = $_POST["regSurname"];
	$email = $_POST["regEmail"];
	$date = $_POST["regDOB"];
	$pass = $_POST["regPassword"];

	$query = "INSERT INTO tbusers (user_name, user_surname, user_email, user_dob, user_password) VALUES ('$name', '$surname', '$email', '$date', '$pass');";

    $res = mysqli_query($mysqli, $query) == TRUE;
    
    if($res)
    {
		$query2 = "SELECT user_id FROM tbusers WHERE user_email = '$email'";
		$res2 = mysqli_query($mysqli, $query2);
		$userID = "";
		while($row = mysqli_fetch_assoc($res2))
        {
			$userID = $row["user_id"];
		}
        // successfull
        header("Location: ../frontend_php/homepage.php?id=" . $userID, true, 301);
        exit();
    }
    else
    {
        //unsuccessfull
    }
?>