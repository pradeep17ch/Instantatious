<?php

	include('dbconnect.php');
	include('like.php');

	if(isset($_POST['image_id'],$_SESSION['userid']) && article_exists($_POST['image_id'], $db)){
		echo like_count($_POST['image_id'], $db);
	}
?>