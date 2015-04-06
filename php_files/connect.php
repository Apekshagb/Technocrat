<?php 
session_start();
//connect.php
$server	    = 'localhost';
$username	= 'awillis';
$password	= '3l3phanT';
$database	= 'awillis';

if(!mysql_connect($server, $username, $password))
{
 	exit('Error: could not establish database connection');
}
if(!mysql_select_db($database))
{
 	exit('Error: could not select the database');
}
?>
