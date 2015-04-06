<?php



include 'connect.php';
include 'header.php';


$topic=mysql_real_escape_string($_GET['post']);
$pid=$_GET['pid'];
$id=$_GET['id'];

//echo $pid;
echo '<h2>EDIT POST</h2>';

    if($_SESSION['suspend'] == 1)
			{
				echo 'Your suspended ....Hence cannot edit or delete the post';
			}
		else
		{
			if($_SERVER['REQUEST_METHOD'] != 'POST')
			{
				echo '<tr><td colspan="3"><br />
					 <form method="post" action=" ">
					 <textarea name="edit-content">'.$topic.'</textarea><br /><br />
					 <input type="submit" value="Edit reply" />
					 </form></td></tr>';

			}
			else
			{


			        $post=$_POST['edit-content'];
					//a real user posted a real reply
					 if($_SERVER['REQUEST_METHOD'] == 'POST')
					        	{
					        		$sql="SELECT rac_id from posts4 where post_id='$pid'";

					        		$result = mysql_query($sql);

					        		while($row=mysql_fetch_assoc($result))
					        		{
					        			//echo $row['rac_id'];
										if($row['rac_id']==1)
											{

												echo  'This Post no longer exists .....!!!!!';
											}
											else
											{
												$sql = "UPDATE posts4 set post_content='$post',edited_on=now() where post_content='$topic'";
																
												$result = mysql_query($sql);
																
												if(!$result)
												{
													echo 'Your reply has not been saved, please try again later.';
												}
												else
												{
													echo 'Updated Successfully.....<a href="topic.php?id=' .$id . '">Topics</a>';
												}
											}
				

			                        }
			                    }
			          }
           }


include 'footer.php';
?>
