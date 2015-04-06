<?php



include 'connect.php';
include 'header.php';


$activation_id=$_GET['id'];
//echo $activation_id;


	
			$sql_confirmation="update users4 set activation_id=1 where activation='$activation_id'";
			$sql_user_confirm=mysql_query($sql_confirmation) ;
			$user_details="select user_email from users4 where activation='$activation_id'";
			$execute_user_details=mysql_query($user_details) ;

			$user_email_fetch= mysql_fetch_assoc($execute_user_details);
			$user_email=$user_email_fetch['user_email'];

			$confirmmessage= "<html><a href=\"https://weiglevm.cs.odu.edu/~abarhanp/project4/signin.php" .
					 "?id=1\">Login</a>";

			$to=$user_email;
			//echo $to;
			$from="technochart";
			$subject="new user registration";
			$message="Thank you for completing the registration.You can now Login to access the forum page";
			$header="From: ".$from."\r\n";

			$mailsent=mail($to,$from,$message,$header);

			if($mailsent)
				{
					echo "successful.......";
					echo '<a href="signin.php">Login</a>';
				}
			else
				{
					echo "mail failed";
				}
		

include 'footer.php';
?>
