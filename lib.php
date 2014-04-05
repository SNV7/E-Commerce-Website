<?php

session_start();

function query_db($query_prepare, $query_execute)
{
	$query_prepare = htmlspecialchars($query_prepare);
	
	try {
		//Variables
		$dbname = "velrith_334";
		$user = "velrith_334";
		$pass = "confirm";
		$host = "localhost";

		//Create MySQL database handle
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$DBH->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		$DBH->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
		
		//Query the database
		$STH = $DBH->prepare($query_prepare);
		

		if($query_execute == null)
		{
			$STH->execute();
		}
		else
		{
			$STH->execute($query_execute);			
		}

		//Setting the fetch mode
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		
		return $STH;
	}
	catch(PDOException $e) {
		echo <<<ZZEOF
<!DOCTYPE html>
<html>
<head>
	<title>Connection to DB Test Failed</title>
</head>
<body>

ZZEOF;
		echo $e->getMessage();
		echo <<<ZZEOF

</body>
</head>

ZZEOF;
	}//end try
}

function output_header($title, $cssfiles = array(), $jsfiles= array())
{ 
	check_login();

	//function also inserts menu
  $title = htmlspecialchars($title);

	echo <<<ZZEOF
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>$title</title>
ZZEOF;

  foreach ($cssfiles as $f)
    echo '
	<link rel="stylesheet" href="'.$f.'" type="text/css" />';

  foreach ($jsfiles as $f)
    echo '
	<script src="'.$f.'" type="application/javascript"></script>';

  echo <<<ZZEOF

</head>
<body>
	<div id="container">
		<div id="header">
			<a href="index.php"><h1>The Adventure Store</h1></a>
		</div>
		<div id="body">

ZZEOF;

display_menu();
}


function check_login()
{
	if(
	!array_key_exists('loggedin', $_SESSION) &&
	count($_POST) == 2 &&
	array_key_exists('login', $_POST) &&
	array_key_exists('pass', $_POST))
	{
		$login = trim($_POST['login']);
		$pass = trim($_POST['pass']);
		$login = htmlspecialchars($login);
		$pass = htmlspecialchars($pass);
		$pass = md5($pass);
		
		
		unset($_POST['login']);
		unset($_POST['pass']);
		
		try {
			$STH = query_db("SELECT * FROM Users WHERE Email = :login", array(':login' => $login));

			$currentpage = basename($_SERVER['PHP_SELF']);

			//Select data
			if( $row = $STH->fetch() )
			{
				$qEmail = $row['Email'];
				$qEmail = htmlspecialchars($qEmail);
				$qPass = $row['Password'];
				$qPass = htmlspecialchars($qPass);
				$uID = $row['UserID'];
				$uID = htmlspecialchars($uID);
				$AdminTag = $row['Admin'];
				$AdminTag = htmlspecialchars($AdminTag);
				
				if( strcmp($qEmail, $login) == 0 && $qPass == $pass )
				{
					$_SESSION['loggedin'] = $uID;
					if( $AdminTag )
					{
						header("Location: adminpage.php");
						exit(0);
					}
					header("Location: $currentpage");
					exit(0);
				}
			}
			$_SESSION['badLogin'] = 'True';
			header("Location: $currentpage");
			exit(0);
		}
		catch(PDOException $e) {
			output_header("Connection to DB Test Failed", array('stylesheet.css'));
			
			echo $e->getMessage();
			echo <<<ZZEOF

</body>
</head>

ZZEOF;
			exit(1);
		}//end try
	}
}


function display_menu()
{
	echo <<<ZZEOF
			<div id="mainmenu">

ZZEOF;

	$currentpage = basename($_SERVER['PHP_SELF']);

	if (array_key_exists('loggedin', $_SESSION))
	{
		$uID2 = $_SESSION['loggedin'];
		$uID2 = htmlspecialchars($uID2);
		
		$STH = query_db("SELECT Email, Admin FROM Users WHERE UserID = :userid", array(':userid' => $uID2));
		if( $row = $STH->fetch() )
		{
			$AdminTag2 = $row['Admin'];
			$AdminTag2 = htmlspecialchars($AdminTag2);
			$qEmail = $row['Email'];
			$qEmail = htmlspecialchars($qEmail);
			if( $AdminTag2 )
			{
				echo <<<ZZEOF
		<p><a href="adminpage.php">Admin</a></p>

ZZEOF;
			}
			echo <<<ZZEOF
		<p>Welcome <a href="myaccount.php">$qEmail</a></p>
		<p><a href="myaccount.php">My Account</a><br />
		<a href="mysettings.php">My Settings</a><br />
		<a href="cart.php">My Shopping Cart</a><br />
		<a href="logout.php?page=$currentpage">Log out</a></p>

ZZEOF;

		}
		else
			header('Location: logout.php');
	}
	else
	{
		if( array_key_exists('badLogin', $_SESSION) )
		{
			unset($_SESSION['badLogin']);
			echo "<p id=badlogin>Invalid Username(email) and/or Password</p>";
		}
		
		$loginfill = 'login';
		$passwordfill = 'password';
		echo <<<ZZEOF
				<form action="$currentpage" method="POST">
					<fieldset>
						<legend>Login</legend>
						Login (email):<br />
						<input type="text" name="login" placeholder="Login" autofocus /><br />
						Password:<br />
						<input type="password" name="pass" placeholder="Password" /><br />
						<input type="submit" value="Login" />  or <a href="register.php">Sign Up</a>
					</fieldset>
				</form>
				

ZZEOF;
	}

	try
	{
		$STH = query_db('SELECT * FROM Category', array());

		//Loop through and select data
		echo '				<table style="width:300px">';
		while($row = $STH->fetch())
		{
			echo <<<ZZEOF

					<tr>
						<td><a href="list.php?c={$row['CategoryName']}">{$row['CategoryName']}</a></td>
					</tr>

ZZEOF;
		}//end while
		echo <<<ZZEOF
				</table>
			</div>
			<div id="mainContent">

ZZEOF;
	}
	catch(PDOException $e) {
		echo <<<ZZEOF
			<p>Connection to DB Test Failed. Error message: {$e->getMessage()}.</p>

ZZEOF;
	}
}

function output_footer()
{
echo <<<ZZEOF
			</div>
		</div>
	</div>
	<div id="footer">
		<p>By using this site, you agree to have read and accepted our <a href="terms.php">terms of use</a>. Copyright &copy; 2014. All right reserved.</p>
		<br /><a href="contact.php">Contact Us</a><br />
		<a href="careers.php">Careers</a><br />
		<img src="getimage.php?name=logo.svg" alt>
	</div>
</body>
</html>
ZZEOF;
}

function not_logged_in_response()
{
	echo <<<ZZEOF
			<h3>Not Logged In.</h3>
			<p>Please log in on the panel to the left.</p>
		
ZZEOF;
}
?>