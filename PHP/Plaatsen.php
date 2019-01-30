<!DOCTYPE html>
<html>
<head>
<?php
include('include.php');

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  margin-right: 37.5%;
  margin-left: 37.5%;
  width: 25%;
  margin-top: 12px;
  text-align: center;
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
  text-align: left;
  width: 20%;
  text-decoration: none;
  font-size: 18px;
  color: black;
  display: block
}

#myUL li a:hover:not(.header) {
  background-color: #eee;
}
</style>
</head>
<body>
<div>

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


<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Stadsnaam" title="Welke weerdata wilt u bekijken">

<ul id="myUL">
<?php
for($x = 0; $x < $_SESSION['get']; $x++){
?>

    <li><a href="layout.php?name=

<?php
  echo $_SESSION['city'][$x];
?>

">

<?php
  echo $_SESSION['city'][$x];
?>

</a></li>

<?php
}
?>

</ul>
</div>
<script>
function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
</script>

</body>
</html>
