<?php
$connection=mysqli_connect("game.ctcmtgrdebio.us-west-2.rds.amazonaws.com",$username,$password);

if(isset($_POST['playerAttributes']))
{
	$username = $_POST['username'];
	$SQL = "SELECT gold,level,gems
			FROM game.user
			WHERE username = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		/* bind parameters for markers */
		mysqli_stmt_bind_param($stmt, "s", $username);
		/* execute query */
		mysqli_stmt_execute($stmt);
		/* bind result variables */
		mysqli_stmt_bind_result($stmt, $gold, $level, $gems);
		/* fetch value */
		while(mysqli_stmt_fetch($stmt))
		{
			echo $level . ":" . $gold . ":" . $gems;
		}
		/* close statement */
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
	for($i=0;i<count($friendArray);$i++)
	{
		echo $friendArray[$i] . ":";
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
			/* bind parameters for markers */
			mysqli_stmt_bind_param($stmt, "ii",$userid,$friendid);
			/* execute query */
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$count);
			mysqli_stmt_fetch($stmt);
			/* close statement */
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
			/* bind parameters for markers */
			mysqli_stmt_bind_param($stmt, "ii", $userid,$friendid);
			/* execute query */
			mysqli_stmt_execute($stmt);
			/* close statement */
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


function getID($connection,$username)
{
	$SQL = "SELECT id
			FROM game.user
			WHERE username = ?";
			
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		/* bind parameters for markers */
		mysqli_stmt_bind_param($stmt, "s", $username);
		/* execute query */
		mysqli_stmt_execute($stmt);
		/* bind result variables */
		mysqli_stmt_bind_result($stmt, $id);
		/* fetch value */
		mysqli_stmt_fetch($stmt);
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	return $id;
}

function friendExists($connection,$friend)
{
	$SQL = "SELECT COUNT(*)
			FROM game.user
			WHERE username = ?";
	$count;
	
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		/* bind parameters for markers */
		mysqli_stmt_bind_param($stmt, "s", $friend);
		/* execute query */
		mysqli_stmt_execute($stmt);
		/* bind result variables */
		mysqli_stmt_bind_result($stmt, $count);
		/* fetch value */
		mysqli_stmt_fetch($stmt);
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	if($count == 1)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function friendCount($connection,$username)
{
	$SQL = "SELECT COUNT(*)
			from game.user
			WHERE isonline=1
			AND id IN (SELECT friendid
							from game.friends
							WHERE userid = ? )";
	$userid = getID($connection,$username);
	
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		/* bind parameters for markers */
		mysqli_stmt_bind_param($stmt, "i", $userid);
		/* execute query */
		mysqli_stmt_execute($stmt);
		/* bind result variables */
		mysqli_stmt_bind_result($stmt, $count);
		/* fetch value */
		mysqli_stmt_fetch($stmt);
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	return $count;
}

function friendArray($connection,$username)
{
	$SQL = "SELECT username
			from game.user
			WHERE isonline=1
			AND id IN (SELECT friendid
							from game.friends
							WHERE userid = ?)";
	$userid = getID($connection,$username);
	$friendArray = array();
	
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		/* bind parameters for markers */
		mysqli_stmt_bind_param($stmt, "i", $userid);
		/* execute query */
		mysqli_stmt_execute($stmt);
		/* bind result variables */
		mysqli_stmt_bind_result($stmt, $username);
		/* fetch value */
		while(mysqli_stmt_fetch($stmt))
		{
			$friendArray[] = $username;
		}
		/* close statement */
		mysqli_stmt_close($stmt);
	}
	return $friendArray;
}
