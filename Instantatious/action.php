<?php 

	session_start();
    include('dbconnect.php');

    $user = $_SESSION['userid'];

    if(isset($_POST['comment']))
    {
        $comment = $_POST['comment'];
        $image_id = $_POST['imageid'];

        $query6 = $db->query("SELECT * FROM images WHERE image_id = '$image_id' ");

        $row = $query6->fetch_array();
        $poster = $row[0];

        $query5 = $db->query("INSERT INTO comments (image_id, comment_desc, poster_id, commenter_id) VALUES ('$image_id', '$comment', '$poster' , '$user')");

        $query8 = $db->query("UPDATE images SET comments = comments + 1 WHERE image_id = '$image_id' ");

        if($query5 and $query8)
        {
        	echo "Yes";
        }
        else 
        {
        	echo "No";
        }
    }

?>

