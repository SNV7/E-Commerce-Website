<?php
require_once('lib.php');


if( count($_POST == 5) &&
		array_key_exists('Email', $_POST) &&
		array_key_exists('FirstName', $_POST) &&
		array_key_exists('LastName', $_POST) &&
		array_key_exists('Password1', $_POST) &&
		array_key_exists('PhoneNumber', $_POST)
	)
{
	$email = htmlspecialchars($_POST['Email']);
	$fname = htmlspecialchars($_POST['FirstName']);
	$lname = htmlspecialchars($_POST['LastName']);
	$pass = htmlspecialchars($_POST['Password1']);
	$haspass = md5($pass);
	$phone = htmlspecialchars($_POST['PhoneNumber']);

	query_db("INSERT INTO Users (Email, Password, FirstName, LastName, Phone) VALUES (:email, :haspass, :fname, :lname, :phone)", array(':email' => $email, ':haspass' => $haspass, ':fname' => $fname, ':lname' => $lname, ':phone' => $phone));
	
	$_SESSION['newuser'] = 'true';
	
	$STH = query_db("SELECT UserID FROM Users WHERE UserID = (SELECT MAX(UserID) FROM Users)", array());
	if( $row = $STH->fetch() )
	{
		$userID = htmlspecialchars($row['UserID']);
		$_SESSION['loggedin'] = $userID;
	}
	header('Location: myaccount.php');
	exit(0);
}
else
{
	$_SESSION['badnewuser'] = 'true';
	header('Location: register.php');
	exit(0);
}

?>
