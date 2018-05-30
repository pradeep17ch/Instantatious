<?php
	
	session_start();
	include('dbconnect.php');

	$user = $_GET['followid'];
	$curruser = $_GET['userid'];

	$query = $db->query("INSERT INTO followers (uid, followerid) VALUES ('$user', '$curruser')");
	$query2 = $db->query("INSERT INTO following (uid, followingid) VALUES ('$curruser', '$user')");
	$query3 = $db->query("UPDATE users SET followers = followers + 1 WHERE userid='$user'");
	$query4 = $db->query("UPDATE users SET following = following + 1 WHERE userid='$curruser'");


	if($query && $query2 && $query3 && $query4)
	{
		header("Location: userpage.php?uid=".$user);
		exit();
	}

	else
	{
		echo "<script>alert('Unable to execute query');</script>";
	}
?>