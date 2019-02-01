<?php
session_start();
if(!isset($_SESSION['auth']))
{
print('<meta http-equiv="refresh" content="0; URL=login.php">');
  	die();
}



include("dbconnect.php");
include("functions.php");
include("header.php");

 ?>
