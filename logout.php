<?php
session_start();

if(array_key_exists('loggedin', $_SESSION) )
{
	if( array_key_exists('page',$_GET) )
	{
		$page = $_GET['page'];
		$page = htmlspecialchars($page);
	}
	else
	{
		$page = 'index.php';
	}
	unset($_SESSION['loggedin']);
	header("Location: $page");
	exit(0);
}
else
{
	header('Location: index.php');
	exit(0);
}

?>