<?php

include 'connect.php';
include 'header.php';


if(isset($_POST['update']) ){
	$var = $_POST['select'];
	$uid = $_POST['uid'];
	
	$update_query = "UPDATE users3 SET user_level = '" . $var . "' WHERE user_name = '" . $uid . "'";
	$update_result = mysql_query($update_query)
	or die(mysql_error());
}

$sql="SELECT tmp.id as topic_id,tmp.suspend as suspend,tmp.user_level as level,tmp.user_id as id,tmp.user_name as user_name, tmp.user_email as user_email, tmp.user_date as user_date, IFNULL(No_of_Topics,0) as no_of_Topics,  IFNULL(No_of_Posts,0) as no_of_Posts from 
(select * from users4 as u left join (select topics4.topic_by, count(topics4.topic_by) as No_of_Topics, topics4.topic_id as id from topics4 group by topics4.topic_by) as t on u.user_id = t.topic_by group by u.user_id) as tmp
left join (select posts4.post_by, count(posts4.post_by) as No_of_Posts from posts4 group by posts4.post_by) as p on p.post_by = tmp.user_id group by tmp.user_id ";

 $result = mysql_query($sql);

 if(!$result)
{
	echo 'Users could not be displayed.....';
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
				<th>LASTPOST</th>
				<th>FUNCTIONS</th>
			  </tr>';	
			
		while($row = mysql_fetch_assoc($result))
		{				
			echo '<tr>';
				echo '<td class="leftpart">';
				
					echo '<a href="profile.php?name='.$row['user_name'].'">User Name :  ' . $row['user_name'].'</a>';
					echo '<br/>';
					echo 'Registered on : ' . $row['user_date'];
					echo '<br/>';
					echo 'Email : ' . $row['user_email'];
					echo '<br/>';
					echo 'No of Topics : '. $row['no_of_Topics'];
					echo '<br/>';
					echo '<a href="userpost.php?id='.$row['id'].' & name='.$row['user_name'].'">No of posts  : ' . $row['no_of_Posts'].'</a>';
					echo '<br/>';
					if(($row['no_of_Topics'])<3) 
					{
						echo 'User Level:Techn00b';
					}
					if((($row['no_of_Topics'])>2) && (($row['no_of_Topics'])<6)) 
					{
						echo 'User Level:Technear';
					}
					if(($row['no_of_Topics'])>5) 
					{
						echo 'User Level:Technocrat';
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
				echo '<td class="rightpart">';
				$topic_id= $row['topic_id'];
				$user_id=$row['id'];
				
				//echo $topic_id;
				
				//fetch last topic for each cat
					$postsql = " SELECT post_date
					             FROM posts4
					             WHERE post_by ='$user_id'
					             ORDER BY post_date
					             DESC 
					             LIMIT 
					             1";
								
					$postsresult = mysql_query($postsql);
				
					if(!$postsresult)
					{
						echo 'Last post could not be displayed.';
					}
					else
					{
						if(mysql_num_rows($postsresult) == 0)
							{
								echo 'no posts';
					        }
					        else
					        {
					          while($row1=mysql_fetch_assoc($postsresult))	
					          	echo $row1['post_date'];
					        }		
				    }


						
					
				echo '</td>';
                //$username=mysql_real_escape_string($row['user_name']);
				echo '<td>';




				echo '<form id="role_update" action="'.  $_SERVER['PHP_SELF'] . '" method="POST">';
				if((($_SESSION['user_level']) == 1 ) && (($row['level'])==1) || (($row['level'])==2))

                {

				}
				else
				{
				echo '<select name="select" style="display:inline-block">';

				if($row['level'] == 0)
				{
                    
					echo '<option value="0" selected>User</option>';
					echo '<option value="1">Moderator</option>';
					echo '<option value="2">Administrator</option>';

				}
				if($row['level'] == 1)
				{

					echo '<option value="0" >User</option>';
					echo '<option value="1" selected>Moderator</option>';
					echo '<option value="2">Administrator</option>';

				}
				if($row['level'] == 2)
				{

					echo '<option value="0" >User</option>';
					echo '<option value="1">Moderator</option>';
					echo '<option value="2" selected>Administrator</option>';

				}

				echo '</select>';
				echo '<input type="submit" name="update" value="update" style="display:inline-block"/>';
				echo '<input type="hidden" name="uid" value="'.$row['user_name'].'" />';

				echo '</form>';
				// echo '<input type="submit" value="EDIT" />';
				echo '<a href="delete_user.php?name='. mysql_real_escape_string($row['user_name']).'&email='.mysql_real_escape_string($row['user_email']).'"><input type="submit" value="DELETE" /></a>';
				echo '<br/>';
				if($row['suspend']==0)
				{
				echo '<a href="suspend.php?name='.mysql_real_escape_string($row['user_name']).'&email='.mysql_real_escape_string($row['user_email']).'"><input type="submit" value="SUSPEND" />';
				}
				if($row['suspend']==1)
				{
				echo '<a href="unsuspend.php?name='.mysql_real_escape_string($row['user_name']).'&email='.mysql_real_escape_string($row['user_email']).'"><input type="submit" value="UNSUSPEND" />';
				}
				echo '<br/>';
			  }




				echo '</td>';
			echo '</tr>';
			
		}
	}
}

include 'footer.php';
?>
