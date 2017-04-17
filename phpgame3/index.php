<?php
include "functions.php";
include "dbInfo.php";


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
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $count);
		mysqli_stmt_fetch($stmt);
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
			mysqli_stmt_bind_param($stmt, "ss", $username,$password);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $result);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
		}
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
		mysqli_stmt_bind_param($stmt, "ss", $username,$password);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $count);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	if($count==1){
		//setting isonline to 1 since they are now online
		$SQL = "UPDATE game.user
			SET isOnline = 1
			WHERE username=?";
		if ($stmt = mysqli_prepare($connection,$SQL)) {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $count);
			mysqli_stmt_fetch($stmt);
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
		mysqli_stmt_bind_param($stmt, "s", $username);
		$result = mysqli_stmt_execute($stmt);
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