<!DOCTYPE html>
<html>
<head>
	<?php // session_start(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
</head>
<body>

<div class="header">
  <img src="Images/logo.png" alt="Logo Onera" height="100px" width="33%">
</div>

<div class="topnav">
  <a href="index.php?name=<?php if(!empty($_GET['name'])) {echo $_GET['name']; } else { echo $_SESSION["currname"]; } ?>">Places</a>
  <?php 
  if($_SESSION["is_admin"] == 1){
  ?>
  <a href="admin.php">Admin</a>
  <?php
  }
  ?>
  <a href="changepassword.php">Change password</a>
  <a href="logout.php" style="float: right;">Logout</a>
</div>

<?php

if(empty($_SESSION['city'])){
  if (($handle = fopen("Plaatsen.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $lower = strtolower($data[0]);
      $lower = ucwords($lower);
      $city[] = $lower;
    }
    fclose($handle);
  }

$_SESSION['get'] = count($city);
sort($city);
$_SESSION['city'] = $city;
}
?>

</body>
</html>
