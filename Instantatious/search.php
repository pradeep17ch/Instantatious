<?php
	
	include('dbconnect.php');

	$data = json_decode(file_get_contents("php://input"));
	$a=mysqli_real_escape_string($db, $data->a);

	
	
	$search_exploded = explode ( " ", $a );
	$x = 0; 
	$construct = "";
	foreach( $search_exploded as $search_each ){ 
			
		$x++; 
		if( $x == 1 ) 
			$construct .="username LIKE '%$search_each%'"; 
		else 
			$construct .="AND username LIKE '%$search_each%'"; 
	} 
	
	$query = " SELECT * FROM users WHERE $construct "; 
	$result = mysqli_query($db,$query);
	$num= mysqli_num_rows($result);
	
	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_array($result)){
			$output[] = $row;
		}
		echo json_encode($output);
	}
	else{
		echo "";
	}
	
?>