<?php

	session_start();
	include('dbconnect.php');

	function article_exists($image_id, $db){
		$image_id = (int)$image_id;
			$query1 = $db->query("SELECT * FROM images WHERE image_id = '$image_id' ");
			if($query1->num_rows >= 1)
				return true;
			else return false;
	}
	function previously_liked($image_id, $db){
		$image_id = (int)$image_id;
		$query2 = $db->query("SELECT * FROM likes WHERE liker_id = ".$_SESSION['userid']." AND image_id = $image_id");
		if($query2)
		{
			if($query2->num_rows >= 1 )
			{
				return true;
			}
			else return false;
		}
	}
	function like_count($image_id, $db){
		$image_id = (int)$image_id;
		$query3 = $db->query("SELECT * FROM images WHERE image_id = $image_id");
		while($row = $query3->fetch_array())
		{
			$answer = $row[4];
			break;
		}
		return $answer;
	}
	function add_like($image_id, $db){
		$image_id = (int)$image_id;
		$db->query("UPDATE images SET likes = likes + 1 WHERE image_id = '$image_id' ");
		$db->query("INSERT INTO likes (liker_id, image_id) VALUES (".$_SESSION['userid'].",$image_id)");
	}
	function remove_like($image_id, $db){
		$image_id = (int)$image_id;
		$db->query("UPDATE images SET likes = likes - 1 WHERE image_id = '$image_id' ");
		$db->query("DELETE FROM likes WHERE liker_id = ".$_SESSION['userid']." AND image_id = '$image_id' ");
	}
?>