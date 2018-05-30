<?php

	session_start();
	include('dbconnect.php');

	$user = $_SESSION['userid'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Instantatious - Connect to people instantly!</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/js" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.js"></script>
    <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js"></script>
    <script src="example.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
     <script src="jquery-3.2.1.min.js"></script>  
           <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />  
           <script src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="like.js"></script>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
</head>
<body>

	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="home.php">Instantatious - Connect to people instantly!</a>
	    </div>
	    <ul class="nav navbar-nav navbar-right">
	      <li><div style="padding: 10px;"><form action="search_result.php" method="post"><input type="text" name="search" style="width: 300px; height: 35px;"><button type="submit" name="submit" style="background-color: black; color: white; width: 35px; height: 35px;"><span class="glyphicon glyphicon-search"></span> </button></form></div>
	      <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
	      <li class="active"><a href="feed.php"><span class="glyphicon glyphicon-th-list"></span> Feed</a></li>
	      <li><a href="about.php"><span class="glyphicon glyphicon-list-alt"></span> About</a></li>
	      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
	    </ul>
	  </div>
	</nav>

	<?php

		$query1 = $db->query("SELECT * FROM images INNER JOIN following ON images.uid = following.followingid WHERE following.uid = '$user' ORDER BY images.image_id DESC");

		while ($row = $query1->fetch_array()) {
			$image_id = $row[1];
			$poster = $row[0];
			$str = "showimage.php?image_id=$image_id";
			?>
			<center>
			<div style="border: solid black 2px; width: 500px; padding: 10px;">
			<div style="border: solid black 1px; width: 400px; padding: 10px; text-align: left;">
			<?php

			$query5 = $db->query("SELECT * FROM users WHERE userid = '$poster' ");

			while($row3 = $query5->fetch_object())
			{
				$postername = $row3->username;
			}

			$query6 = $db->query("SELECT * FROM profilepics WHERE uid = '$poster'");
			while ($row1 = $query6->fetch_array()) {
				echo '<img height="40" width="40" src="data:image;base64,'.$row1[1].'">';
			}

			echo '&nbsp;&nbsp;&nbsp;<span style="font-weight: bold; font-size: 18px; ">'.$postername.'</span>';

			?>
			</div>
			<?php
			echo '<div style="padding: 20px;"><a href="'.$str.'">'.'<img height="300" width="300" src="data:image;base64,'.$row[2].'"></a></div>';

			?>
			<br>

				 <?php
	                $query8 = $db->query("SELECT * FROM images WHERE image_id = '$image_id' ");
	                $row8 = $query8->fetch_object();
	                $nolikes = $row8->likes;

	                $query7 = $db->query("SELECT * FROM likes WHERE liker_id = '$user' AND image_id = '$image_id' ");
	                if($query7->num_rows >= 1)
	                    $flagliked = 1;
	                else
	                    $flagliked = 0;
	            ?>

	            <div style="padding: 20px; ">
	                <button type="button" style="width:50px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;" onclick="like_add(<?php echo $image_id; ?>)"><span id="iflike_<?php echo $image_id ?>">
	                    
	                    <?php
	                        if($flagliked == 1){
	                            echo "Unlike";
	                        }

	                        else{
	                            echo "Like";
	                        }

	                    ?>

	                </span></button>&nbsp;&nbsp;&nbsp;&nbsp;<span id="article_<?php echo $image_id ?>_likes"><?php echo $nolikes ?></span> people like this</p>
	            </div>

 			<br><br>

 			<?php

 				$query3 = $db->query("SELECT * FROM comments WHERE image_id='$image_id' ORDER BY comment_id DESC");

 				if($query3->num_rows >= 1)
 				{

 					echo '<div style="border: solid black 1px; width: 400px; padding: 20px;">';
	 				while($row2 = $query3->fetch_object())
	 				{
	 					$commenter = $row2->commenter_id;
						
						$query4 = $db->query("SELECT * FROM profilepics WHERE uid = '$commenter'");
						while ($row1 = $query4->fetch_array()) {
							echo '<img height="40" width="40" src="data:image;base64,'.$row1[1].'">';
						}
						echo '&nbsp;&nbsp;&nbsp;';
	 					echo $row2->comment_desc;
	 					break;
	 				}
	 				echo '</div><br><br>';
 				}

 			?>
			
			<form action="insertcomment.php?image_id=<?php echo $image_id?>" method="post"><textarea name="comment" placeholder="Write a comment.." cols="200" rows=2></textarea>&nbsp;&nbsp;&nbsp;<input type="submit" style="width:80px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;" name="subcomm"></form>

			</center>
			</div>
			<hr style="border: solid black 2px;">
			<?php
		}
	?>

</body>
</html>