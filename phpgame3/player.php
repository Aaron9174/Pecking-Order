<?php
include "functions.php";
include "dbInfo.php";

if(isset($_POST['playerAttributes']))
{
	$username = $_POST['username'];
	$SQL = "SELECT gold,level,gems
			FROM game.user
			WHERE username = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $gold, $level, $gems);
		while(mysqli_stmt_fetch($stmt))
		{
			echo $level . ":" . $gold . ":" . $gems;
		}
		mysqli_stmt_close($stmt);
	}
}

if(isset($_POST['friendCount']))
{
	echo friendCount($connection,$_POST['username']);
}

if(isset($_POST['friendArray']))
{
	$friendArray = friendArray($connection,$_POST['username']);
	$count = count($friendArray);
	$i=0;
	while($i< $count)
	{
		echo $friendArray[$i] . ":";
		$i++;
	}
}

if(isset($_POST['addFriend']))
{
	if(friendExists($connection,$_POST['friend']))
	{
		$userid = getID($connection,$_POST['username']);
		$friendid = getID($connection,$_POST['friend']);
		if($userid==$friendid)
		{
			echo "same";
			exit();
		}
		
		$SQL = "SELECT COUNT(*)
				FROM game.friends
				WHERE userid = ? AND friendid = ?";
		if ($stmt = mysqli_prepare($connection,$SQL)) {
			mysqli_stmt_bind_param($stmt, "ii",$userid,$friendid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$count);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			if($count==1)
			{
				echo "repeat";
				exit();
			}
		}
		
		$SQL = "INSERT INTO game.friends
				VALUES(?,?)";
		if ($stmt = mysqli_prepare($connection,$SQL)) {
			mysqli_stmt_bind_param($stmt, "ii", $userid,$friendid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			echo "added";
			exit();
		}
	}
	else
	{
		echo "invalid";
	}
}
