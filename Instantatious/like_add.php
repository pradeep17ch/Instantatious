<?php

	include('dbconnect.php');
	include('like.php');

	if(isset($_POST['image_id'],$_SESSION['userid']) && article_exists($_POST['image_id'], $db)){
		$image_id = $_POST['image_id'];
		if(previously_liked($image_id, $db) === true){
			remove_like($image_id, $db);
			echo 'successunliked';
		}else{
			add_like($image_id, $db);
			echo 'successliked';
		}
	}
?>