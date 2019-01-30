<?php
include("include.php"); // Include alle pagina's.

if(isset($_SESSION['auth']))
{
	header('Location: Home.php');
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
			print('<meta http-equiv="refresh" content="0; URL=Home.php">');
		//	header("Location: Home.php");

   	 		exit();
		}
	}

    // Als de login een succes is, komen wij hier nooit (zie exit() hier boven).
    $foutmeldingen[] = "The name or the password is not right.";
}

$logged_in = false;
//show_header("Inloggen", $logged_in);

// Print de fouten en meldingen naar het scherm.
print_fouten();
print_meldingen();
?>

<!-- Het formulier voor het inloggen. -->
<br />
<div class="row">
	<div class="login"></div>
  	<div class="login">
		<form method="post" action="login.php">
			<div class="form-group">
				<label for="user">User:</label>
				<input type="text" class="form-control" name="username" id="username" required>
			</div>
			<div class="form-group">
				<label for="Password">Password:</label>
				<input type="password" class="form-control" name="password" id="password" required>
			</div>
			<button type="submit" class="loginknop">Inloggen</button>
		</form>
	</div>
</div>

<?php
	// hier moet de footer

  ?>
