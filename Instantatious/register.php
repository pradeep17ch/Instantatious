<?php

	include('dbconnect.php');
	
	if(isset($_POST['submit'])){
		$name = $_POST['username'];
		$pass = $_POST['password'];
		$repass = $_POST['repassword'];
		$date = date('Y-m-d');

		if($pass == $repass){

			$pass = md5($pass);

			$query = $db->query("INSERT INTO users (username, password, user_creation_date, user_updated_date) VALUES('$name', '$pass', '$date', '$date')");

			if($query){
				echo "<script>alert('Credentials entered successfully')</script>";
			}

			else{
				echo "<script>alert('Sorry! Couldn't enter credentials.')</script>";
			}
		}

		else{
			echo "<script>alert('Sorry! Your passwords do not match.')</script>";
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
		<link rel="stylesheet" type="text/css" href="index.css">
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body bgcolor="b3f0ff">
		<div class="mainlogin">
		<div>
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid" >
			    <div class="navbar-header">
			      <a class="navbar-brand" href="home.php">Instantatious - Connect to people instantly!</a>
			    </div>
			    <ul class="nav navbar-nav navbar-right">
			    	<li><a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			      <li class="active"><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			      <li><a href="about.php"><span class="glyphicon glyphicon-list-alt"></span> About</a></li>
			    </ul>
			  </div>
			</nav>
			</div>
			<br><br>
			<div class="login">
			<br>
				<div>
					<img src="" style="height:200px; width:200px;  ">
				</div>
				<p class="text-muted" style="font-size: 20px; font-color: white"><b>REGISTER</b></p>
				
					<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
						
					<p><input type="text" class="resize" placeholder="Username" name="username"></p>

					<p><input type="password" class="resize" placeholder="Password" name="password"></p>

					<p><input type="password" class="resize" placeholder="Retype password" name="repassword"></p>

					<button type="submit" class="loginbut" name="submit">Submit</button>

					</form>
				<br>
			</div> 
			
		</div>

</body>
</html>