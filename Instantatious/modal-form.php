<?php

    session_start();
    include('dbconnect.php');

    $user = $_SESSION['userid'];
    $image_id = $_GET['image_id'];

    if(isset($_POST['subcomm']))
    {
        $comment = $_POST['comment'];

        $query6 = $db->query("SELECT * FROM images WHERE image_id = '$image_id' ");

        $row = $query6->fetch_array();
        $poster = $row[0];

        $query5 = $db->query("INSERT INTO comments (image_id, comment_desc, poster_id, commenter_id) VALUES ('$image_id', '$comment', '$poster' , '$user')");

        $query8 = $db->query("UPDATE images SET comments = comments + 1 WHERE image_id = '$image_id' ");
    }

?>

<div class="modal-header" style="text-align: right;">
    <button class="btn btn-warning" ng-click="cancel()">X</button>
</div>
<div class="modal-body">
   <center>
 
    <?php

        $query3 = $db->query("SELECT * FROM images WHERE image_id='$image_id'");
        while ($row = $query3->fetch_array()) {

            echo '<div style="padding: 20px;"><img height="300" width="300" src="data:image;base64,'.$row[2].'"></div>';
        }
    ?>
    <div>

        <div style="padding: 20px;">

            <?php

                $query4 = $db->query("SELECT * FROM comments WHERE image_id = '$image_id' ");

                if($query4)
                {
                    while ($row = $query4->fetch_object())
                    {
                        $query7 = $db->query("SELECT * FROM users WHERE userid = '$row->commenter_id' ");
                        $row1 = $query7->fetch_object();
                        $commenter_name = $row1->username;
                        echo '<div style="border: solid black 1px; padding:5px; width:50%"><p>'.$row->comment_desc.'</p></div>Comment by: '.$commenter_name.'<br/><br/>';
                    }
                }

            ?>

            <div>
                <input type="button" class='like' value="LikeButton" onclick="likeFunction()" /> </input>
            </div>

            <form action="" method="post"><textarea name="comment" placeholder="Write a comment.." cols=50 rows=2></textarea><input type="submit" name="subcomm"></form>

        </div>

    </div>

    </center>
</div>
<div class="modal-footer">
</div>
