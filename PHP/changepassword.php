<?php
include("include.php"); // Include alle pagina's.

if(!isset($_SESSION['auth']))
{
				print('<meta http-equiv="refresh" content="0; URL=login.php">');
  	die();
}

// Controleert of de ingevulde naam, overeenkomst met het ingevulde wachtwoord.
if(!empty($_POST))
{
  $password = mysqli_real_escape_string($db, $_POST['password']);
	$password1 = mysqli_real_escape_string($db, $_POST['npassword1']);
	$password2= mysqli_real_escape_string($db, $_POST['npassword2']);

if($password1 === $password2){
	$query = "SELECT * FROM usr WHERE username ='" . $_SESSION["username"] ."'";
	$result = mysqli_query($db, $query) or die("FOUT : " . mysqli_error($db));
  $row = mysqli_fetch_assoc($result);
if(password_verify($password, $row['password'])){
$pwh = password_hash($password1, PASSWORD_DEFAULT);
$query = "UPDATE usr SET password ='". $pwh . "' WHERE idusr ='". $_SESSION["usr_id"] . "'";
    $result = mysqli_query($db, $query) or die("FOUT" . mysqli_error($db));
$meldingen[] = "U wachtwoord is succesvol gewijzigd.  <br />Als u na 5 seconden niet wordt doorverwezen, <a href=\"login.php\">klik dan hier</a>.";
print('<meta http-equiv="refresh" content="5; URL=index.php">');
  }
  else{
    $foutmeldingen[] = "password is not correct";
  }

}

else{
$foutmeldingen[] = "new passwords do not match";
  }
}

// Print de fouten en meldingen naar het scherm.
print_fouten();
print_meldingen();
?>

<!-- Het formulier voor het inloggen. -->
<div class="leftcolumn"><br></div>
<div class="adminrightcolumn">
<div class="h2admin">Change password for <?php echo $_SESSION["username"]; ?></div>
	<div class="changepass"></div>
  	<div class="changepass">
		<form method="post" action="changepassword.php">
			<table>
				<tr>
					<td>Current password</td>
					<td><input style="width: 100%" type="password" class="form-control" name="password" id="password" required></td>
				</tr>
				<tr>
					<td>New password</td>
					<td><input style="width: 100%" type="password" class="form-control" name="npassword1" id="npassword1" required></td>
				</tr>
				<tr>
					<td>Confirm password</td>
					<td><input style="width: 100%" type="password" class="form-control" name="npassword2" id="npassword2" required></td>
				</tr>
			</table>
			<div class="adminrightleftcolumn">
				<input class="button" type="submit" value="Change password">
			</div>
		</form>
			<div class="adminrightrightcolumn">
				<div class="adminbutton">
					<a href="admin.php" style="margin-top: 7px;">Cancel</a>
				</div>
	</div>
</div>

<?php
	// hier moet de footer

  ?>
