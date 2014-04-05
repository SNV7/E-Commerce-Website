<?php

require_once('lib.php');

output_header("My Account Settings", array('stylesheet.css'));

if( ! array_key_exists('loggedin', $_SESSION) )
{
	not_logged_in_response();
}
else
{
	if(
	count($_POST) == 6 &&
	array_key_exists('firstname', $_POST) &&
	array_key_exists('lastname', $_POST) &&
	array_key_exists('address', $_POST) &&
	array_key_exists('phone', $_POST) &&
	array_key_exists('pass', $_POST) &&
	array_key_exists('passre', $_POST))
	{
		$firstname = trim($_POST['firstname']);
		$lastname = trim($_POST['lastname']);
		$address = trim($_POST['address']);
		$phone = trim($_POST['phone']);
		$pass = trim($_POST['pass']);
		$passre = trim($_POST['passre']);
		
		$firstname = htmlspecialchars($firstname);
		$lastname = htmlspecialchars($lastname);
		$address = htmlspecialchars($address);
		$phone = htmlspecialchars($phone);
		$pass = htmlspecialchars($pass);
		$passre = htmlspecialchars($passre);

		if( strcmp($firstname, "") == 0 )
			$firstname = null;
		if( strcmp($lastname, "") == 0 )
			$lastname = null;
		if( strcmp($address, "") == 0 )
			$address = null;
		if( strcmp($phone, "") == 0 )
			$phone = null;

		$userid = $_SESSION['loggedin'];

		if( strcmp($pass, $passre) == 0 )
		{
			if( strcmp( $pass, "" ) != 0 )
			{
				$pass = md5($pass);
				query_db("UPDATE Users SET FirstName = :first, LastName = :last, Address = :address, Phone = :phone, Password = :pass WHERE UserId = :userid",
					array( ':userid' => $userid, ':first' => "$firstname", ':last' => "$lastname", ':address' => "$address", ':phone' => "$phone", ':pass' => "$pass" ));
			}
			else
			{
				$pass = null;
				query_db("UPDATE Users SET FirstName = :first, LastName = :last, Address = :address, Phone = :phone WHERE UserId = :userid",
					array( ':userid' => $userid, ':first' => "$firstname", ':last' => "$lastname", ':address' => "$address", ':phone' => "$phone" ));
			}
			
			$STH = query_db("SELECT FirstName, LastName, Address, Phone, Password FROM Users WHERE UserId = :userid", array( ':userid' => $userid ));
			$userinfo = $STH->fetch();
			
			if( $userinfo['FirstName'] == $firstname &&
					$userinfo['LastName'] == $lastname &&
					$userinfo['Address'] == $address &&
					$userinfo['Phone'] == $phone &&
					( $pass == null || $userinfo['Password'] == $pass ) )
			{
				echo <<<ZZEOF
				<h4>Successfully Updated!</h4>

ZZEOF;
			}
			else
			{
				echo <<<ZZEOF
				<h4>FAILED TO UPDATE!!!</h4>

ZZEOF;
			}
		}
		else
		{
			echo <<<ZZEOF
				<h4>Password Mismatch!</h4>

ZZEOF;
		}
	}



	$userid = $_SESSION['loggedin'];
	$userinfo_query = query_db("SELECT FirstName, LastName, Address, Phone FROM Users WHERE UserId = :userid", array(':userid' => $userid) );
	
	if( $userinfo_row = $userinfo_query->fetch() )
	{
		$currentpage = basename($_SERVER['PHP_SELF']);
		echo <<<ZZEOF
				<form action="$currentpage" method="POST">
					<fieldset>
						<legend>Change Info</legend>
						First Name: <input type="text" name="firstname" value="{$userinfo_row['FirstName']}" onclick="this.select()" /><br />
						Last Name: <input type="text" name="lastname" value="{$userinfo_row['LastName']}" onclick="this.select()" /><br />
						Address: <input type="text" name="address" value="{$userinfo_row['Address']}" onclick="this.select()" size="50"/><br />
						Phone Number: <input type="text" name="phone" value="{$userinfo_row['Phone']}" onclick="this.select()" pattern='^([0-9]{10}|[0-9]{3}-[0-9]{3}-[0-9]{4}|[0-9]{3} [0-9]{3} [0-9]{4})?$' /><br />
						Password:	<input type="password" name="pass" placeholder="Password" /><br onclick="this.select()" />
						Re-Enter Password:	<input type="password" name="passre" placeholder="Re-Enter Password" onclick="this.select()" /><br />
						<input type="submit" value="ChangeInfo" />
					</fieldset>
				</form>

ZZEOF;
	}
	else
	{
		not_logged_in_response();
	}
}
output_footer();
?>