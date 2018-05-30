<?php

	session_start();
	include('dbconnect.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Instantatious - Connect to people instantly!</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/js" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
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

		$user = $_GET['folusid'];
		$curruser = $_SESSION['userid'];
		$query = $db->query("SELECT * FROM followers WHERE uid='$user' ");

		while($row = $query->fetch_object())
		{
			$follower = $row->followerid;

			$query2 = $db->query("SELECT * FROM followers WHERE uid='$follower' AND followerid='$curruser'");

			if($query2->num_rows === 1)
				$flag=1;
			else $flag=0;


			?>


			<div style="display: flex; ">
				<div style="width: 33%; text-align: center;">
					
					<?php

						$query3 = $db->query("SELECT * FROM profilepics WHERE uid = '$follower' ");
						while ($row3 = $query3->fetch_array()) {
								echo '<img height="50" width="50" src="data:image;base64,'.$row3[1].'">';
						}
					?>

				</div>

				<?php

				$query1 = $db->query("SELECT username FROM users WHERE userid = '$follower' ");
				$row1 = $query1->fetch_object();
				echo '<div style="padding: 20px; width: 33%; text-align: center; ">';
				?>

				<a href="userpage.php?uid=<?php echo $follower ?>">
				<?php echo $row1->username; ?>
				</a>

				<?php
				echo '</div>';

				echo '<div style="width: 33%; text-align: center; ">';
				if($follower == $curruser)
				{
					//display nothing for the present user.
				}
				
				else if($flag==0){ 
					$str = "follow.php?userid=".$curruser."&followid=".$follower;
				?>
					<form action="<?php echo $str ?>" method="post"><button type="submit" value="follow" style="width:80px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Follow</button></form>
				<?php
				
				}
				else{
						$str = "unfollow.php?userid=".$curruser."&followid=".$follower;
				?>
					<form action="<?php echo $str ?>" method="post"><button type="submit" value="unfollow" style="width:80px; height: 35px; background-color: white; color: #3399ff; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Following</button></form>
				<?php	
				}
				echo '</div>';

				?>
				</div><br/>

				<?php
		}

		?>



</body>
</html>