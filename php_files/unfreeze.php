<?php

include 'connect.php';
include 'header.php';

$id=$_GET['id'];
$cid=$_GET['cid'];


if(is_numeric($_GET['id']))
{
	$sql = "UPDATE topics4 set freeze=0 where topic_id='$id'";
	$suspend_user=mysql_query($sql) or  die("deletion failed".$mysqli_error);
							
			$result = mysql_query($sql);
							
			if(!$result)
			{
				echo 'Your reply has not been saved, please try again later.';
			}
			else
			{
				echo 'Topic is been unfreezed .....<a href="category.php?id=' .$cid . '">Topics</a>';
			}
}
else
{
	echo "You do not have the rights to visit the site.....";
}

			
include 'footer.php';
?>
