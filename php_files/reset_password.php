<?php


include 'connect.php';
include 'header.php';

echo '<h3>RESET PASSWORD</h3><br/>';

$id=is_numeric($_GET['id']);

if($id)
{

	if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			echo '<form method="post" action="">
			E-mail: <input type="email" name="user_email"><br />
			New Password: <input type="password" name="user_pass"><br />
			Password again: <input type="password" name="user_pass_check"><br />
			<input type="submit" value="Reset" />
			</form>';
		}

		else
		{
			$errors = array();
			if (empty($_POST['user_email']))  
				{
		        	$error[] = 'Please Enter your Email ';
		    	} 
			else 
		    	{

					if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",
		        	$_POST['usre_email'])) 
		            		{
		            		//regular expression for email validation
		            			$Email = $_POST['user_email'];
		       				} 
		       		else 
		       				{
		           				$error[] = 'Your EMail Address is invalid  ';
		        			}
		 
		   	    }

		    if(isset($_POST['user_pass']))
				{
					if($_POST['user_pass'] != $_POST['user_pass_check'])
					{
						$errors[] = 'The two passwords did not match.';
					}
				}
			else
				{
					$errors[] = 'The password field cannot be empty.';
				}


		    $user_email=htmlspecialchars($_POST['user_email']);
			$user_password=md5(htmlspecialchars($_POST['user_pass']));

			$confirmmessage= "<html><a href=\"https://weiglevm.cs.odu.edu/~abarhanp/proj3/signin.php" .
			 "?id=1\">Reset Password</a>";


			$pass_confirmation="update users4 set user_pass='$user_password' where user_email='$user_email'";

			$sql_user_confirm=mysql_query($pass_confirmation) ;
			
	        $to=$user_email;
		
			$from="technochart";
			$subject="Password Reset Comfirmation";
			$message="Your password is now been reset ..you can now Login ..!!!!!";
			$message .= $confirmmessage. "\n";
			$header="From: ".$from."\r\n";

			$mailsent=mail($to,$from,$message,$header);

			if($mailsent)
				{
					echo "successful";
				}
			else
				{
				echo "mail failed";
				}
		}
	}
	else
	{
		echo  "You do not have the rights to visit the site.....";
	}
	
include 'footer.php';
?>
