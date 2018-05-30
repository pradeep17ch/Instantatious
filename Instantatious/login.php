<?php
	session_start();

	if(isset($_POST['submit'])){
		
		$user=$_POST['username'];
		$pass=$_POST['password'];

		include('dbconnect.php');

		if(empty($user) || empty($pass)){
			echo "<script type='text/javascript'>alert('Missing info');</script>";

		}

		else{
			$user = strip_tags($user);
			$user = $db->real_escape_string($user);


			$pass = strip_tags($pass);
			$pass = $db->real_escape_string($pass);
			$pass = md5($pass);


			$query = $db->query("SELECT userid, username FROM users WHERE username='$user' AND password='$pass'");

		
			if($query->num_rows === 1){
				while ($row = $query->fetch_object()) {
					$_SESSION['userid'] = $row->userid;
				}
				echo $_SESSION['userid'];
				header('Location: index.php');
				exit();
			}
			else{
				echo "<script type='text/javascript'>alert('Incorrect information');</script>";
			}
		}
	}
?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel="stylesheet" type="text/css" href="index.css">
		<link href='http://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Muli:300,400' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300italic,300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lora:400,700' rel='stylesheet' type='text/css'>
	</head>


	<body>


		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="home.php">Instantatious - Connect to people instantly!</a>
		    </div>
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
		      <li class="active"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		      <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign up</a></li>
		      <li><a href="about.php"><span class="glyphicon glyphicon-list-alt"></span> About</a></li>
		    </ul>
		  </div>
		</nav>

			<br><br>
			<div class="login">
				<br><br><br>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
				
					<p><input class="resize" placeholder="Username" type="text" name="username"></p>
					
					<p><input class="resize" placeholder="Password" type="password" name="password"></p>
					
					<button class="loginbut" type="submit" name="submit" value="login">Login</button>
				</form>

				<div class="newuser">
					<a href="register.php">New user?</a>

				</div>
				<br>
			</div> 


	</body>
</html>