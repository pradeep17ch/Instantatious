<?php
	session_start();
	include('dbconnect.php');

	$user = $_SESSION['userid'];

	if(isset($_POST['subusername']))
	{
		$newusername = $_POST['userfield'];
		$query4 = $db->query("UPDATE users SET username = '$newusername' WHERE userid = '$user' ");
	}

	if(isset($_POST['subpassword']))
	{
		$newpassword = $_POST['passfield'];
		$newpassword = md5($newpassword);
		$query6 = $db->query("UPDATE users SET password = '$newpassword' WHERE userid = '$user' ");
	}

	if(isset($_POST['substatus']))
	{
		$newstatus = $_POST['statusfield'];
		$query5 = $db->query("UPDATE users SET status = '$newstatus' WHERE userid = '$user' ");
	}

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

	$query = $db->query("SELECT * FROM users WHERE userid='$user'");

	if($query->num_rows === 1){
		while ($row = $query->fetch_object()) {
			$status = $row->status;
			$username = $row->username;
			$password = $row->password;
			$followercount = $row->followers;
			$followingcount = $row->following;
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
	      <a class="navbar-brand" href="index.php">Instantatious - Connect to people instantly!</a>
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

    <div style="padding: 20px; ">
    		
		<div style="display: flex; padding: 20px; ">
			<div style="width: 33%; ">Edit username: </div>
			
			<div style="width: 33%;">
				Username: Hi <?php echo $username ?>!
			</div>

			<form action="editdetails.php" method="post"><input type="text" name="userfield">&nbsp;&nbsp;<button type="submit" name="subusername">Update</button></form>

		</div>

		<div style="display: flex; padding: 20px; ">
			<div style="width: 33%; ">Edit password: </div>
			<div style="width: 33%; "></div>
			<form action="editdetails.php" method="post"><input type="text" name="passfield">&nbsp;&nbsp;<button type="submit" name="subpassword">Update</button></form>

		</div>


    	<div style="display: flex; padding: 20px; ">
			<div style="width: 33%;">Edit profile picture:</div>
			
			<div style="width: 33%;">
				<?php
					displayimage($db, $user);
					function displayimage($db, $user)
					{
						$query3 = $db->query("SELECT * FROM profilepics WHERE uid = '$user'");
						while ($row = $query3->fetch_array()) {
							echo '<img height="100" width="100" src="data:image;base64,'.$row[1].'">';
						}
					}

				?>
			</div>
			<div style="width: 33%;">
				<form action="editdetails.php" method="post" enctype="multipart/form-data"><input type="file" name="propic"><button type="submit" name="subpropic" value="Upload">Update</button></form>
			</div>
		</div>
		
		<div style="display: flex; padding: 20px; ">
			<div style="width: 33%; ">Edit status: </div>
			
			<div style="width: 33%;">
				Status: <?php echo $status ?>
			</div>


			<form action="editdetails.php" method="post"><textarea cols="40" rows="5" name="statusfield"></textarea> &nbsp;&nbsp;<button type="submit" name="substatus">Update</button></form>

		</div>
		
	</div>

	<center>
		<form action="index.php" method="post"><button style="width:80px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Done</button></form>

	</center>

</body>
</html>