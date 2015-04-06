<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="A short description." />
	<meta name="keywords" content="put, keywords, here" />
	 
	<title>PHP-MySQL forum</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	 <link href="./css/bootstrap.css" rel="stylesheet">
	  <script src="./js/jquery.min.js"></script>
	 

</head>
<body>
	<h1>Technocrat</h1>
	<div id="wrapper">
		<div id="menu" >
			<?php


			if($_SESSION['signed_in'] == true){



				if ($_SESSION['user_level'] == 0)
				{
        //the user is not an admin
					echo '<a class="item" href="index.php">Home</a>&nbsp';
					echo '<a class="item" href="create_topic.php">Create a topic</a>';

				}
				if($_SESSION['user_level'] == 1)
				{
					echo '<a class="item" href="index.php">Home</a>&nbsp';
					echo '<a class="item" href="create_topic.php">Create a topic</a>&nbsp';
					echo '<a class="item" href="user_profile.php">Moderator</a>&nbsp';

				}
				if($_SESSION['signed_in'] == false | $_SESSION['user_level'] == 2)
				{
					echo '<a class="item" href="index.php">Home</a>&nbsp';
					echo '<a class="item" href="create_topic.php">Create a topic</a>&nbsp';
					echo '<a class="item" href="create_cat.php">Create a category</a>&nbsp';
					echo '<a class="item" href="user_profile.php">Admin</a>&nbsp';
				}
			}
			else {
				echo '<a class="item" href="index.php">Home</a>&nbsp';
			}

			?>
			
				<?php

				if($_SESSION['signed_in']==true)
				{

					if ($_SESSION['activation_id']==1)
					{
							echo '<span style="width:35%;float:right;">Hello <b>' . mysql_real_escape_string($_SESSION['user_name']) . '</b>. Not you? <a class="item" href="signout.php">Sign out</a> <a class="item" href="profile.php?name='.mysql_real_escape_string($_SESSION['user_name']).'">Profile</a></span>';
	                }

						
				 if($_SESSION['activation_id']==0)
					{
						echo '<span style="width:35%;float:right;"><a class="item" href="signin.php">Sign in</a> or <a class="item" href="signup.php">create an account</a></span> ';

					}
				}
				else
				{
					echo '
					<span style="width:35%;float:right;"><a class="item" href="signin.php">Sign in</a> or <a class="item" href="signup.php">create an account</a></span> ';
				}
				?>
			
		</div>
		<div id="content">
