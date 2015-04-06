<?php
//create_topic.php


include 'connect.php';
include 'header.php';

$user_id=$_SESSION['user_id'];

echo '<h2>Create a topic</h2>';
if($_SESSION['signed_in'] == false  )
{
	//the user is not signed in
	echo 'Sorry, you have to be <a href="signin.php">signed in</a> to create a topic.';
}
else
{
	//the user is signed in
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{	

		$sql="SELECT suspend,user_id
                from users4
                where user_id='$user_id'";

        $result = mysql_query($sql);

        $row = mysql_fetch_assoc($result);
                    
		if($row['suspend']==1)
		{
			echo 'Your account is been suspended ...You cannot create a topic';
		}
		else
		{
			$sql = "SELECT
					cat_id,
					cat_name,
					cat_description
				FROM
					categories4";
		
			$result = mysql_query($sql);
		
			if(!$result)
				{
			//the query failed, uh-oh :-(
					echo 'Error while selecting from database. Please try again later.';
				}
			else
				{
					if(mysql_num_rows($result) == 0)
						{
							//there are no categories3, so a topic can't be posted
							if($_SESSION['user_level'] == 2)
							{
								echo 'You have not created categories yet.';
							}
							else
							{
								echo 'Before you can post a topic, you must wait for an admin to create some categories.';
							}
						}
					else
						{
					
							echo '<form method="post" action="">
								Subject: <input type="text" name="topic_subject" /><br />
								Category:'; 
							
							echo '<select name="topic_cat">';
								while($row = mysql_fetch_assoc($result))
								{
									echo '<option value="' . $row['cat_id']. '">' . mysql_real_escape_string($row['cat_name']) . '</option>';
								}
							echo '</select><br />';	
								
							echo 'Message: <br /><textarea name="post_content" /></textarea><br /><br />
								<input type="submit" value="Create topic" />
							 </form>';
						}
				}
	}
}
	else
	{
		//start the transaction
		$query  = "BEGIN WORK;";
		$result = mysql_query($query);
		
		if(!$result)
		{
			//Damn! the query failed, quit
			echo 'An error occured while creating your topic. Please try again later.';
		}
		else
		{
	
			//the form has been posted, so save it
			//insert the topic into the topics3 table first, then we'll save the post into the posts3 table
			$sql = "INSERT INTO 
						topics4(topic_subject,
							   topic_date,
							   topic_cat,
							   topic_by)
				   VALUES('" . mysql_real_escape_string($_POST['topic_subject']) . "',
							   NOW(),
							   " . mysql_real_escape_string($_POST['topic_cat']) . ",
							   " . $_SESSION['user_id'] . "
							   )";
					 
			$result = mysql_query($sql);
			if(!$result)
			{
				//something went wrong, display the error
				echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
				$sql = "ROLLBACK;";
				$result = mysql_query($sql);
			}
			else
			{
				//the first query worked, now start the second, posts3 query
				//retrieve the id of the freshly created topic for usage in the posts3 query
				$topicid = mysql_insert_id();
				
				$sql = "INSERT INTO
							posts4(post_content,
								  post_date,
								  post_topic,
								  post_by)
						VALUES
							('" . mysql_real_escape_string($_POST['post_content']) . "',
								  NOW(),
								  " . $topicid . ",
								  " . $_SESSION['user_id'] . "
							)";
				$result = mysql_query($sql);
				
				if(!$result)
				{
					//something went wrong, display the error
					echo 'An error occured while inserting your post. Please try again later.<br /><br />' . mysql_error();
					$sql = "ROLLBACK;";
					$result = mysql_query($sql);
				}
				else
				{
                    $user=$_SESSION['user_id'];
					$sqlcount="SELECT count(topic_by) as topic_count,topic_by,topic_id from topics4 
						       WHERE topic_by='$user'
						       group by topic_by";
                          
                          $result1 = mysql_query($sqlcount);

						  while($row2 = mysql_fetch_assoc($result1))
						 	{
                                $count=$row2['topic_count'];
                                //echo $count;
						 	}

					 
					 		$sqluser="UPDATE users3 set count='$count' where user_id='$user'";

					 		$result2 = mysql_query($sqluser);
						 	
					 	
						$sql = "COMMIT;";
						$result = mysql_query($sql);
					
						//after a lot of work, the query succeeded!
						echo 'You have succesfully created <a href="topic.php?id='.$topicid . '">your new topic</a>.';
				}
			}
		}
	}
}

include 'footer.php';
?>
