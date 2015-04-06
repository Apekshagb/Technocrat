<?php
//create_cat.php

include 'connect.php';
include 'header.php';

$id=$_GET['id'];
$name=$_GET['name'];


$sql="SELECT topic_subject,post_content,post_date,user_name 
      FROM posts4,topics4,users4 
      WHERE post_by='$id' and post_topic=topic_id and user_id='$id'
      ORDER BY post_date";


$result = mysql_query($sql);

 if(!$result)
{
	echo ' No posts';
}
else
{

	echo '<table border="1">
                          <tr>
                                <th>TOPIC</th>
                                <th>POST</th>
                                <th>POST_DATE</th>
                                <th>POSTED BY</th>
                                
                          </tr>';  
	while($row = mysql_fetch_assoc($result))
 
 	{
 		echo '<tr>';
 			echo '<td>';
 				echo $row['topic_subject'];
 			echo '</td>';
 			echo '<td>';
 				echo $row['post_content'];
 			echo '</td>';
 			echo '<td>';
 				echo $row['post_date'];
 			echo '</td>';
 			echo '<td>';
 				echo $row['user_name'];
 			echo '</td>';
 	}

 }

include 'footer.php';
?>
