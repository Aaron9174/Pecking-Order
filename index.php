<?php
$connection=mysqli_connect("game.ctcmtgrdebio.us-west-2.rds.amazonaws.com","mpdean1","4419mpdM19!!");
$db = mysql_select_db('game', $connection);

//user is registering for a new account
if(isset($_POST['register']))
{
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$count;
	$result;
	
	$SQL = "SELECT COUNT(*)
			FROM game.user
			WHERE username = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		/* bind parameters for markers */
		mysqli_stmt_bind_param($stmt, "s", $username);
		/* execute query */
		mysqli_stmt_execute($stmt);
		/* bind result variables */
		mysqli_stmt_bind_result($stmt, $count);
		/* fetch value */
		mysqli_stmt_fetch($stmt);
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	if($count==1)
	{
		print "taken";
		exit();
	}
	if($count==0)
	{
		//start inserting into the user table
		$SQL = "INSERT INTO game.user (username,password)
				VALUES (?,?)";
		if ($stmt = mysqli_prepare($connection,$SQL)) {
			/* bind parameters for markers */
			mysqli_stmt_bind_param($stmt, "ss", $username,$password);
			/* execute query */
			mysqli_stmt_execute($stmt);
			/* bind result variables */
			mysqli_stmt_bind_result($stmt, $result);
			/* fetch value */
			mysqli_stmt_fetch($stmt);
			/* close statement */
			mysqli_stmt_close($stmt);
		}
		/*if($result2==false)
		{
			//some kind of error needs to be reported back to the user here
			print "error";
			exit();
		}*/
		print "success";
		exit();
	}
}

//user is logging into the game
if(isset($_POST['login']))
{
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$SQL = "SELECT COUNT(*)
			FROM game.user
			WHERE username=? AND password=?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		/* bind parameters for markers */
		mysqli_stmt_bind_param($stmt, "ss", $username,$password);
		/* execute query */
		mysqli_stmt_execute($stmt);
		/* bind result variables */
		mysqli_stmt_bind_result($stmt, $count);
		/* fetch value */
		mysqli_stmt_fetch($stmt);
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	if($count==1){
		//setting isonline to 1 since they are now online
		$SQL = "UPDATE game.user
			SET isOnline = 1
			WHERE username=?";
		if ($stmt = mysqli_prepare($connection,$SQL)) {
			/* bind parameters for markers */
			mysqli_stmt_bind_param($stmt, "s", $username);
			/* execute query */
			mysqli_stmt_execute($stmt);
			/* bind result variables */
			mysqli_stmt_bind_result($stmt, $count);
			/* fetch value */
			mysqli_stmt_fetch($stmt);
			/* close statement */
			mysqli_stmt_close($stmt);
		}
		print "true";
		
	} else{
		//report back to the user that there long in information was incorrect
		echo "false";
	}
}

if(isset($_POST['logout']))
{
	$username = $_POST['username'];
	$SQL = "UPDATE game.user
			SET isOnline = 0
			WHERE username=?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		/* bind parameters for markers */
		mysqli_stmt_bind_param($stmt, "s", $username);
		/* execute query */
		$result = mysqli_stmt_execute($stmt);
		/* bind result variables
		mysqli_stmt_bind_result($stmt, $result);
		/* fetch value 
		mysqli_stmt_fetch($stmt);
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	if($result==false)
	{
		echo "failure";
	}
	else{
		echo "logout";
	}
	
}