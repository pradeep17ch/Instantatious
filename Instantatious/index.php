<?php
	
	session_start();
	include('dbconnect.php');

	if(!$_SESSION['userid']){
		header('Location: login.php');
	}
	
	$user = $_SESSION['userid'];
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
<html ng-app = "myApp">
<head>
	<title>Instantatious - Connect to people instantly!</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/js" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
	<link rel="stylesheet" type="text/js" href="bootstrap/js/bootstrap.js">
	<link rel="stylesheet" type="text/js" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	 <script src="jquery-3.2.1.min.js"></script>  
	 <script src="angular.min.js"></script>
           <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />  
           <script src="bootstrap/js/bootstrap.js"></script> 

           <script type="text/javascript">
           	
           		$(document).ready(function(){
				    $('#loginModal').on('show.bs.modal', function (e) {
				        var rowid = $(e.relatedTarget).data('id');
				        $.ajax({
				            type : 'post',
				            url : 'test.php', //Here you will fetch records 
				            data :  'rowid='+ rowid, //Pass $id
				            success : function(data){

				            $('.fetched-data').html(data);//Show fetched data from database
				            }
				        });
				     });
				});


           </script>


<script>
	var app = angular.module('myApp',[]);
	app.controller('cntrl',function($scope,$http){
		$scope.search = function(){
			$http.post("search.php",{'a':$scope.keywords})
			.success(function(data){
				
				if(data!='')$scope.data1 = data;
				else alert("Not Found!");
			});
		}
		
		});
</script>



	<style type="text/css">
		
		 	.custom-file-input::-webkit-file-upload-button {
			  visibility: hidden;
			}
			.custom-file-input::before {
			  content: ' + ';
			  display: inline-block;
			  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
			  border: 1px solid #999;
			  border-radius: 3px;
			  padding: 5px 8px;
			  outline: none;
			  white-space: nowrap;
			  -webkit-user-select: none;
			  cursor: pointer;
			  text-shadow: 1px 1px #fff;
			  font-weight: 700;
			  font-size: 10pt;
			  color: black;
			}
			
			input[type='file'] {
			  color: transparent;
			}

	</style>

</head>
<body ng-controller="cntrl" >

	<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.php">Instantatious - Connect to people instantly!</a>
		    </div>
		    <ul class="nav navbar-nav navbar-right">
		      <li><div style="padding: 10px;">
			<form class="searchform cf">
				<input style="width: 300px; height: 35px;" ng-model="keywords" type="text"  ng-change="search()" placeholder="Is it me you’re looking for?" required />
			</form>
</div>


		      <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
		      <li><a href="feed.php"><span class="glyphicon glyphicon-th-list"></span> Feed</a></li>
		      <li><a href="about.php"><span class="glyphicon glyphicon-list-alt"></span> About</a></li>
		      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		    </ul>
		  </div>
		</nav>



	<div id="hide">
			<div id="blog"  ng-repeat ="doc in data1" >
				<a ng-href="userpage.php?uid={{ doc.userid }}"><div id="cat">{{ doc.username }}</div></a>
				
			</div>
			</div>
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
				<br/>

				<div id="status" style="padding: 20px;">
					<?php echo $status ?>
				</div>

				<form action="editdetails.php" method="post"><button style="width:120px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Edit details</button></form>
						
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
			
		<div style="padding: 20px;">
			<form action="postimage.php" method="post" enctype="multipart/form-data"><input type="file" class="custom-file-input" title=" " name="postpic"><button type="submit" name="subpic" value="Upload">Add post</button></form>		
		</div>

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
					
					echo '<div style="padding: 20px;">'.'<button type="button" name="login" id="login" class="" data-toggle="modal" data-target="#loginModal" data-id="'.$image_id.'"><div style="border: solid black 5px;"><img height="300" width="300" src="data:image;base64,'.$row[2].'" class="getSrc"></div></div></button>';
					
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

	
	<div id="loginModal" class="modal fade" role="dialog">
			<!--sets proper width and margin of the modal-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>

				</div>

				<div class="modal-body">
					<div class="fetched-data"></div>
				</div>

			</div>

		</div>

	</div>




</body>
</html>