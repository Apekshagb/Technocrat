<?php

session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);

include_once 'securimage/securimage.php';

$securimage = new Securimage();

include 'connect.php';
//include 'header.php';



// $mysqli = new mysqli("localhost", "awillis", "3l3phanT", "awillis") or 
//      die ("Check your server connection.");
//make variables available
//$image_caption = $_POST['image_caption'];
$image_username = $_POST['user_name'];
$image_tempname = $_FILES['image_filename']['name'];
if($image_tempname)
{
$today = date("m-d-Y");
$id=uniqid();
//upload image and check for image type
//make sure to change your path to match your images directory
$ImageDir ="/home/abarhanp/cs418_html/project4/images/";
$ImageName = $ImageDir . $id . $image_tempname;
$image=$id . $image_tempname;
echo $ImageName;

if (move_uploaded_file($_FILES['image_filename']['tmp_name'], $ImageName))
 {
  echo "hhhiii";

  //get info about the image being uploaded
        list($width, $height, $type, $attr) = getimagesize($ImageName);

        switch ($type) {
          case 1:
            $ext = ".gif";
            break;
          case 2:
            $ext = ".jpg";
            break;
          case 3:
            $ext = ".png";
            break;
          default:
            echo "Sorry, but the file you uploaded was not a GIF, JPG, or " .
                 "PNG file.<br>";
            echo "Please hit your browser's 'back' button and try again.";
        }

         //insert info into image table
        $insert = "INSERT INTO images4
                  ( image_username, image_date, avatar_id)
                  VALUES
                  ( '$image_username', '$today', '$image')";
        $insertresults = mysql_query($insert)
          or die($mysql_error);
       //$lastpicid = mysql_insert_id();
        /*$newfilename = $ImageDir . uniqid() . $ext;
        srename($ImageName, $newfilename);*/
 }
 else
 {
echo "hhh";
 }
}
else
{

  
}

$cap=$_POST['captcha_code'];

if(isset($_POST['captcha_code']))
    {
        if ($securimage->check($cap) == false) 
        {
          $errors[] = 'The security code entered was incorrect.';
          // echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
          // exit;
        }     
    }

  // the code was incorrect
  // you should handle the error so that the form processor doesn't continue

  // or you can use the following code if there is no validation or you do not know how






    if(isset($_POST['user_name']))
    {
    //the user name exists
        if(!ctype_alnum($_POST['user_name']))
        {
          $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
          $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
      $errors[] = 'The username field must not be empty.';
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

    if (empty($_POST['user_email']))  
    {
      $error[] = 'Please Enter your Email ';
    } 
    else 
    {

      if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",
        $_POST['user_email'])) 
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
      echo ' A couple of fields are not filled in correctly..<br /><br />';
      echo '<ul>';
      foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
      {
        echo '<li>' . $value . '</li>'; /* this generates a nice error list */
      }
      echo '</ul>';
      //header('Location:signup.php');
    }
    else
    {
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //also notice the sha1 function which hashes the password
          $user_name=mysql_real_escape_string($_POST['user_name']);
        //$cs_user_name=mysql_real_escape_string($_POST['cs_user_name']);
          $user_email=mysql_real_escape_string($_POST['user_email']);
          $user_password=md5(mysql_real_escape_string($_POST['user_pass']));

        /*echo $user_name."<br>";
        echo $user_email;
        echo $user_password;
    */
        $to=$user_email;
        $from="technocrat";
        $subject="New User Registration";

        $boundary = "==MP_Bound_xyccr948x==";


        $activation_code=md5(rand(5,100));

        $register_user="insert into users4(user_name,user_pass,user_email,activation) values('$user_name','$user_password','$user_email','$activation_code')";

        $registered_user=mysql_query($register_user) or  die("insertion failed".$mysql_error);

        // if($row['user_email']==$user_email)
        // {
        //  echo ' Email ID already exist.....Please enter and new one !!!!!';
        // }

        $confirmmessage= "<html><a href=\"https://weiglevm.cs.odu.edu/~awillis/project4/confirm.php" .
        "?id=$activation_code\">Click here to confirm your account</a>";
        $textconfirm = "Please visit the following URL to confirm your " .
        "account:\n\n";
        $textconfirm .= "https://weiglevm.cs.odu.edu/~awillis/project4/confirm.php" .
        "?id=$activation_code";

        if(($_POST['option'])=='html')
        {
          $headers = "MIME-Version: 1.0\r\n";
          $headers .= "Content-type: text/html; charset=iso-8859-1\n";
          $headers .= "From: no-reply@technocrat.com";
          $message="WELCOME TO TECHNOCRAT !!!!!!!\r\n";
          $message.="----------------------------------\r\n";
          $message .=  $confirmmessage. "\n";
          $message .="</html>";
        }


        if(($_POST['option'])=='plain')
        {
          $headers = "MIME-Version: 1.0\r\n";
          $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
          $headers .= "From: no-reply@technocrat.com";
          $message =  $textconfirm. "\n";
        }


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

include 'footer.php';
?>
