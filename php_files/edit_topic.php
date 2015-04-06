<?php



include 'connect.php';
include 'header.php';


$topic=mysql_real_escape_string($_GET['post']);
$id=$_GET['id'];
$cid=$_GET['cid'];
//$racid=$_GET['racid'];
//echo $racid;

// if(is_numeric($_GET['racid']))
// {
		echo '<h2>EDIT TOPIC</h2>';

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


		        $post=mysql_real_escape_string($_POST['edit-content']);
				//a real user posted a real reply
		        if($_SERVER['REQUEST_METHOD'] == 'POST')
		        	{
		        		$sql="SELECT rac_id from topics4 where topic_id='$id'";

		        		$result = mysql_query($sql);

		        		while($row=mysql_fetch_assoc($result))
		        		{
							if($row['rac_id']==1)
								{
									echo  'This thread no longer exists .....!!!!!';
								}
								else
								{
									$sql = "UPDATE topics4 set topic_subject='$post',edited_on=now() where topic_subject='$topic'";
								
									$result = mysql_query($sql);
								
									if(!$result)
									{
										echo 'Your reply has not been saved, please try again later.';
									}
									else
									{
										echo 'Updated Successfully.....<a href="category.php?id=' .$cid . '">Topics</a>';
									}
								}
					    }
			   	   }

				
			

			}

		}
	// }
	// else
	// {
	// 	echo "You do not have the rights to visit the site.....";
	// }



include 'footer.php';
?>
