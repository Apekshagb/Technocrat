<?php

include 'connect.php';
include 'header.php';

$name=mysql_real_escape_string($_GET['name']);
$email=mysql_real_escape_string($_GET['email']);

		$to=$email;
		$from="technocrat";
		$subject="Account Suspended";


$sql = "UPDATE users4 set suspend=0 where user_name='$name'";
$suspend_user=mysql_query($sql) or  die("deletion failed".$mysqli_error);
						
		$result = mysql_query($sql);
						
		if(!$result)
		{
			echo 'Your reply has not been saved, please try again later.';
		}
		else
		{
			echo 'User UnSuspended.....<a href="user_profile.php">User Profile</a>';
		}

			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
			$headers .= "From: no-reply@technocrat.com";
			$message =  " Your Account has been UnSuspended......!!!!! You can now create and edit posts\n";
		

			 
			$mailsent=mail($to,$from,$message,$headers);
			if($mailsent)
			{

			echo '<br>';
			echo 'Mail Sent';
			}
			else
			{
			echo "error in sending e-mail";
			}

include 'footer.php';
?>
