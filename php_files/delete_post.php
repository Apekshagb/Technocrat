<?php



include 'connect.php';
include 'header.php';


$pid=$_GET['pid'];
$id=$_GET['id'];

if(is_numeric($_GET['pid']))
{
	if($_SESSION['suspend'] == 1)
			{
				echo 'Your suspended ....Hence cannot edit or delete the post';
			}
		else
		{
			$sql = "UPDATE  posts4 set  rac_id=1   where post_id='$pid'";
							
			$result = mysql_query($sql);
							
			if(!$result)
			{
				echo 'Your reply has not been saved, please try again later.';
			}
			else
			{
				echo 'Deleted Successfully.....<a href="topic.php?id=' .$id . '">Topics</a>';
			}
		}
}
else
{
	echo "You do not have the rights to visit the site.....";
}

include 'footer.php';
?>
