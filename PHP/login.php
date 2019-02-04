<!DOCTYPE html>
<html>
<head>
<?php
include("dbconnect.php"); // Include alle pagina's.
include("functions.php");
include("login.css");
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

?>
</head>
<body>
<div class="header">
  <img src="Images/logo.png" alt="Logo Onera" height="170px" width="33%">
</div>
<div style="background-color: #0761aa; height: 47px; width: 100%;"></div>
<?php
print_fouten();
print_meldingen();
?>
<div class="leftcolumn"><br></div>
<form method="post" action="login.php">
	<div class="centercolumn">
	<label for="user"><div class="h1" style="color: #0761aa; margin-top: 30px">User</div></label>
		<input type="text" class="form-control" name="username" id="username" required>
			<label for="Password"><div class="h1" style="color: #0761aa; margin-top: 10px">Password</div></label>
				<input type="password" class="form-control" name="password" id="password" required>
					<button class="button" type="submit">Login</button>
</form>
<?php
// Print de fouten en meldingen naar het scherm.

?>
</div>
<div class="rightcolumn"><br></div>
<div class="footer">
<?php
echo "&copy; " . date("Y") . " SpaceGems";
?>
</body>
</html>