<?php
	
	session_start();
	include('dbconnect.php');

	$search = $_POST['search'];
	$query = $db->query("SELECT userid, username FROM users WHERE username LIKE '%$search%'");

	while($row = $query->fetch_object())
	{
		$uid = $row->userid;
		echo "<a href='userpage.php?uid=$uid'>".$row->username."</a>";
		echo "<br>";
	}

?>