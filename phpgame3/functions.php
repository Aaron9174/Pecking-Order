<?php
include "Card.php";
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

//creates a deck user pair in the user_deck table
function initDeck($connection,$userid)
{
	$SQL = "INSERT INTO game.user_deck (userid)
			VALUES (?)";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	
	$SQL = "SELECT deckid
			FROM game.user_deck
			where userid = ?";
	$deckID;
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_bind_result($stmt,$deckID);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
	$SQL = "INSERT INTO game.deck (ownerid,cardid,deckid)
			VALUES (?,?,?)";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		echo "before loop";
		$i=1;
		while($i<=30)
		{
			echo "inside loop" . $i . "<br />";
			if($i <=20) {
				$cardid = $i;
			} else {
				$cardid = $i+rand(5,20);
			}
			$bind = mysqli_stmt_bind_param($stmt, "iii",$userid,$cardid,$deckID);
			$result = mysqli_stmt_execute($stmt);
			$i=$i+1;
			if($bind) {
				echo "true";
			}
			if($result) {
				echo "result true";
			}
		}
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


function attack($connection,$gameID,$attackIdSpot,$attackHpSpot,$attackhp,$defendIdSpot,$defendHpSpot,$defendhp)
{
	if($attackhp <= 0 && $defendhp <=0 ) {
		$SQL = "UPDATE game.game_instance
				SET ".$attackIdSpot." = NULL, ".$attackHpSpot." = NULL, ".$defendIdSpotSpot." = NULL, ".$defendHpSpot." = NULL WHERE gameid = ?";
	}
	else if($defendhp <= 0) {
		$SQL = "UPDATE game.game_instance
				SET ".$attackHpSpot. " = ".$attackhp." , ".$defendIdSpotSpot." = NULL, ".$defendHpSpot." = NULL WHERE gameid = ?";
	}
	else if($attackhp <= 0) {
		$SQL = "UPDATE game.game_instance
				SET ".$attackIdSpot." = NULL, ".$attackHpSpot." = NULL, ".$defendHpSpot." = ".$defendhp." WHERE gameid = ?";
	} else {
		$SQL = "UPDATE game.game_instance
				SET ".$attackHpSpot. " = ".$attackhp." , ".$defendHpSpot." = ".$defendhp." WHERE gameid = ?";
	}
			
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $gameid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function directAttack($connection,$gameid,$turn,$attack)
{
	if($turn==1) {
		$userhp = "user1hp";
	} else {
		$userhp = "user2hp";
	}
	$SQL = "SELECT ".$userhp." FROM game.game_instance WHERE gameid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $gameid);
		mysqli_stmt_bind_result($stmt,$hp);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	
	$SQL = "UPDATE game.game_instance
			SET ".$userhp. " = ? WHERE gameid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "ii", $hp,$gameid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function sacrifice($connection,$gameid,$newidcol,$newid,$newhpcol,$newhp)
{
	$SQL = "UPDATE game.game_instance
			SET ".$newidcol." = ".$newid. " , ".$newhpcol. " = ".$newhp. " WHERE gameid = ?";
			
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $gameid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function getCardAttack($connection,$cardid)
{
	$SQL = "SELECT attack
			FROM game.animal
			WHERE cardid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $cardid);
		mysqli_stmt_bind_result($stmt,$attack);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
	return $attack;
}

function placeCard($connection,$gameid,$columnid,$id,$columnhp,$attack)
{
	$SQL = "UPDATE game.game_instance
			SET ".$columnid." = ".$id." , ".$columnhp." = ".$attack." WHERE gameid = ?";
			
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $gameid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function findColumnID($spot,$turn)
{
	if($turn==1) {
		if($spot==1) {
			return "user1cardid1";
		} else if($spot==2) {
			return "user1cardid2";
		} else if($spot==3) {
			return "user1cardid3";
		} else if($spot==4) {
			return "user1cardid4";
		} else if($spot==5) {
			return "user1cardid5";
		}
	} else {
		if($spot==1) {
			return "user2cardid1";
		} else if($spot==2) {
			return "user2cardid2";
		} else if($spot==3) {
			return "user2cardid3";
		} else if($spot==4) {
			return "user2cardid4";
		} else if($spot==5) {
			return "user2cardid5";
		}
	}
}

function findColumnHP($spot,$turn)
{
	if($turn==1) {
		if($spot==1) {
			return "user1cardhp1";
		} else if($spot==2) {
			return "user1cardhp2";
		} else if($spot==3) {
			return "user1cardhp3";
		} else if($spot==4) {
			return "user1cardhp4";
		} else if($spot==5) {
			return "user1cardhp5";
		}
	} else {
		if($spot==1) {
			return "user2cardhp1";
		} else if($spot==2) {
			return "user2cardhp2";
		} else if($spot==3) {
			return "user2cardhp3";
		} else if($spot==4) {
			return "user2cardhp4";
		} else if($spot==5) {
			return "user2cardhp5";
		}
	}
}

//use this later to get the board state of the game from one users perspective
function getBoardState($connection,$turn,$gameid)
{
	$SQL = "SELECT *
			FROM game.game_instance
			WHERE gameid = ?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $gameid);
		mysqli_stmt_execute($stmt);
		$gamestate = mysqli_fetch_array($stmt);
		mysqli_stmt_close($stmt);
	}
	$count = count($gamestate);
	for($i=2;$i<$count;$i++)
	{
		echo $gamestate[$i] . ":";
	}
}

//returns a shuffled deck with all of the users cards
function startDeck($connection,$userid)
{
	$fullDeck = array();
	$SQL = "SELECT a.name,a.attack,a.mana,a.sacrifice,a.type
			FROM game.deck d, game.animal a
			WHERE d.cardid = a.cardid
			AND d.ownerid =?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		while($row = mysqli_fetch_array($stmt))
		{
			$card = new AnimalCard($row['name'],$row['mana'],$row['sacrifice'],$row['attack'],$row['type']);
			$fullDeck[] = card;
		}
		mysqli_stmt_close($stmt);
	}
	$SQL = "SELECT s.name,s.mana,s.effect
			FROM game.deck d, game.spell s
			WHERE d.cardid = s.cardid
			AND d.ownerid =?";
	if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
		while($row = mysqli_fetch_array($stmt))
		{
			$card = new SpellCard($row['name'],$row['mana'],$row['effect']);
			$fullDeck[] = card;
		}
		mysqli_stmt_close($stmt);
	}
	return $fullDeck;
}