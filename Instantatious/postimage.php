<?php

	session_start();
	include('dbconnect.php');

	$user = $_SESSION['userid'];


			
			$image = addslashes($_FILES['postpic']['tmp_name']);
			$name = addslashes($_FILES['postpic']['name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);


			$query2 = $db->query("INSERT INTO images (uid, image, imagename, likes, comments) VALUES('$user', '$image', '$name', '0', '0')");

			if($query2)
			{
				header('Location: index.php');
			}
			else
			{
				echo '<script>alert("Error uploading image.");</script>';
			}
?>