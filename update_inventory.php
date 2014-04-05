<?php
require_once("lib.php");

if( count($_POST == 5) &&
		array_key_exists('productName', $_POST) &&
		array_key_exists('description', $_POST) &&
		array_key_exists('price', $_POST) &&
		array_key_exists('quantity', $_POST) &&
		array_key_exists('Category', $_POST)
	)
{
	$pName = htmlspecialchars($_POST['productName']);
	$pDesc = htmlspecialchars($_POST['description']);
	$price = htmlspecialchars($_POST['price']);
	$pQty = htmlspecialchars($_POST['quantity']);
	$pCat = htmlspecialchars($_POST['Category']);

	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 10000000)
	&& in_array($extension, $allowedExts))
		{
		if ($_FILES["file"]["error"] > 0)
			{
				$_SESSION['uploaderror'] = 'true';
				header('Location: adminpage.php');
				exit(0);
			}
		else
			{
			if (file_exists("../private_html/" . $_FILES["file"]["name"]))
				{
					$_SESSION['picexists'] = 'true';
					header('Location: adminpage.php');
					exit(0);
				}
			else
				{
				move_uploaded_file($_FILES["file"]["tmp_name"],"../private_html/" . $_FILES["file"]["name"]);
				}
			}
		}
		else
		{	
			$_SESSION['errorpic'] = 'true';
			header('Location: adminpage.php');
			exit(0);
		}
	
	try
	{
		query_db("INSERT INTO Inventory (ProductName, Description, Price, Qty, Category, Picture) VALUES (:pname, :description, :price, :qty, :cat, :pic)",
					array(':pname' => $pName,':description' => $pDesc, ':price' => $price, ':qty' => $pQty, ':cat' => $pCat, ':pic' => $_FILES['file']['name']) );
		$_SESSION['added'] = 'true';
		header('Location: adminpage.php');
	}
	catch(PDOException $e)
	{
		output_header("Error", array('stylesheet.css'));
		echo "<p>An error occurred during a database query</p>";
		echo "<p>The error was {$e->getMessage()}</p>";
		output_footer();
	}
	
}





else if( count($_POST == 1) &&
		array_key_exists('ProductDropDown', $_POST)
	)
{
	try
	{
		$pid = htmlspecialchars($_POST['ProductDropDown']);
		query_db("DELETE FROM Inventory WHERE ProductID = :pid", array(':pid' => $pid ) );
		$_SESSION['deleted'] = 'true';
		header('Location: adminpage.php');
		exit(0);
	}
	catch(PDOexception $e)
	{
		$_SESSION['cannotdelete'] = 'true';
		header('Location: adminpage.php');
		exit(0);
	}
}



else if( count($_POST == 3) &&
		array_key_exists('price', $_POST) &&
		array_key_exists('quantity', $_POST) &&
		array_key_exists('ProductDropDown2', $_POST)
	)
{
	try
	{
		$price2 = htmlspecialchars($_POST['price']);
		$pQty2 = htmlspecialchars($_POST['quantity']);
		$pid2 = htmlspecialchars($_POST['ProductDropDown2']);
		
		if( $pQty2 == "" )
		{
			$STH = query_db("UPDATE Inventory SET Price = :price WHERE ProductID = :pid", array(':price' => $price2, ':pid' => $pid2 ));
		}
		else if( $price2 == "" )
		{
			$STH = query_db("UPDATE Inventory SET Qty = :qty WHERE ProductID = :pid", array(':qty' => $pQty2,':pid' => $pid2));
		}
		else
		{
			$STH = query_db("UPDATE Inventory SET Price = :price, Qty = :qty WHERE ProductID = :pid", array(':price' => $price2, ':qty' => $pQty2,	':pid' => $pid2 ));
		}
		$_SESSION['editsuccess'] = 'true';
		header('Location: adminpage.php');
		exit(0);
	}
	catch(PDOexception $e)
	{
		$_SESSION['cannotupdate'] = 'true';
		header('Location: adminpage.php');
		exit(0);
	}
}

?>