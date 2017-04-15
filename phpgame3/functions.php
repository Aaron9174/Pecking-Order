<?php

//get the id of a user from their username
function getID($connection,$username)
{
	$SQL = "SELECT id
			FROM game.user
			WHERE username = ?";
			
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $id);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	return $id;
}

//checking if the friend that the user is trying to add exists
function friendExists($connection,$friend)
{
	$SQL = "SELECT COUNT(*)
			FROM game.user
			WHERE username = ?";
	$count;
	
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "s", $friend);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $count);
		mysqli_stmt_fetch($stmt);
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
//getting the number of friends the user has online
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
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $count);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	return $count;
}

//the usernames of the friends that are online
function friendArray($connection,$username)
{
	$SQL = "SELECT id
			FROM game.user
			WHERE username = ?";
			
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $userid);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
	$SQL = "SELECT username
			from game.user
			WHERE isonline=1
			AND id IN (SELECT friendid
							from game.friends
							WHERE userid = ? )";
							
	$friendArray = array();
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $user);
		while(mysqli_stmt_fetch($stmt))
		{
			$friendArray[] = $user;
		}
		mysqli_stmt_close($stmt);
	}
	return $friendArray;
}

//getting the name of the card from the card table where you know the card id
function getCardName($connection,$cardid)
{
	$SQL = "SELECT name
			FROM game.Card
			WHERE cardid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $cardid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$name);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	return $name;
}

//getting the card name from the card id
function getAnimalName($connection,$cardid)
{
	$SQL = "SELECT name
			FROM game.animal
			WHERE cardid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $cardid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$name);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	return $name;
}

//get the name of the spell
function getSpellName($connection,$cardid)
{
	$SQL = "SELECT name
			FROM game.spell
			WHERE cardid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $cardid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$name);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	return $name;
}

//getting the number of cards the user has in their collecetion
function numCards($connection,$username)
{
	$SQL = "SELECT COUNT(*)
			FROM game.card
			WHERE userid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$count);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	return $count;
}

//returns an array holding every cardid that the user owns
function userCollectionNames($connection,$userid)
{
	$cardIDArray = array();
	$SQL = "SELECT ca.name
			FROM game.collection co,game.Card ca
			WHERE co.userid = ?
			AND co.cardid = ca.cardid
			AND co.num > 0";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$cardid);
		while(mysqli_stmt_fetch($stmt))
		{
			$cardIDArray[] = $cardid;
		}
		mysqli_stmt_close($stmt);
	}
	return $cardIDArray;	
}

//return how many of each card the user has in their collection
function numberInCollection($connection,$userid)
{
	$SQL = "SELECT num
			FROM game.collection
			WHERE num >0
			AND userid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$cardnum);
		while(mysqli_stmt_fetch($stmt))
		{
			$cardNumArray[] = $cardnum;
		}
		mysqli_stmt_close($stmt);
	}
	return $cardNumArray;
}

//returns all of the information from the users deck that are animals
function getUserDeckAnimal($connection,$userid,$decknum)
{
	$SQL = "SELECT name,attack,sacrifice,mana,type
			FROM game.animal
			WHERE cardid in (SELECT cardid
							FROM game.deck
							WHERE decknum = ?
							AND userid = ?)";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "ii",$decknum,$userid);
		mysqli_stmt_execute($stmt);
		//mysqli_stmt_bind_result($stmt,$cardid);
		while($row = mysqli_fetch_array($stmt,MYSQLI_NUM))
		{
			echo $row[0].":".$row[1].":".$row[2].":".$row[3].":".$row[4].":";
		}
		mysqli_stmt_close($stmt);
	}
}

//returns all of the information from the users deck that are spells
function getUserDeckSpell($connection,$userid,$decknum)
{
	$SQL = "SELECT name,effect,mana
			FROM game.spell
			WHERE cardid in (SELECT cardid
							FROM game.deck
							WHERE decknum = ?
							AND userid = ?)";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "ii",$decknum,$userid);
		mysqli_stmt_execute($stmt);
		//mysqli_stmt_bind_result($stmt,$cardid);
		while($row = mysqli_fetch_array($stmt,MYSQLI_NUM))
		{
			echo $row[0].":".$row[1].":".$row[2].":";
		}
		mysqli_stmt_close($stmt);
	}
}

//when the user registers an account they get for free all of the basic cards
function initCollection($connection,$userid)
{
	$SQL = "INSERT INTO game.collection (userid,cardid,num)
			VALUES(?,?,2)";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		$i=1;
		while($i <= 45)
		{
			mysqli_stmt_bind_param($stmt, "ii",$userid,$i);
			mysqli_stmt_execute($stmt);
			$i++;
		}
		mysqli_stmt_close($stmt);
	}
}

//creates a deck suer pair in the user_deck table
function initDeck($connection,$userid)
{
	$SQL = "INSERT INTO user_deck (userid)
			VALUES (?)";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

//gets the spell effect from the spell_effect table
function getSpellEffect($connection,$cardid)
{
	$SQL = "SELECT effect
			From game.spell_effect
			WHERE cardid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $cardid);
		mysqli_stmt_bind_result($stmt,$effect);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	echo $effect;
}

//gets the id of the spell from the name
function getSpellID($connection,$cardName)
{
	$SQL = "SELECT cardid
			FROM game.spell
			WHERE name = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "s", $cardName);
		mysqli_stmt_bind_result($stmt,$cardid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	echo $cardid;
}