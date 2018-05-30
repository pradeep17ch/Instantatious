<?php

    session_start();
    include('dbconnect.php');

    $user = $_SESSION['userid'];
    $image_id = $_POST['rowid'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Instantatious - Connect to people instantly!</title>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/js" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
    <link rel="stylesheet" type="text/js" href="bootstrap/js/bootstrap.js">
    <link rel="stylesheet" type="text/js" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
     <script src="jquery-3.2.1.min.js"></script>  
           <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />  
           <script src="bootstrap/js/bootstrap.js"></script> 
           <script type="text/javascript" src="like.js"></script>

    <script type="text/javascript">

        $('#subcomm').click(function(){

            var comment = $('#comment').val();
            var imageid = <?php echo $image_id ?>;

            if(comment != '')
            {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data:{comment:comment, imageid:imageid},
                    success:function(data){
                        if(data == 'No')
                        {
                            alert("Unable to insert comment");
                        }
                        else
                        {
                            location.reload();
                        }
                    }

                });
            }

        });

    </script>

</head>
<body>


    <?php

        $query3 = $db->query("SELECT * FROM images WHERE image_id='$image_id'");
        while ($row = $query3->fetch_array()) {

            echo '<div style="padding: 20px;"><img height="400" width="400" src="data:image;base64,'.$row[2].'"></div>';
        }
    ?>
    <br/>

            <?php
                $query6 = $db->query("SELECT * FROM images WHERE image_id = '$image_id' ");
                $row6 = $query6->fetch_object();
                $nolikes = $row6->likes;

                $query7 = $db->query("SELECT * FROM likes WHERE liker_id = '$user' AND image_id = '$image_id' ");
                if($query7->num_rows >= 1)
                    $flagliked = 1;
                else
                    $flagliked = 0;
            ?>

            <div style="padding: 20px; ">
                <button type="button" style="width:50px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;" onclick="like_add(<?php echo $image_id; ?>)"><span id="iflike_<?php echo $image_id ?>">
                    
                    <?php
                        if($flagliked == 1){
                            echo "Unlike";
                        }

                        else{
                            echo "Like";
                        }

                    ?>

                </span></button>&nbsp;&nbsp;&nbsp;&nbsp;<span id="article_<?php echo $image_id ?>_likes"><?php echo $nolikes ?></span> people like this</p>
            </div>

    <div>
        

    <br/>

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
                        echo '<div style="border: solid black 1px; padding:5px; width:50%"><p>'.'<span style="color: red; font-weight: bold;">'.$commenter_name.'</span>: '.$row->comment_desc.'</p></div><br/>';
                    }
                }

            ?>

          

            <div style="display: flex;">
            <div style="padding: 10px; "><textarea name="comment" id="comment" placeholder="Write a comment.." cols=50 rows=2></textarea></div>
            <div style="padding: 10px; "><button type="button" id="subcomm" class="btn btn-success" name="subcomm">Submit</button></div>
            </div>

        </div>

    </div>

</body>
</html>