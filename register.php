<?php
  require_once('lib.php');
  output_header("Registration", array('stylesheet.css'), array('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', 'register.js'));
  
  if( array_key_exists('loggedin', $_SESSION) )
  {
		$STH = query_db("SELECT Email FROM Users WHERE UserID = :userid", array(':userid' => $_SESSION['loggedin']));
		if( $row = $STH->fetch() )
		{
			echo <<<ZZEOF
			<h3>You are already logged in as {$row['Email']}.</h3>
		
ZZEOF;
			output_footer();
			exit(0);
		}
		else
		{
			unset($_SESSION['loggedin']);
			header('Location: register.php');
		}
  }
  
  if( array_key_exists('badnewuser', $_SESSION) )
	{
		unset($_SESSION['badnewuser']);
		echo <<<ZZEOF
			<h4>Not able to sign up, Sorry!</h4>

ZZEOF;
	}
  
?>
		<div id="content">
			<fieldset>
				<legend class="Legend" align="center"> New User Registration Form </legend>
				<br />
				<form name="Registration" 
				id="Registration" method="POST" action="InsertNewUser.php">
		
					<table>
						
						<tr><td>E-mail*</td><td><input id="Email" name="Email"
						type="text" onblur="checkEmail(this.value)" /> <span id="EmailError"
						class="ErrorDisplay"></span></td></tr>
						
						<tr><td>Password*</td><td><input id="Password1"
						name="Password1" type="password" onblur="checkPasswords()"/></td></tr>
						
						<tr><td>Confirm Password*</td><td><input id="Password2" name="Password2"
						type="password" onblur="checkPasswords()"/>	<span id="PasswordError"
						class="ErrorDisplay"></span> <br /></td></tr>
						
						<tr><td>First Name</td><td><input id="FirstName" name="FirstName" type="text" /></td></tr>
						<tr><td>Last Name</td><td><input id="LastName" name="LastName" type="text" /></td></tr>
						
						<tr><td>Phone Number</td><td><input id="PhoneNumber"
						name="PhoneNumber" type="text" onblur="checkPhone(this.value)" /> <span
						id="PhoneError" class="ErrorDisplay"></span></td></tr>
					</table>
		

					<hr />
					<span class="txtSmall">Note: * fields are required.</span> <br /> <br />
					<span id="PageError" class="ErrorDisplay"></span> <br />
					<input type="submit" name="submitbutton" value="Register"
						class="left_button" />
						<input type="reset" value="Reset"/>
				</form>
			</fieldset>
		</div>

<?php
  output_footer();
?>