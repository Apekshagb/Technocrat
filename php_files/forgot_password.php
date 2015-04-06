<?php



include 'connect.php';
include 'header.php';

echo '<h3>SUBMIT DETAILS TO RESET PASSWORD</h3><br />';

if(($_POST['forgot_pass'])==true)
{
	 echo '<form method="post" action="">
	 	E-mail: <input type="email" name="user_email"><br />
	 	<input type="submit" value="Submit" />
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
	        mysql_real_escape_string($_POST['usre_email']))) 
	            {
	            	//regular expression for email validation
	            	$Email = $_POST['user_email'];
	       		} 
	       	else 
	       		{
	           		$error[] = 'Your EMail Address is invalid  ';
	        	}
	 
	    }
	    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
		{
			echo 'Invalid email address..<br /><br />';
		
		}

    else
    {

    	$user_email=mysql_real_escape_string($_POST['user_email']);
   

  //   	$reset_pass="SELECT user_email from register where user_email=$user_email";

  //   	$result=mysql_query($reset_pass) or  die("failed".$mysqli_error);

  //   	if(mysql_num_rows($result) == 1)
		// {
		// 	echo 'Email already exits....Try Again !!!!!!.';
		// }
        
        
		$to=$user_email;
		$from="technocrat";
		$subject="Reset Password";

		$confirmmessage= "<html><a href=\"https://weiglevm.cs.odu.edu/~abarhanp/proj3/reset_password.php" .
		 "?id=1\">Reset Password</a>";

		 $headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: no-reply@technocrat.com";
		$message="please click here to reset your password";
		$message .=  $confirmmessage. "\n";
		$message .="</html>";

		$mailsent=mail($to,$from,$message,$headers);
		if($mailsent)
		{

		echo "mail has been sent";
		}
		else
		{
		echo "error in sending e-mail";
		}
	}
}

?>
