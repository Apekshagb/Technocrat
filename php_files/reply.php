<?php
//create_cat.php

include 'connect.php';
include 'header.php';

$freeze=$_REQUEST['freeze'];
$cid=$_REQUEST['catid'];

$content=$_REQUEST['reply-content'];
$content=trim($content);
$user_id=$_SESSION['user_id'];
$topic_id=$_REQUEST['id'];
$user_name=$_POST['user_name'];

// if(is_numeric($_GET['freeze']))
// {
       
		if($_SERVER['REQUEST_METHOD'] != 'POST')
			{
			//someone is calling the file directly, which we don't want
				echo 'This file cannot be called directly.';
			}
		else
			{
			//check for sign in status

				if(!$_SESSION['signed_in'])
					{
						echo 'You must be signed in to post a reply.';
					}
				
				if($content=="")
				    {
				        echo "<script>alert('Cannot enter blank message');</script>";
				        header('refresh:0,topic.php?id='.htmlentities($_GET['id']).'');
				    }

				 $sql="SELECT freeze,topic_id
                          from topics4
                           where topic_id='$topic_id'";

                    	$result = mysql_query($sql);
                   		$row = mysql_fetch_assoc($result);
                    
				if($row['freeze']==1)
					{
						echo 'This topic is been freezed you can no more posts comments on it...!!!!<a href="category.php?id=' .$cid . '">Topics</a>';
					}

				else
				{
					//a real user posted a real reply
                    $sql="SELECT suspend,user_id
                          from users4
                           where user_id='$user_id'";

                    $result = mysql_query($sql);
                    $row = mysql_fetch_assoc($result);
                    
						if($row['suspend']==1)
							{
								echo 'Your account is been suspended ...You cannot post any messages';
							}
						else
						{
							//echo $row['suspend'];
							
							$image_array="";
							$image_count=count($_FILES['avatar_update']['tmp_name']);
							/*for($i=0;$i<$image_count;$i++)
							{
								$image_array.=$_FILES['avatar_update']['name'][$i].'|';
							}*/
							$image_username = $_POST['user_name'];
							//$image_tempname = $_FILES['avatar_update']['name'];
							echo $image_count;
							if($_FILES['avatar_update']['tmp_name'][0])
							{

								$today = date("m-d-Y");
								

								//upload image and check for image type
								//make sure to change your path to match your images directory
								


								$ImageDir ="/home/abarhanp/cs418_html/project4/images/";

								for($i=0;$i<$image_count;$i++)
								{
									$id=uniqid();
									echo $_FILES['avatar_update']['name'][$i];
									$image_tempname=$_FILES['avatar_update']['name'][$i];
									$ImageName = $ImageDir . $id . $image_tempname;
									$image_array.=$id.$image_tempname.'|';
									if (move_uploaded_file($_FILES['avatar_update']['tmp_name'][$i], $ImageName))
								 	{
								   // echo "hhhiii";

								  //get info about the image being uploaded
									        list($width, $height, $type, $attr) = getimagesize($ImageName);

									        switch ($type) 
									        {
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
									            
									        }
									     }
									     else
										 {
											echo "Sorry, but the file you uploaded was not a GIF, JPG, or " .
									                 "PNG file.<br>";
									         echo "Please hit your browser's 'back' button and try again.";
										 }

								}

								}
								//echo $ImageName;

								/*if (move_uploaded_file($_FILES['avatar_update']['tmp_name'], $ImageName))
								 {*/
								   // echo "hhhiii";

								  //get info about the image being uploaded
									      /*  list($width, $height, $type, $attr) = getimagesize($ImageName);

									        switch ($type) 
									        {
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
									            
									        }*/

									      
									//}

									/*else
										 {
											echo "Sorry, but the file you uploaded was not a GIF, JPG, or " .
									                 "PNG file.<br>";
									         echo "Please hit your browser's 'back' button and try again.";
										 }*/
								//}

								   //insert info into image table
									        $sql = "INSERT INTO 
										posts4(post_content,
											  post_date,
											  post_topic,
											  post_by,image_id) 
									VALUES ('" . $_POST['reply-content'] . "',
											NOW(),
											" . mysql_real_escape_string($_GET['id']) . ",
											" . $_SESSION['user_id'] . ",'".$image_array."')";
											
										 $result = mysql_query($sql);

										 if(!$result)
											{
												echo 'Your reply has not been saved, please try again later.';
											}
										else
											{
												echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
											}
									
							 		
											
							
						}
				}
		}
// }
// 	else
// 	{
// 		echo echo "You do not have the rights to visit the site.....";
// 	}
	

include 'footer.php';
?>
