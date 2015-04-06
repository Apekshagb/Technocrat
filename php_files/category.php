<?php
//category.php


include 'connect.php';
include 'header.php';
?>
<?php


$p = 1;

if(isset($_GET['p']))
{

	$p = $_GET['p'];

}


//$id=is_numeric($_GET['id']);
//first select the category based on $_GET['cat_id']
if(is_numeric($_GET['id'])||is_numeric($p))
{
$sql = "SELECT
			cat_id,
			cat_name,
			cat_description
		FROM
			categories4
		WHERE
			cat_id = " . mysql_real_escape_string($_GET['id']);

$result = mysql_query($sql);




if(!$result)
{
	echo 'The category could not be displayed, please try again later.' . mysql_error();
}
else
{
	if(mysql_num_rows($result) == 0)
	{
		echo 'This category does not exist.';
	}
	else
	{
		//display category data
		while($row1 = mysql_fetch_assoc($result))
		{
			echo '<h2>topics in &prime;' . $row1['cat_name'] . '&prime; category</h2><br />';
		}

		$id = mysql_real_escape_string($_GET['id']);

		$sql_row_count = "SELECT	
					topic_id,
					topic_subject,
					topic_date,
					topic_cat,
					topic_by,
					edited_on,
					freeze,
					rac_id,
					users3.user_name,
					users3.user_id,
					users3.count
				FROM
					topics4
				LEFT join
				     users4
				ON topics3.topic_by=users3.user_id
				WHERE
					topic_cat =  '$id' ";
		//do a query for the topics3
		$result = mysql_query($sql_row_count);

		$row_count = mysql_num_rows($result);


		//echo "".$row_count."";

		// if(!isset($_GET['start_page']))


		$start_page = $p;
		//echo $start_page;
		$offset = 5;
			//echo $offset;

		 //$cur_page = $start_page . " , " . $offset; 

		$sql = "SELECT	
					topic_id,
					topic_subject,
					topic_date,
					topic_cat,
					topic_by,
					edited_on,
					freeze,
					rac_id,
					users4.user_name,
					users4.user_id,
					users4.count
				FROM
					topics4
				LEFT join
				     users4
				ON topics4.topic_by=users4.user_id
				WHERE
					topic_cat =  '$id'  LIMIT ".($start_page*2-2).",".$offset;
		
		$result = mysql_query($sql);

		
		

		if(!$result)
		{
			echo 'The topics could not be displayed, please try again later.';
		}
		else
		{
			if(mysql_num_rows($result) == 0)
			{
				echo 'There are no topics in this category yet.';
			}
			else
			{
				//prepare the table
				echo '<table class="topic" border="1" >
					  <tr>
					  <th>User</th>
						<th>Topic</th>
						<th>Created On</th>
						<th>Last Edited On</th>
						<th></th>
						
					  </tr>';	
					
				while($row = mysql_fetch_assoc($result))
				{		

					$username=$row['user_name'];
				   	$avatar="SELECT avatar_id from images4 where image_username='$username'";

						$avatar_result=mysql_query($avatar);
						$avatar_row=mysql_fetch_assoc($avatar_result);

						echo '<tr width="100%">';
						echo '<td class="leftpart">';
					
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

							echo '<a href="profile.php?name='.$row['user_name'].'"> Created By : '.$row['user_name'].'</a>';
							echo '<br>';
							if(($row['count'])<3) 
							{
								echo 'User Level:Technon00b';
							}
							if((($row['count'])>2) && (($row['count'])<6)) 
							{
								echo 'User Level:TechAvg';
							}
							if(($row['count'])>5) 
							{
								echo 'User Level:Technocrat';
							}
						
					
						echo '</td>';
						echo '<td>';
						echo '<h3> TOPIC: <a href="topic.php?id=' . $row['topic_id'] . '&catid='.$_GET['id'].'&catname='.$_GET['catname'].'">' . $row['topic_subject'] . '</a><h3>';
							
						echo '</td>';
						echo '<td class="rightpart">';
					
						echo date('d-m-Y', strtotime($row['topic_date']));
					
						echo '</td>';
						echo '<td>';
						
							if(($row['topic_date']) > ($row['edited_on']==0))
								{
			                        echo 'Edited By :'.$row['user_name'];
									echo '<br>';
									echo 'Edited On :'.$row['edited_on'];
									if(($row['count'])<3) 
							{
								echo 'User Level:Technon00b';
							}
							if((($row['count'])>2) && (($row['count'])<6)) 
							{
								echo 'User Level:TechAvg';
							}
							if(($row['count'])>5) 
							{
								echo 'User Level:Technocrat';
							}
						
								}
					
						echo '</td>';
						echo '<td>';

						
							if((($_SESSION['user_id'] ) == $row['topic_by']) || (($_SESSION['user_level'])== 2) || (($_SESSION['user_level'])== 1))
								{
						
						
									echo '<a href="edit_topic.php?post='.mysql_real_escape_string($row ['topic_subject']) .'&id='.htmlentities($row ['topic_id']) .'&cid='.mysql_real_escape_string($_GET['id']).'&racid='.htmlentities($row ['rac_id']).'"><input type="submit" value="EDIT" /></a>';
							        echo '<a href="delete_topic.php?id='.htmlentities($row['topic_id']) .'&cid='.mysql_real_escape_string($_GET['id']) .'"><input type="submit" value="DELETE" /></a>';
				   	    		}
				        
					       if(($_SESSION['user_level'])== 2 || ($_SESSION['user_level'])== 1)
	                        {
	                        	if($row['freeze']==0)
	                        	{
	                        	 echo '<a href="freeze.php?id='.htmlentities($row ['topic_id']) .'&cid='.mysql_real_escape_string($_GET['id']) .'"><input type="submit" value="FREEZE" /></a>';
	                        	}
	                        	if($row['freeze']==1)
	                        	{
	                        	 echo '<a href="unfreeze.php?id='.htmlentities($row ['topic_id']) .'&cid='.mysql_real_escape_string($_GET['id']) .'"><input type="submit" value="UNFREEZE" /></a>';
	                        	}
	                        }
	                    
				       echo '</td>';
					echo '</tr>';
				 ?>

					

				 <?php
			   }
			}
		}


function MakePagination($CurPage, $NumPages, $FormatString, $CurPageFormatString, $MaxOthers = 3)
{
	global $start_page;
	$str = '';
	
	$start = max($CurPage - $MaxOthers, 1);
	for ($i = $start; $i <= $NumPages && $i <= $start + ($MaxOthers * 2); $i++)
	{
		if ($i > $start)
			$str .= ' ';
		$str .= sprintf($i == $CurPage ? $CurPageFormatString : $FormatString, $i, $i);
	}
	
	return $str;
}

			$page = basename(__FILE__);

			$cPage = @$p ?: 1;
			//$start_page=$cPage;
			$nPages = ceil($row_count/5);

			echo "<a href='$page?id=".$_GET['id']."&p=1'>&laquo;</a> ";
			echo "<a href='$page?id=".$_GET['id']."&p=" . ($cPage - 1) . "'>&lsaquo;</a> ";
			echo MakePagination($cPage, $nPages, "<a href='$page?id=".$_GET['id']."&p=%d'>%d</a>", "<strong>%d</strong>");
			echo " <a href='$page?id=".$_GET['id']."&p=" . ($cPage + 1) . "'>&rsaquo;</a>";
			echo " <a href='$page?id=".$_GET['id']."&p=" . ($nPages - 1) . "'>&raquo;</a>";


	}
}
}
else
{
	echo "You do not have the rights to visit the site.....";
}

include 'footer.php';
?>
