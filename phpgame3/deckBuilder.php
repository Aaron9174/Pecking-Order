<?php
include "functions.php";
include "dbInfo.php"

if(isset($_POST['cardCollection']))
{
	$userid = getID($connection,trim($_POST['username']));
	$cardIDArray = userCollectionNames($connection,$userid);
	$count = count($cardIDArray);
	$i=0;
	while($i<$count)
	{
		echo $cardIDArray[$i] . ":";
		$i++;
	}
}

if(isset($_POST['collectionNum']))
{
	$userid = getId($connection,$_POST['username']);
	$cardNumArray = numberInCollection($connection,$userid);
	$count = count($cardNumArray);
	$i=0;
	while($i<$count)
	{
		echo $cardNumArray[$i].":";
		$i++;
	}
}

if(isset($_POST['initCollection']))
{
	$userid = getID($connection,$_POST['username']);
	initCollection($connection,$userid);
	initDeck($connection,$userid);
}

if(isset($_POST['userDeckAnimal']))
{
	$userid = $_POST['username'];
	getUserDeckAnimal($connection,$userid,$_POST['decknum']);
}

if(isset($_POST['userDeckSpell']))
{
	$userid = $_POST['username'];
	getUserDeckSpell($connection,$userid,$_POST['decknum']);
}