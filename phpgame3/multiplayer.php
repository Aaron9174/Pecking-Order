<?php
//this is the page that will deal with multiplayer games
include "functions.php";
include "dbInfo.php"

if(isset($_POST['invitePlayer']))
{
	//start a PHP session between the players with the cookie set to 60
	//the the session array will hold all of the data needed for the card game to players
	//it'll keep track of card placement and 
	$userid1 = getID($connection,$_POST['username1']);
	$userid2 = getID($connection,$_POST['username2']);
	$SQL = "INSERT INTO game.multiplayer_game (userid1,userid2)
			VALUES (?,?)";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "ii", $userid1,$userid2);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}
if(isset($_POST['gameExist'])
{
	$userid = $_POST['username'];
	$SQL = "SELECT COUNT(userid2)
			FROM game.multiplayer_game
			WHERE userid2 = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $count);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		if($count==1)
		{
			echo "canJoin";
		}
	}
}

if(isset($_POST['joinGame']))
{
	$userid2 = getID($connection,$_POST['username']);
	$SQL = "UPDATE game.multiplayer_game
			SET active=1
			WHERE userid2 = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i",$userid2);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

//users clients will check this page every 3-5 seconds in order to see if the session array has changed
//this will control the match
//this should work