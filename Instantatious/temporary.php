<?php
	
	session_start();
	include('dbconnect.php');
	
	$user = $_GET['uid'];
	$curruser = $_SESSION['userid'];
	$query = $db->query("SELECT propic, status, followers, following FROM users WHERE userid='$user'");

	if($query->num_rows === 1){
		while ($row = $query->fetch_object()) {
			$status = $row->status;
			$followercount = $row->followers;
			$followingcount = $row->following;
		}
	}
	else{
		echo "<script type='text/javascript'>alert('Unable to find information.');</script>";
	}

	
	$query = $db->query("SELECT * FROM following WHERE uid='$curruser' AND followingid='$user'");

	if($query->num_rows === 1)
		$flag=1;
	else $flag=0;


	if(isset($_POST['subpropic']))
	{
		if(!isset($_FILES['propic']))
		echo '<script>alert("Upload a photo as your profile picture");</script>';


		else
		{
			
			$image = addslashes($_FILES['propic']['tmp_name']);
			$name = addslashes($_FILES['propic']['name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);
			saveimage($db, $user, $name, $image);
		}

	}

	function saveimage($db, $user, $name, $image)
	{
		$query1 = $db->query("SELECT * FROM profilepics WHERE uid = '$user'");

		if($query1->num_rows === 1)
		{
			$query2 = $db->query("UPDATE profilepics SET propic = '$image', picname = '$name' WHERE uid = '$user' "); 


			if($query2)
			{
				echo '<script>alert("Image updated.");</script>';
			}
			else
			{
				echo '<script>alert("Error updating image.");</script>';
			}
		}

		else
		{
			$query2 = $db->query("INSERT INTO profilepics (uid, propic, picname) VALUES('$user', '$image', '$name')");

			if($query2)
			{
				echo '<script>alert("Image uploaded.");</script>';
			}
			else
			{
				echo '<script>alert("Error uploading image.");</script>';
			}
		}
	}
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

	<div style="text-align:right; list-style-position: inside;">
		<ul>
			
		</ul>

	</div>

	<div>
		<div id="topbox" style="display: flex; align-items: center; text-align: center; padding: 20px">
				
			<div id="propic" style="width: 33%">
				<div>
					<?php
						displayimage($db, $user);
						function displayimage($db, $user)
						{
							$query3 = $db->query("SELECT * FROM profilepics WHERE uid = '$user'");
							while ($row = $query3->fetch_array()) {
								echo '<img height="200" width="200" src="data:image;base64,'.$row[1].'">';
							}
						}

					?>
				</div>
				<br/>
				<div style="font-size: 18px; font-weight: bold; font-family: 'comic sans ms' "><u>
					<?php
						$query4 = $db->query("SELECT * FROM users WHERE userid = '$user' ");
						while($row = $query4->fetch_object()){
							$nameofuser = $row->username;
						}
						echo $nameofuser;

					?>
				</u></div>


				<div id="status" style="padding: 20px;">
					<?php echo $status ?>
				</div>


				<div>
					<?php if($flag==0){ 
					$str = "follow.php?userid=".$curruser."&followid=".$user;
					?>
					<form action="<?php echo $str ?>" method="post"><button type="submit" value="follow" style="width:80px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Follow</button></form>
					<?php 
						}
						else{
							$str = "unfollow.php?userid=".$curruser."&followid=".$user;
					?>
							<form action="<?php echo $str ?>" method="post"><button type="submit" value="unfollow" style="width:80px; height: 35px; background-color: white; color: #3399ff; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Following</button></form>
					<?php
						}
					?>

				</div>


			</div>


			<div id="followers" style="width: 33%; font-size: 20px;">
				<?php 
					$str = "showfollowers.php?folusid=$user";
				?>
				<a href="<?php echo $str ?>"><?php echo $followercount ?> followers</a>
			</div>

			<div id="following" style="width: 33%; font-size: 20px;">
				<?php 
					$str = "showfollowing.php?folusid=$user";
				?>
				<a href="<?php echo $str ?>"><?php echo $followingcount ?> following</a>
			</div>

		</div>



	</div>

	<div>
			

		<?php

			displayimage2($db, $user);
			function displayimage2($db, $user)
			{
				$query3 = $db->query("SELECT * FROM images WHERE uid = '$user'");
				echo '<div style="display: flex;">';
				$ctr = 0;
				while ($row = $query3->fetch_array()) {
					$image_id = $row[1];
					$str = "showimage.php?image_id=$image_id";
					echo '<div style="padding: 20px;"><a href="'.$str.'">'.'<div style="border: solid black 5px;"><img height="300" width="300" src="data:image;base64,'.$row[2].'"></div></a></div>';
					$ctr = $ctr + 1;

					if($ctr == 4)
					{
						echo '</div><br/><div style="display: flex;">';
						$ctr = 0;
					}
				}
				echo '</div>';
			}


		?>

	</div>

</body>
</html>