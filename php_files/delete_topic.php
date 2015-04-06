<?php

include 'connect.php';
include 'header.php';


//$pid=mysql_real_escape_string($_GET['pid']);
$id=$_GET['id'];
$cid=$_GET['cid'];

if(is_numeric($_GET['id']))
{
	if($_SESSION['suspend'] == 1)
		{
			echo 'You are suspended ....Hence cannot edit or delete the post';
		}
	else
	{
		$sql = "UPDATE  topics4 set  rac_id=1  where topic_id='$id'";
							
			$result = mysql_query($sql);
							
			if(!$result)
			{
				echo 'Your reply has not been saved, please try again later.';
			}
			else
			{
				echo 'Deleted Successfully.....<a href="category.php?id=' .$cid . '">Topics</a>';
			}

 	}
 }
 else
 {
 	echo "You do not have the rights to visit the site.....";
 }

include 'footer.php';
?>
