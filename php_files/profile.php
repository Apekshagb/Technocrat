<?php

include 'connect.php';
include 'header.php';

$image_username=$_POST['image_username'];
$image_name=$_FILES['avatar_update']['name'];


$username=mysql_real_escape_string($_GET['name']);

$sql="select * from (SELECT tmp.id as topic_id,tmp.suspend as suspend,tmp.user_level as level,tmp.user_id as id,tmp.user_name as user_name, tmp.user_email as user_email, tmp.user_date as user_date, IFNULL(no_of_Topics,0) as no_of_Topics,  IFNULL(no_of_Postss,0) as no_of_Postss from 
(select * from users4 as u left join (select topics4.topic_by, count(topics4.topic_by) as no_of_Topics, topics4.topic_id as id from topics4 group by topics4.topic_by) as t on u.user_id = t.topic_by group by u.user_id) as tmp
left join (select posts4.post_by, count(posts4.post_by) as no_of_Postss from posts4 group by posts4.post_by) as p on p.post_by = tmp.user_id   group by tmp.user_id) as user where user.user_name='$username'";

$result = mysql_query($sql);



if($image_name)
{
    $today = date("m-d-Y");
    $id=uniqid();
    $ImageDir ="/home/awillis/cs418_html/project4/images/";
    $ImageName = $ImageDir . $id . $image_name;
    $image=$id . $image_name;
    //echo $ImageName;

if (move_uploaded_file($_FILES['avatar_update']['tmp_name'], $ImageName))
 {
  //echo "hhhiii";

  //get info about the image being uploaded
        list($width, $height, $type, $attr) = getimagesize($ImageName);

        switch ($type) {
          case 1:
            $ext = ".gif";
            break;
          case 2:
            $ext = ".jpg";
            break;
          case 3:
            $ext = ".png";
            break;
          default:
            echo "Sorry, but the file you uploaded was not a GIF, JPG, or " .
                 "PNG file.<br>";
            echo "Please hit your browser's 'back' button and try again.";
        }

         //insert info into image table
        $update_image = "update images4 set avatar_id='$image' where image_username='$image_username'";
        $insertresults = mysql_query($update_image)
          or die($mysql_error);
       //$lastpicid = mysql_insert_id();
        /*$newfilename = $ImageDir . uniqid() . $ext;
        srename($ImageName, $newfilename);*/
 }

}



$avatar="SELECT avatar_id from images4 where image_username='$username'";

$avatar_result=mysql_query($avatar);
$avatar_row=mysql_fetch_assoc($avatar_result);
//$get_avatar="SELECT * FROM images4 WHERE image_username = '$username' and avatar_id = '$username'";
 
//$avatar_result = mysql_query($get_avatar);


//$image_filename = "images/" . $avatar_id . ".jpg";



 if(!$result)
{
        echo 'Users couldnot be displayed.....';
}
else
{
        if(mysql_num_rows($result) == 0)
        {
                echo 'No users registered yet.';
        }
        else
        {
                //prepare the table
                echo '<table border="1">
                          <tr>
                                <th>USER PROFILE</th>
                                <th>ROLE</th>
                                
                          </tr>';       


                while($row = mysql_fetch_assoc($result))
                {     
         /*       $image_filename = "images/" . $avatar_id . ".jpg";
        list($width, $height, $type, $attr) = getimagesize($image_filename);   */                       
                        echo '<tr>';
                                echo '<td class="leftpart">';
                                 // while($row1= mysql_fetch_assoc($avatar_result))
                                 //    extract($rows);
                                 //list($width, $height, $type, $attr) = getimagesize($image_filename);   
                                ?>
                                        <?php
                                       if($avatar_row['avatar_id'])
                                        {
                                           echo '<a href="./images/'.$avatar_row['avatar_id'].'" target="_blank"><img src="./images/'.$avatar_row['avatar_id'].'" height=100px width=100px>';
                                           echo '</a><br/>'; 
                                        }
                                        else
                                        {
                                            echo '<a href="./images/default.jpg" target="_blank"><img src="./images/default.jpg" height=100px width=100px>';
                                            echo '</a><br/>';
                                        }
                                        ?>
                                        <?php

                                        $user_name=$row['user_name'];
                                        
                                        if(($user_name) == ($_SESSION['user_name']))
                                        {
                                        ?>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="file" name="avatar_update" id="avatar_update" accept="image/jpeg,image/jpg,image/png,image/gif" />
                                            <input type="hidden" name="image_username" value="<?php echo $row['user_name'];?>"><br>
                                            <input type="submit" name="submit" value="change profile image" />
                                         </form>  
                                        <?php } ?>
                                        <?php
                                        echo 'User Name :  ' . $row['user_name'] ;
                                        echo '<br/>';
                                        echo 'Registered on : ' . $row['user_date'];
                                        echo '<br/>';
                                        echo 'No of Topics : '. $row['no_of_Topics'];
                                        echo '<br/>';
                                        echo '<a href="userpost.php?id='.$row['id'].' & name='.$row['user_name'].'">No of posts  : ' . $row['no_of_Postss'];
                                        echo '<br/>';
                                            if((($row['no_of_Topics'])<2) && (($row['no_of_Postss'])<2))
                                                {
                                                    echo 'User Level:Techn00b';
                                                }
                                            if(((($row['no_of_Topics'])>2) && (($row['no_of_Topics'])<4)) && ((($row['no_of_Posts'])>2) && (($row['no_of_Posts'])<4)))
                                                {
                                                    echo 'User Level:Technear';
                                                }
                                            if((($row['no_of_Topics'])>6) && (($row['no_of_Posts'])>6))
                                                {
                                                 echo 'User Level:Technocrats';
                                                }
                                        echo '</td>';
                                        echo '<td>';
                                            if($row['level']==0)
                                            {
                                                echo 'User';
                                            }
                                            if($row['level']==1)
                                            {
                                                 echo 'Moderator';
                                            }
                                            if ($row['level']==2)
                                            {
                                                echo 'Admin';
                                            }
                                        echo '</td>';
                                        echo '</tr>';
                        
                }
        }
}

include 'footer.php';
?>
