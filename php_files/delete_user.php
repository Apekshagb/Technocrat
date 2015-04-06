<?php


include 'connect.php';
include 'header.php';

$name=mysql_real_escape_string($_GET['name']);
$email=mysql_real_escape_string($_GET['email']);
//echo $name;
//echo $email;

        $to=$email;
		$from="technocrat";
		$subject="Account Deleted";

$sql="DELETE from users4 where user_name='$name'";

 $delete_user=mysql_query($sql) or  die("deletion failed".$mysqli_error);

		

		//$boundary = "==MP_Bound_xyccr948x==";

			
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
			$headers .= "From: no-reply@technocrat.com";
			$message =  " Your Account has been deleted because you violated the forum laws.\n";
		

			 
			$mailsent=mail($to,$from,$message,$headers);
			if($mailsent)
			{

			echo 'User Deleted <a href="user_profile.php">User Profile</a>';
			}
			else
			{
			echo "error in sending e-mail";
			}

include 'footer.php';
?>
