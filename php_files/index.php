<?php
//create_cat.php

include 'connect.php';
include 'header.php';



$sql = "SELECT
			categories4.cat_id,
			categories4.cat_name,
			categories4.cat_description,
			COUNT(topics4.topic_id) AS topics4
		FROM
			categories4
		LEFT JOIN
			topics4
		ON
			topics4.topic_cat = categories4.cat_id
		GROUP BY
			categories4.cat_name, categories4.cat_description, categories4.cat_id";

$result = mysql_query($sql);

if(!$result)
{
	echo 'The categories could not be displayed, please try again later.';
}
else
{
	if(mysql_num_rows($result) == 0)
	{
		echo 'No categories defined yet.';
	}
	else
	{
		//prepare the table
		echo '<table border=1>
			  <tr>
				<th>Category</th>
				<th>Last topic</th>
			  </tr>';	
			
		while($row = mysql_fetch_assoc($result))
		{	
					
			echo '<tr>';
			
				echo '<td>';
				echo '<h3><a href="category.php?id=' . $row['cat_id'] .'&catname='.$row['cat_name'].' ">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
				echo '</td>';
				
				echo '<td>';
				
				//fetch last topic for each cat
					$topicsql = "SELECT
									topic_id,
									topic_subject,
									topic_date,
									topic_cat
								FROM
									topics4
								WHERE
									topic_cat = " . $row['cat_id'] . "
								ORDER BY
									topic_date
								DESC
								LIMIT
									1";
								
					$topicsresult = mysql_query($topicsql);
				
					if(!$topicsresult)
					{
						echo 'Last topic could not be displayed.';
					}
					else
					{
						if(mysql_num_rows($topicsresult) == 0)
						{
							echo 'no topics';
						}
						else
						{
							while($topicrow = mysql_fetch_assoc($topicsresult))
							echo '<a href="topic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_subject'] . '</a> on ' . date('m-d-Y', strtotime($topicrow['topic_date']));
						}
					}
				echo '</td>';
			//echo '<hr size="30">';
			echo '</tr>';
		}	
	}
}

include 'footer.php';
?>
