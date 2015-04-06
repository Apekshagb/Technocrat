
<?php
//create_cat.php

include 'connect.php';
include 'header.php';


$user_name=$_SESSION['user_name'];

$id=mysql_real_escape_string($_GET['id']);

$posts_sql = "SELECT
							
									users4.count
									FROM
										
									users4
								
									WHERE
										 users4.user_name='$user_name'";
								
							$posts_result = mysql_query($posts_sql);
	
							$posts_row = mysql_fetch_assoc($posts_result);
                            if(($posts_row['count'])<3) 
											{

												//echo $row['count'];
												$image_post=1;
												//echo 'User Level:Technon00b';
											}
											if((($posts_row['count'])>2) && (($posts_row['count'])<6)) 
											{
												//echo 'User Level:TechAvg';
												$image_post=3;
											}
											if(($posts_row['count'])>5) 
											{
												//echo 'User Level:Technocrat';
												$image_post=5;
											}

										
?>

<ol class="breadcrumb">
  <li><a href="index.php">Home</a></li>
  <li><a href="category.php?id=<?php echo $_GET['catid'] ?>"><?php echo $_GET['catname']?></a></li>
  
</ol>


<script>       

		//alert('Success1');                         
                var nposts= <?php echo $image_post; ?>;
                $(document).ready(function(){
	                //alert('Success1');      
	                $('#avatar_update').change(function()
	                {  
		                //alert(this.files.length);
		                    if(this.files.length>nposts)
		                     {
			                    alert('to many files');

			                     this.value = '';
		                    }
		                    else
		                    {
		                    	alert('Success');
		                    }
                });
            });
        </script>   


<?php



