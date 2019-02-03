<!DOCTYPE html>
<html>
<head>
<style>
.header {
  text-align: center;
  background: #f6f6f6;
}

.button { /* Green */
  border: none;
  color: white;
  width: 100%;
  padding: 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  margin-top: 7px;
  font-size: 16px;
  -webkit-transition-duration: 1s; /* Safari */
  transition-duration: 1s;
  cursor: pointer;
}

.button {
  background-color: #0761aa;
  color: white; 
  border: 2px solid #0761aa;

}

.button:hover {
  background-color: white;
  color: #0761aa;
  border-bottom: 2px solid #0761aa;
}

input[type=text], select {
  width: 100%;
  padding: 12px;
  display: inline-block;
  margin-top: 10px;
  margin-bottom: 15px;
  background-color: white;
  border: 2px solid #0761aa;
  box-sizing: border-box;
  -webkit-transition-duration: 0.5s; /* Safari */
  transition-duration: 0.5s;
}

input[type=text]:focus {
  border: 2px solid #0761aa;
  background-color: #0761aa;
  color: white;
}

input[type=password]{
  width: 100%;
  padding: 12px;
  display: inline-block;
  margin-top: 10px;
  margin-bottom: 15px;
  background-color: white;
  border: 2px solid #0761aa;
  box-sizing: border-box;
  -webkit-transition-duration: 0.5s; /* Safari */
  transition-duration: 0.5s;
}

input[type=password]:focus {
  border: 2px solid #0761aa;
  background-color: #0761aa;
  color: white;
}

.h1 {
  font-size: 20px;
  font-family: arial;
  color: #0761aa;
}

.leftcolumn {
  float: left;
  width: 33.33%;
  background-color: white;
}

.centercolumn {
  float: left;
  width: 33.34%;
  background-color: white;
}

.rightcolumn {
  float: left;
  width: 33.33%;
  background-color: white;
}

</style>
<?php
include("dbconnect.php"); // Include alle pagina's.
include("functions.php");
session_start();
if(isset($_SESSION['auth']))
{
print('<meta http-equiv="refresh" content="0; URL=index.php?name=abbeville">');
  	die();
}

// Controleert of de ingevulde naam, overeenkomst met het ingevulde wachtwoord.
if(!empty($_POST))
{
	$user = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	$query = "SELECT * FROM usr WHERE username ='" . $_POST["username"] ."'";
	$result = mysqli_query($db, $query) or die("FOUT : " . mysqli_error($db));

	if(mysqli_num_rows($result) > 0)
	{
		$row = mysqli_fetch_assoc($result);

		$pwh = $row['password'];
		if(password_verify($password, $pwh)) // Kijkt of het ingevoerde wachtwoord overeenkomt met de hash in de database.
		{
			$success = 1;
			do_login($row["idusr"], time() + 120, $user, $row["is_admin"]);
			print('<meta http-equiv="refresh" content="0"; URL=index.php?name=abbeville">');

   	 		exit();
		}
	}

    // Als de login een succes is, komen wij hier nooit (zie exit() hier boven).
    $foutmeldingen[] = "The name or the password is not right.";
}

$logged_in = false;

// Print de fouten en meldingen naar het scherm.
print_fouten();
print_meldingen();
?>
</head>
<body>
<div class="header">
  <img src="Images/logo.png" alt="Logo Onera" height="170px" width="33%">
</div>
<div style="background-color: #0761aa; height: 47px; width: 100%;"></div>
<div class="leftcolumn"><br></div>
<form method="post" action="login.php">
	<div class="centercolumn">
	<label for="user"><div class="h1" style="color: #0761aa; margin-top: 30px">User</div></label>
		<input type="text" class="form-control" name="username" id="username" required>
			<label for="Password"><div class="h1" style="color: #0761aa; margin-top: 10px">Password</div></label>
				<input type="password" class="form-control" name="password" id="password" required>
					<button class="button" type="submit">Login</button>
</form>
</div>
<div class="rightcolumn"><br></div>
</body>
</html>