<?php
session_start();
include("dbconnect.php");

if(!empty($_POST["admin"])){
	$admin = 1;
} else {
	$admin = 0;
}

$options = [
    'cost' => 11,
];

$username = $_POST["username"];
$hashed = password_hash($_POST["pwd1"], PASSWORD_BCRYPT, $options);

$sql = "INSERT INTO usr (username, password, is_admin)
VALUES ('$username', '$hashed', '$admin')";

if ($db->query($sql) === TRUE) {
	$_SESSION["newacc"] = $username;
    print('<meta http-equiv="refresh" content="0; URL=admin.php">');
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}

?>