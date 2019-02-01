<!DOCTYPE html>
<html>
<head>
	<?php session_start(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
<style>

.collapsible {
  background-color: #0761aa;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active {
  background-color: #0761aa;
  color: white;
}

.collapsible:hover {
	background-color: white;
	color: #0761aa;
}

.content {
  padding: 10px 18px;
  background-color: #f6f6f6;
  display: none;
  overflow: hidden;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myUL {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL li a {
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  color: black;
  display: block
}

#myUL li a:hover:not(.header) {
  background-color: #0761aa;
  color: white;
}

#myUL li a.active {
	background-color: #0761aa;
	color: white;
}

* {
  box-sizing: border-box;
}

body {
  font-family: Arial;
  padding: 10px;
  background-color: #f6f6f6;
}

/* Header/Blog Title */
.header {
  padding: 30px;
  text-align: center;
  background: #f6f6f6;
}

.header h1 {
  font-size: 50px;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #0761aa;
}

.topnav-right{
	text-align: right;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: white;
  color: #0761aa;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn {   
  float: left;
  width: 25%;
  background-color: #f6f6f6;
}

/* Right column */
.rightcolumn {
  float: left;
  width: 75%;
  background-color: #f6f6f6;
}

.rightleftcolumn {
  float: left;
  width: 49%;
  background-color: #f6f6f6;
}

.rightrightcolumn {
  float: right;
  width: 49%;
  background-color: #f6f6f6;

}

/* Fake image */
.fakeimg {
  background-color: #aaa;
  width: 100%;
  padding: 20px;
}

/* Add a card effect for articles */
.card {
  background-color: #f6f6f6;
  padding: 20px;
  margin-top: 20px;
}

.h2 {
	background-color: #0761aa;
	text-align: left;
	font-weight: bold;
	font-size: 25px;
	color: white;
	padding: 12px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Footer */
.footer {
  padding: 15px;
  text-align: center;
  background: #f6f6f6;
  margin-top: 20px;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 800px) {
  .leftcolumn, .rightcolumn {   
    width: 100%;
    padding: 0;
  }
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
@media screen and (max-width: 400px) {
  .topnav a {
    float: none;
    width: 100%;
  }
}

.vertical-menu {
  width: 100%;
  height: 1210px;
  overflow-y: auto;
}

.vertical-menu a {
  background-color: #0761aa;
  color: black;
  display: block;
  padding: 12px;
  text-decoration: none;
}

.vertical-menu a:hover {
  background-color: #0761aa;
  color: white;
}

.vertical-menu a.active {
  background-color: #4CAF50;
  color: white;
}

</style>
</head>
<body>

<div class="header">
  <img src="Images/logo.png" alt="Logo Onera" height="100px" width="33%">
</div>

<div class="topnav">
  <a href="layout.php?name=<?php if(!empty($_GET['name'])) {echo $_GET['name']; } else { echo "abbeville"; } ?>">Places</a>
  <a href="admin.php">Admin</a>
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