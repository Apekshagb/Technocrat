<?php
//signup.php
include 'connect.php';
include 'header.php';



if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
	  note that the action="" will cause the form to post to the same page it is on */
     								//echo "<table class=\"table striped\" width=\"100%\">\n";
	                                echo "<table>";
                                    echo "<tr>";

                                    echo "<th><a href=admin_functions.php?value=1>USERS</th>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<th><a href=admin_functions.php?value=2>CREATE</th>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<th><a href=admin_functions.php?value=3>UPDATE</th>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<th><a href=admin_functions.php?value=4>DELETE</th>";
                                    
                                    echo "</tr>";
                                    echo "</table>";
}


include 'footer.php';
?>
