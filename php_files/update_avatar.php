<?php

include 'connect.php';

$image_username = $_POST['user_name'];
$image_tempname = $_FILES['image_filename']['name'];
if($image_tempname)
{
$today = date("m-d-Y");
$id=uniqid();
//upload image and check for image type
//make sure to change your path to match your images directory
$ImageDir ="/home/awillis/cs418_html/project4/images/";
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

?>
