<?php
	session_start();
	include('dbconnect.php');

	if(isset($_SESSION['userid']))
	{
		$flag = 1;
	}
	else
	{
		$flag = 0;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/js" href="bootstrap/js/bootstrap.min.js">
</head>
<body>


	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="home.php">Instantatious - Connect to people instantly!</a>
	    </div>
	    <ul class="nav navbar-nav navbar-right">

	    <?php if($flag == 0): ?>
	      <li><a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
	      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
	      <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign up</a></li>
	      <li class="active"><a href="about.php"><span class="glyphicon glyphicon-list-alt"></span> About</a></li>

	  <?php else: ?>
	  	  <li><div style="padding: 10px;"><form action="search_result.php" method="post"><input type="text" name="search" style="width: 300px; height: 35px;"><button type="submit" name="submit" style="background-color: black; color: white; width: 35px; height: 35px;"><span class="glyphicon glyphicon-search"></span> </button></form></div>
	      <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
	      <li><a href="feed.php"><span class="glyphicon glyphicon-th-list"></span> Feed</a></li>
	      <li class="active"><a href="about.php"><span class="glyphicon glyphicon-list-alt"></span> About</a></li>
	      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
	      
	  	<?php endif ?>

	    </ul>
	  </div>
	</nav>

	<div style="padding: 30px;">
		<p>Hello fellow user!
		We are the creators of Instantatious, which is completely a different concept :P. Well, its not, but we worked our asses off, to create this totally on our own, and making it look as close as possible to the real one. So, we would be glad if you appreciate that. 

		</p>
	</div>
</body>
</html>