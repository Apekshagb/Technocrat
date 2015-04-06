<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);
include 'connect.php';
//include 'header.php';
// require 'CaptchasDotNet.php';

// $captchas = new CaptchasDotNet ('awillis', 'U5PwF8O5DYJF0iMtqoxYruVg2HPhx6gU4YJYuzmJ',
// 	'/tmp/captchasnet-random-strings','3600',
// 	'abcdefghkmnopqrstuvwxyz','6',
// 	'240','80','000088');


 // $mysql = new mysqli("localhost", "awillis", "3l3phanT", "awillis") or 
 // die ("Check your server connection.");
// include 'header.php';
// setup revision of check_image to call
$rev = "01";
if (isset($_GET["rev"])) {
	$rev = $_GET["rev"];
}

include_once 'securimage/securimage.php';

$securimage = new Securimage();



// $image_caption = $_POST['image_caption'];
// $image_username = $_POST['image_username'];
// $image_tempname = $_FILES['image_filename']['name'];
// $today = date("Y-m-d");

// $ImageDir ="/home/awillis/cs418_html/proj4/images/";
// $ImageName = $ImageDir . $image_tempname;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Bootstrap Admin Theme v3</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- styles -->
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/captcha.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
  </head>

  <body class="login-bg">
  	<div class="header">
  		<div class="container">
  			<div class="row">
  				<div class="col-md-12">
  					<!-- Logo -->
  					<div class="logo">
  						<h1><a href="index.php">Bootstrap Admin Theme</a></h1>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>


  		<div class="page-content container">
  			<div class="row">
  				<div class="col-md-4 col-md-offset-4">


  					<div class="login-wrapper">
  						<div class="box">
  							<div class="content-wrap">
  								<h6>Sign Up</h6>
  								<form name="form1" method="post" action="useravatar.php" enctype="multipart/form-data">
  								<!-- <form method="post" action=""> -->
  									<input class="form-control" type="text" name="user_name" placeholder="Username">			                

  									<input class="form-control" type="password" name="user_pass" placeholder="Password">

  									<input class="form-control" type="password" name="user_pass_check" placeholder="Confirm Password">

  									<!-- <input class="form-control" id="append" type="text" name="user_email" placeholder="E-mail address"> -->

  									<!--<input class="form-control" type="email" name="user_email" placeholder="E-mail address">-->

  									<!-- <label class="control-label col-md-2" for="append">Appended Input</label> -->
  									<!-- <div class="col-md-10"> -->

  									<input class="form-control" type="text" name="user_email" placeholder="E-mail address" style="margin-bottom: 0px">

  									<!-- <span class="input-group-addon">@cs.odu.edu</span> -->
							<!-- <input class="radio" name="option" value="html"/>text_html<br/>
							<input class="radio" name="option" value="plain"/>text_plain<br/> -->
							
							<!-- <div class="col-sm-offset-2 col-sm-10"> -->
									<div class="radio">
										<label>
											<input type="radio" name="option" value="html">text_html
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="option" value="plain">text_plain
										</label>
									</div>
							</div>
						<!-- <div class="form-group"> -->
						<!-- <label class="col-md-2 control-label">File input</label> -->
						<!-- <div class="col-sm-12"> -->
								<p class="help-block">
									Make it personal. Upload an avatar.
								</p>
								
						<!-- <input type="file" name="file_name" class="btn btn-default" id="exampleInputFile1"> -->
										<input name="image_filename" type="file" id="image_filename">
											<!-- </div>
										</div> -->
<!-- </form> -->
										<img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
										<input type="text" name="captcha_code" size="10" maxlength="6" />
										<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
										
										<div class="action">
											<input type="submit" value="Register" />

										</div>  
									</form>
								</div>              
							</div>
						</div>

						<div class="already">
							<p>Have an account already?</p>
							<a href="signin.php">Login</a>
						</div>
					</div>
				</div>
			</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

<script>
	$(document).ready(function() {
// refresh captcha
$('img#captcha-refresh').click(function() {

	change_captcha();
});

function change_captcha()
{
	document.getElementById('captcha').src="get_captcha.php?rnd=" + Math.random();
}
});
</script>

</body>
</html>
