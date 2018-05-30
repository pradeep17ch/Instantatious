<?php

	session_start();
	include('dbconnect.php');

	$user = $_SESSION['userid'];
	$image_id = $_GET['image_id'];

	if(isset($_POST['subcomm']))
	{
		$comment = $_POST['comment'];

		$query6 = $db->query("SELECT * FROM images WHERE image_id = '$image_id' ");

		$row = $query6->fetch_array();
		$poster = $row[0];

		$query5 = $db->query("INSERT INTO comments (image_id, comment_desc, poster_id, commenter_id) VALUES ('$image_id', '$comment', '$poster' , '$user')");

		$query8 = $db->query("UPDATE images SET comments = comments + 1 WHERE image_id = '$image_id' ");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Instantatious - Connect to people instantly!</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/js" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">

	<script type="text/javascript">
	
		function likeFunction() {
		  alert("liked");
		}


	</script>


</head>
<body>

	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="home.php">Instantatious - Connect to people instantly!</a>
	    </div>
	    <ul class="nav navbar-nav navbar-right">
	      <li><div style="padding: 10px;"><form action="search_result.php" method="post"><input type="text" name="search" style="width: 300px; height: 35px;"><button type="submit" name="submit" style="background-color: black; color: white; width: 35px; height: 35px;"><span class="glyphicon glyphicon-search"></span> </button></form></div>
	      <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
	      <li><a href="feed.php"><span class="glyphicon glyphicon-th-list"></span> Feed</a></li>
	      <li><a href="about.php"><span class="glyphicon glyphicon-list-alt"></span> About</a></li>
	      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
	    </ul>
	  </div>
	</nav>


	<?php

		$query3 = $db->query("SELECT * FROM images WHERE image_id='$image_id'");
		while ($row = $query3->fetch_array()) {

			echo '<div style="padding: 20px;"><img height="400" width="400" src="data:image;base64,'.$row[2].'"></div>';
		}
	?>
	<br/>
	<div>
		

	<br/>

		<div style="padding: 20px;">

			<h1>Comments</h1> <br/>

			<?php

				$query4 = $db->query("SELECT * FROM comments WHERE image_id = '$image_id' ");

				if($query4)
				{
					while ($row = $query4->fetch_object())
					{
						$query7 = $db->query("SELECT * FROM users WHERE userid = '$row->commenter_id' ");
						$row1 = $query7->fetch_object();
						$commenter_name = $row1->username;
						echo '<div style="border: solid black 1px; padding:5px; width:50%"><p>'.$row->comment_desc.'</p></div>Comment by: '.$commenter_name.'<br/><br/>';
					}
				}

			?>

			<div>
			    <input type="button" class='like' value="LikeButton" onclick="likeFunction()" /> </input>
			</div>

			<form action="" method="post"><textarea name="comment" placeholder="Write a comment.." cols=50 rows=2></textarea><input type="submit" name="subcomm"></form>

		</div>

	</div>

</body>
</html>