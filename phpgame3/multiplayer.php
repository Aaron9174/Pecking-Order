<?php
//this is the page that will deal with multiplayer games
//this will be gehtto but it'll work friends do not fret the PHP magician is here
include "functions.php";
include "dbInfo.php";

if(isset($_POST['invitePlayer']))
{
	$userid1 = getID($connection,$_POST['username1']);
	$userid2 = getID($connection,$_POST['username2']);
	$SQL = "INSERT INTO game.multiplayer_game (userid1,userid2)
			VALUES (?,?)";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "ii", $userid1,$userid2);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		//echoing the players turn number put into a persistent variable
		echo "1";
	}
}
//every player that is online and in the main menu will be checking every 2 seconds whether they have been invited to a game
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
		//echoing the players turn number put into a persistent variable
		echo "2";
	}
}

if(isset($_POST['denyGame']))
{
	$userid2 = getID($connection,$_POST['username']);
	$SQL = "DELETE FROM game.multiplayer_game
			WHERE userid2 = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i",$userid2);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

//player checking if it their turn yet
if(isset($_POST['checkTurn']))
{
	if(checkTurn($connection,$_POST['playerTurn']))
	{
		echo "startTurn";
	}
}
//AAAAAAAHHHHHHHHHHHHHHHHHHHHHHHHHHH
if(isset($_POST['endTurn']))
{
	//getting both the players initial turns in order to get the right column names and what not
	$turn = $_POST['turn'];
	if(turn==1) {
		$otherTurn = 2;
	} else {
		$otherTurn = 1;
	}
	
	$gameID = $_POST['gameID'];
	if(isset($_POST['move1']))
	{
		$move = $_POST['move1'];
		if($move =='placeCard') {
			$spot = $_POST['spot1'];
			$cardid = getID($_POST['card1']);
			$cardattack = getCardAttack($connection,$cardid);
			placeCard($connection,$gameID,findColumnID($spot,$turn),$cardid, findColumnHP($spot,$turn),$cardattack);
		} else if($move == 'attack') {
			$attackSpot = $_POST['attackSpot1'];
			$defenceSpot = $_POST['defenceSpot1'];
			$attacker = getID($_POST['attacker1']);
			$defender = getID($_POST['defender1']);
			$attackerDamage = getCardAttack($connection,$attacker);
			$defenderDamage = getCardAttack($connection,$defender);
			//calculate damage
			$attackerhp = $attackerDamage - $defenderDamage;
			$defenderhp = $defenderDamage - $attackerDamage;
			//change the state of the board
			attack($connection,$gameID,findColumnID($attackSpot,$turn),findColumnHP($attackSpot,$turn),$attackerhp,findColumnID($defenceSpot,$otherTurn),findColumnHP($otherTurn),$defenderhp);
		} else if($move == 'sacrifice') {
			//don't know if I'll pas in name or cardid change if I do
			$newid = getID($_POST['summon1']);
			$spot = $_POST['spot1'];
			sacrifice($connection,$gameid,findColumnID($spot,$turn),$newid,findColumnHP($spot,$turn),getCardAttack($connection,$newid));
		}
	}
	if(isset($_POST['move2']))
	{
		$move = $_POST['move2'];
		if($move =='placeCard') {
			$spot = $_POST['spot2'];
			$cardid = getID($_POST['card2']);
			$cardattack = getCardAttack($connection,$cardid);
			placeCard($connection,$gameID,findColumnID($spot,$turn),$cardid, findColumnHP($spot,$turn),$cardattack);
		} else if($move == 'attack') {
			$attackSpot = $_POST['attackSpot2'];
			$defenceSpot = $_POST['defenceSpot2'];
			$attacker = getID($_POST['attacker2']);
			$defender = getID($_POST['defender2']);
			$attackerDamage = getCardAttack($connection,$attacker);
			$defenderDamage = getCardAttack($connection,$defender);
			//calculate damage
			$attackerhp = $attackerDamage - $defenderDamage;
			$defenderhp = $defenderDamage - $attackerDamage;
			//change the state of the board
			attack($connection,$gameID,findColumnID($attackSpot,$turn),findColumnHP($attackSpot,$turn),$attackerhp,findColumnID($defenceSpot,$otherTurn),findColumnHP($otherTurn),$defenderhp);
		} else if($move == 'sacrifice') {
			//don't know if I'll pas in name or cardid change if I do
			$newid = getID($_POST['summon2']);
			$spot = $_POST['spot2'];
			sacrifice($connection,$gameid,findColumnID($spot,$turn),$newid,findColumnHP($spot,$turn),getCardAttack($connection,$newid));
		}
	}
	if(isset($_POST['move3']))
	{
		$move = $_POST['move3'];
		if($move =='placeCard') {
			$spot = $_POST['spot3'];
			$cardid = getID($_POST['card3']);
			$cardattack = getCardAttack($connection,$cardid);
			placeCard($connection,$gameID,findColumnID($spot,$turn),$cardid, findColumnHP($spot,$turn),$cardattack);
		} else if($move == 'attack') {
			$attackSpot = $_POST['attackSpot3'];
			$defenceSpot = $_POST['defenceSpot3'];
			$attacker = getID($_POST['attacker3']);
			$defender = getID($_POST['defender3']);
			$attackerDamage = getCardAttack($connection,$attacker);
			$defenderDamage = getCardAttack($connection,$defender);
			//calculate damage
			$attackerhp = $attackerDamage - $defenderDamage;
			$defenderhp = $defenderDamage - $attackerDamage;
			//change the state of the board
			attack($connection,$gameID,findColumnID($attackSpot,$turn),findColumnHP($attackSpot,$turn),$attackerhp,findColumnID($defenceSpot,$otherTurn),findColumnHP($otherTurn),$defenderhp);
		} else if($move == 'sacrifice') {
			//don't know if I'll pas in name or cardid change if I do
			$newid = getID($_POST['summon3']);
			$spot = $_POST['spot3'];
			sacrifice($connection,$gameid,findColumnID($spot,$turn),$newid,findColumnHP($spot,$turn),getCardAttack($connection,$newid));
		}
	}
	if(isset($_POST['move4']))
	{
		$move = $_POST['move4'];
		if($move =='placeCard') {
			$spot = $_POST['spot4'];
			$cardid = getID($_POST['card4']);
			$cardattack = getCardAttack($connection,$cardid);
			placeCard($connection,$gameID,findColumnID($spot,$turn),$cardid, findColumnHP($spot,$turn),$cardattack);
		} else if($move == 'attack') {
			$attackSpot = $_POST['attackSpot4'];
			$defenceSpot = $_POST['defenceSpot4'];
			$attacker = getID($_POST['attacker4']);
			$defender = getID($_POST['defender4']);
			$attackerDamage = getCardAttack($connection,$attacker);
			$defenderDamage = getCardAttack($connection,$defender);
			//calculate damage
			$attackerhp = $attackerDamage - $defenderDamage;
			$defenderhp = $defenderDamage - $attackerDamage;
			//change the state of the board
			attack($connection,$gameID,findColumnID($attackSpot,$turn),findColumnHP($attackSpot,$turn),$attackerhp,findColumnID($defenceSpot,$otherTurn),findColumnHP($otherTurn),$defenderhp);
		} else if($move == 'sacrifice') {
			//don't know if I'll pas in name or cardid change if I do
			$newid = getID($_POST['summon4']);
			$spot = $_POST['spot4'];
			sacrifice($connection,$gameid,findColumnID($spot,$turn),$newid,findColumnHP($spot,$turn),getCardAttack($connection,$newid));
		}
	}
	if(isset($_POST['move4']))
	{
		$move = $_POST['move4'];
		if($move =='placeCard') {
			$spot = $_POST['spot4'];
			$cardid = getID($_POST['card4']);
			$cardattack = getCardAttack($connection,$cardid);
			placeCard($connection,$gameID,findColumnID($spot,$turn),$cardid, findColumnHP($spot,$turn),$cardattack);
		} else if($move == 'attack') {
			$attackSpot = $_POST['attackSpot4'];
			$defenceSpot = $_POST['defenceSpot4'];
			$attacker = getID($_POST['attacker4']);
			$defender = getID($_POST['defender4']);
			$attackerDamage = getCardAttack($connection,$attacker);
			$defenderDamage = getCardAttack($connection,$defender);
			//calculate damage
			$attackerhp = $attackerDamage - $defenderDamage;
			$defenderhp = $defenderDamage - $attackerDamage;
			//change the state of the board
			attack($connection,$gameID,findColumnID($attackSpot,$turn),findColumnHP($attackSpot,$turn),$attackerhp,findColumnID($defenceSpot,$otherTurn),findColumnHP($otherTurn),$defenderhp);
		} else if($move == 'sacrifice') {
			//don't know if I'll pas in name or cardid change if I do
			$newid = getID($_POST['summon4']);
			$spot = $_POST['spot4'];
			sacrifice($connection,$gameid,findColumnID($spot,$turn),$newid,findColumnHP($spot,$turn),getCardAttack($connection,$newid));
		}
	}
	if(isset($_POST['move5']))
	{
		$move = $_POST['move5'];
		if($move =='placeCard') {
			$spot = $_POST['spot5'];
			$cardid = getID($_POST['card5']);
			$cardattack = getCardAttack($connection,$cardid);
			placeCard($connection,$gameID,findColumnID($spot,$turn),$cardid, findColumnHP($spot,$turn),$cardattack);
		} else if($move == 'attack') {
			$attackSpot = $_POST['attackSpot5'];
			$defenceSpot = $_POST['defenceSpot5'];
			$attacker = getID($_POST['attacker5']);
			$defender = getID($_POST['defender5']);
			$attackerDamage = getCardAttack($connection,$attacker);
			$defenderDamage = getCardAttack($connection,$defender);
			//calculate damage
			$attackerhp = $attackerDamage - $defenderDamage;
			$defenderhp = $defenderDamage - $attackerDamage;
			//change the state of the board
			attack($connection,$gameID,findColumnID($attackSpot,$turn),findColumnHP($attackSpot,$turn),$attackerhp,findColumnID($defenceSpot,$otherTurn),findColumnHP($otherTurn),$defenderhp);
		} else if($move == 'sacrifice') {
			//don't know if I'll pas in name or cardid change if I do
			$newid = getID($_POST['summon5']);
			$spot = $_POST['spot5'];
			sacrifice($connection,$gameid,findColumnID($spot,$turn),$newid,findColumnHP($spot,$turn),getCardAttack($connection,$newid));
		}
	}
}