if((is_numeric($_GET['id'])) || (is_numeric($_GET['catid'])))
{
		$sql = "SELECT
					topic_id,
					topic_subject,
					freeze,
					rac_id
				FROM
					topics4
				WHERE
					topics4.topic_id = " . mysql_real_escape_string($_GET['id']);
					
		$result = mysql_query($sql);

		if(!$result)
		{
			echo 'The topic could not be displayed, please try again later.';
		}
		else
		{
			if(mysql_num_rows($result) == 0)
			{
				echo 'This topic doesn&prime;t exist.';
			}
			else
			{
				
				while($row = mysql_fetch_assoc($result))
				{

					if($row['rac_id']==1)
						{
		              	 echo 'This thread is been deleted .....!!!!!';
						}
					else
					{
							echo '<table class="topic" border="1">
									<tr>
										<th colspan="1">' . $row['topic_subject'] . '</th>
										<th>Post</th>
										<th>Last Edited </th>
										<th></th>

									</tr>';
						
							//fetch the posts3 from the database
							$posts_sql = "SELECT
										posts4.post_id as postid,
										posts4.post_topic as id,
										posts4.post_content,
										posts4.post_date,
										posts4.post_by as post_by,
										posts4.edited_on,
										posts4.rac_id,
										posts4.image_id,
										users4.user_id,
										users4.user_name,
										users4.count
									FROM
										posts4
									LEFT JOIN
										users4
									ON
										posts4.post_by = users4.user_id
									WHERE
										posts4.post_topic = " . mysql_real_escape_string($_GET['id']);
										
							$posts_result = mysql_query($posts_sql);
							
						if(!$posts_result)
						{
							echo '<tr><td>The posts could not be displayed, please try again later.</tr></td></table>';
						}
					else
					{
					
							while($posts_row = mysql_fetch_assoc($posts_result))
							{

								$username=$posts_row['user_name'];
							   	$avatar="SELECT avatar_id from images4 where image_username='$username'";

									$avatar_result=mysql_query($avatar);
									$avatar_row=mysql_fetch_assoc($avatar_result);
								echo '<tr class="topic-post">';
								    
										echo '<td class="user-post">';
										

						    	         	if($avatar_row['avatar_id'])
		                                        {

			                                        if($_SESSION['signed_in'] == true)
				                                        {
				                                           echo '<a href="./images/'.$avatar_row['avatar_id'].'" target="_blank"><img src="./images/'.$avatar_row['avatar_id'].'" height=100px width=100px>';
				                                           echo '</a><br/>'; 
				                                        }
				                                        else
				                                        {
				                                        	echo '<a href="signin.php" ><img src="./images/'.$avatar_row['avatar_id'].'" height=100px width=100px>';
			                                           		echo '</a><br/>';
				                                        }
		                                    	}
		                                        else
		                                        {
		                                            echo '<a href="./images/default.jpg" target="_blank"><img src="./images/default.jpg" height=100px width=100px>';
		                                            echo '</a><br/>';
		                                        }
											echo ' <a href="profile.php?name='. $posts_row['user_name'].'">User : ' . $posts_row['user_name'] . '</a><br/> Posted on : '. date('d-m-Y H:i', strtotime($posts_row['post_date'])) . '<br/> ';
				                             if(($posts_row['count'])<3) 
											{
												//echo $row['count'];
												echo 'User Level:Technon00b';
											}
											if((($posts_row['count'])>2) && (($posts_row['count'])<6)) 
											{
												echo 'User Level:TechAvg';
											}
											if(($posts_row['count'])>5) 
											{
												echo 'User Level:Technocrat';
											}
									    

										echo '</td>';
									

	                                   echo '<td class="post-content">' ;

	                                   $image_display=explode("|",$posts_row['image_id']);
	                                   $image_count=count($image_display);

	                                    if($_SESSION['signed_in'] == true)
				                         {
			                                   for($i=0;$i<$image_count-1;$i++)
			                                   {
			                                   		echo '<a href="./images/'.$image_display[$i].'" target="_blank"><img src="./images/'.$image_display[$i].'" height=100px width=100px>';
				                                    echo '</a>'; 
			                                   }
			                                   echo '<br>';
			                             }
			                             else
			                             {

			                             	for($i=0;$i<$image_count-1;$i++)
			                                   {
			                                   		echo '<a href="signin.php" ><img src="./images/'.$image_display[$i].'" height=100px width=100px>';
				                                    echo '</a>'; 
			                                   }
			                                   echo '<br>';
			                             }
	                                  	/*if($posts_row['image_id'])
		                                        {
		                                           echo '<a href="./images/'.$posts_row['image_id'].'" target="_blank"><img src="./images/'.$posts_row['image_id'].'" height=100px width=100px>';
		                                           echo '</a><br/>'; 
		                                        }*/
										echo  htmlentities(stripslashes($posts_row['post_content'])) . '</td>';
									  
			                    	echo '<td>';
			                    	if(($posts_row['post_date']) > ($posts_row['edited_on']==0))
											{
					                        echo 'Edited By :'.$posts_row['user_name'];
											echo '<br>';
											echo 'Edited On :'.$posts_row['edited_on'];
											
											}
								
											
							    echo '</td>';
			                    echo '<td>';
			                    
									if((($_SESSION['user_id'] ) == $posts_row['post_by']) || (($_SESSION['user_level']) == 2))
									{
									echo '<a href="edit_post.php?post='.htmlentities(stripslashes($posts_row ['post_content'])) .'&id='.htmlentities($posts_row ['id']) .'&pid='.htmlentities($posts_row ['postid']) .'"><input type="submit" value="EDIT" /></a>';
							        echo '<a href="delete_post.php?pid='.htmlentities($posts_row ['postid']) .'&id='.htmlentities($posts_row ['id']) .'"><input type="submit" value="DELETE" /></a>';
							        }
							      
							       echo '</td>';


								echo '</tr>';
							}
					}
					
					if(!$_SESSION['signed_in'])
					{
						echo '<tr><td colspan=3>You must be <a href="signin.php">signed in</a> to reply. You can also <a href="signup.php">sign up</a> for an account.';
					}
					else
					{
						//show reply box
						
						echo '<tr><td colspan="4"><h2>Reply:</h2><br />
							<form method="post" action="reply.php?id=' . htmlentities($row['topic_id']) . '&freeze='.htmlentities($row['freeze']).'&catid='.mysql_real_escape_string($_GET['catid']).'&user_name='. $user_name.'" enctype="multipart/form-data">
								<textarea name="reply-content"></textarea><br /><br />';
						?>
						<input class="au2" type="file" name="avatar_update[]" id="avatar_update" accept="image/jpeg,image/jpg,image/png,image/gif" multiple />
                        <input type="hidden" name="image_username" value="<?php echo $row['user_name'];?>"><br>
                       
					<?php
		                     echo '<input type="submit" value="Submit reply" />
							</form></td></tr>';
					}
					
					//finish the table
					echo '</table>';
				}
			  }
			}
		}
		
	}
	else
	{
		echo "You do not have the rights to visit the site.....";
	}

include 'footer.php';
?>

