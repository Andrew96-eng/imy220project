<?php

    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "dbProject";
    $mysqli = mysqli_connect($server, $username, $password, $database);

    $email = isset($_POST["loginEmail"]) ? $_POST["loginEmail"] : false;
    $pass = isset($_POST["loginPassword"]) ? $_POST["loginPassword"] : false;	

    $sql = "SELECT * FROM tbusers WHERE user_email = '$email'";

    $result = $mysqli->query($sql);
    
	if($result && $result->num_rows > 0)
	{
        while($row = mysqli_fetch_assoc($result))
		{
            if($row["user_password"] == $pass)
            {
                //successfull login
                header("Location: ../frontend_php/homepage.php?id=".$row["user_id"], true, 301);
                exit();
            }
            else
            {
                // incorrect password
            }
        }
    }
    else
    {
        // Failed login
    }
    
?>