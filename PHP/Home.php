<!DOCTYPE html>
<html>
<head>
<?php
include('include.php');
if(empty($_SESSION['name'])){
  echo "Hello! <br>"; 
} else{
  ?> laatst bezochte stad is: <a href="test.php?name=<?php
  echo $_SESSION['name'];
  ?> "><?php echo strtolower(ucfirst($_SESSION['name']));?> </a></br><?php
  echo $_SESSION['stn'] . "</br>";
  echo $_SESSION['country'] . "</br>";
  echo $_SESSION['lati'] . "</br>";
  echo $_SESSION['long'] . "</br>";
  echo $_SESSION['alt'] . "</br>";
  echo $_SESSION['get'] . "</br";

}
?>
