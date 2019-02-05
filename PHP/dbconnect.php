<?php
// 1. Connectie leggen met de database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "onera";
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
 // Test of de verbinding werkt!
 if (mysqli_connect_errno()) {
      die("De verbinding met de database is mislukt: "
        .	mysqli_connect_error() .
   		     " (" . mysqli_connect_errno() . ")" );
}
?>
