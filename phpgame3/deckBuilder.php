<?php
include "functions.php";
include "dbInfo.php";

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

if(isset($_POST['buyPack']))
{
    $userid = getID($connection,$_POST['username']);
    $SQL = "UPDATE game.collection SET num = 3 WHERE userid = ? AND cardid = ?";
    $i=0;
    if ($stmt = mysqli_prepare($connection,$SQL)) {
        while($i<5) {
                $cardid = rand(1,45);
                echo $cardid . "  " . $userid;
		mysqli_stmt_bind_param($stmt, "ii", $userid,$cardid);
		$result = mysqli_stmt_execute($stmt);
                $i++;
            }
        mysqli_stmt_close($stmt);
	}
    $SQL = "SELECT gold FROM game.user WHERE id = ?";
    $gold;
    if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "i", $userid);
		mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt,$gold);
                mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
	}
    $SQL = "UPDATE game.user SET gold = ? WHERE id = ?";
    $gold = $gold-300;
    if ($stmt = mysqli_prepare($connection,$SQL)) {
		mysqli_stmt_bind_param($stmt, "ii", $gold,$userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}
 
