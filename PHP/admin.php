<!DOCTYPE html>
<html>
<head>
<?php
include('include.php');

if(!empty($_POST))
{
  if(($_POST["admin"])){
  	$admin = 1;
  } else {
  	$admin = 0;
  }
  $username = $_POST["username"];
	$password1 = mysqli_real_escape_string($db, $_POST['pwd1']);
	$password2= mysqli_real_escape_string($db, $_POST['pwd2']);

if($password1 === $password2){
if(is_geldig_wachtwoord($password1))//controleert of het eerste wachtwoord geldig is.
	{

$pwh = password_hash($password1, PASSWORD_DEFAULT);
$query =  "INSERT INTO usr (username, password, is_admin) VALUES ('$username', '$pwh', '$admin')";
  $result = mysqli_query($db, $query) or die("FOUT" . mysqli_error($db));
  ?>
  	<p>User <?php echo $username ?> is added</p>
    <META HTTP-EQUIV="refresh" CONTENT="5">
<?php
  }

else {
	$foutmeldingen[] = "Ongeldig wachtwoord";
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
<title>Admin <?php echo $_SESSION["username"]; ?></title>
</head>

<body>
<?php

$sql = "SELECT username, is_admin FROM usr";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	if($_SESSION["username"] == $row["username"]){
    		$user = $row["username"];
    } else {
    	$accounts[] = $row["username"];
    	$admin[] = $row["is_admin"];
    }
}
} else {
    echo "0 results";
}
?>
<div class="leftcolumn">
	<div class="h2admin" style="width: 80%; font-size: 15px;">Download last four weeks</div>
	<div class="adminbutton" style="width: 80%;"><a href="download.php">download</a></div>
</div>

<div class="adminrightcolumn">
<?php
if(!empty($_SESSION["newacc"])){
?>
	<p>New user <?php echo $_SESSION["newacc"]; ?> is made</p>
<?php
	unset($_SESSION['newacc']);
} elseif (!empty($_SESSION["delacc"])) {
?>
	<p>User <?php echo $_SESSION["delacc"]; ?> is deleted</p>
<?php
	unset($_SESSION["delacc"]);
}
?>
<div class="h2admin">Admin <?php echo $user; ?></div>
<table>
	<tr>
		<th>Username</th>
		<th>Is admin?</th>
		<th>Delete</th>
	</tr>
		<?php for($x = 0; $x < count($accounts); $x++){
			?>
		<tr>
			<td><?php echo $accounts[$x]; ?></td>
			<td><?php if($admin[$x] == 1){ echo "Yes"; } else { echo "No"; } ?></td>
			<td><a href="admin.php?username=<?php echo $accounts[$x]; ?>" >X</a></td>
		</tr>

		<?php
		}
?>
	</table>
<?php
if(empty($_GET[addaccount])) {
?>
<div class="adminbutton">
<a href="<?php if(!empty($_GET["addaccount"])){ echo "admin.php"; } else { echo "admin.php?addaccount=addaccount"; } ?>">Add user</a>
<?php
}

if(!empty($_GET["username"]) && $_GET["username"] != oneraadmin && $_GET["username"] != onerauser){
	$sql = "DELETE FROM usr WHERE username='".$_GET['username']."'";
	$_SESSION["delacc"] = $_GET['username'];
	print('<meta http-equiv="refresh" content="0; URL=admin.php">');

	if ($db->query($sql) === TRUE) {
	    print('<meta http-equiv="refresh" content="0; URL=admin.php">');
	} else {
	    echo "Error deleting record: " . $db->error;
	}
}

if(!empty($_GET["addaccount"]) && $_GET["addaccount"] == "addaccount"){
?>
<div class="h2admin">Add user</div>
<form method="POST" action="admin.php" onsubmit="return checkForm(this);">
<table>
	<tr>
		<td>Username</td>
		<td><input style="width: 100%" type="text" name="username" required></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input style="width: 100%" type="password" name="pwd1" required></td>
	</tr>
	<tr>
		<td>Confirm password</td>
		<td><input style="width: 100%" type="password" name="pwd2" required></td>
	</tr>
	<tr>
		<td>Admin account?</td>
		<td><input type="checkbox" name="admin"></td>
	</tr>
</table>
<div class="adminrightleftcolumn">
<input class="button" type="submit" value="Make account">
</div>
</form>
<div class="adminrightrightcolumn">
	<div class="adminbutton">
		<a href="admin.php" style="margin-top: 7px;">Cancel</a>
	</div>
</div>
</div>
</div>
<?php
}
?>
</body>
</html>
