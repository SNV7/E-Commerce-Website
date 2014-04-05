<?php
	require_once('lib.php');
	output_header("Contact Us", array("stylesheet.css"));
	//include('menu.php');
?>

<?php
	if( ( isset($_POST["name"]) || isset($_POST["email"]) || isset($_POST["message"]) ) && count($_POST) == 3 ){
		echo "<h2>Thank you, your message has been submitted";
		//user sent message
		$name = $_POST["name"];
		$email = $_POST["email"];
		$message = $_POST["message"];
		$name = htmlspecialchars($name);
		$email = htmlspecialchars($email);
		$message = htmlspecialchars($message);
	
		//echo $_POST("name");
		$stm = query_db("INSERT INTO Contact (name,email,message) VALUES (:name,:email,:message)", array(':name' => $name, ':email' => $email, ':message' => $message) );
		//$stm = $DBH->prepare("INSERT INTO Contact (name,email,message) VALUES ('$name','$email','$message')");
		//$stm->execute();
  }//end if
  else
  {
?>

<br>
<div id="form">
	<h1>Contact Us</h1>
	<h3>You can send us question or comments using the form below</h3>

	<form action="" method="POST">
		Name: <input type="text" name="name"><br>
		E-mail: <input type="text" name="email"><br>
		<textarea name="message" rows="10" cols="50" placeholder="Enter your message here..."></textarea><br>
		<input type="submit" name="submit">
	</form>
	
<?php
	} //end if ?>
</div>

<?php
	output_footer();
?>  