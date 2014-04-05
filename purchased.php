<?php
	require_once('lib.php');
	output_header("Product", array("stylesheet.css"));
	
	if( !array_key_exists('loggedin', $_SESSION) )
	{
		not_logged_in_response();
		output_footer();
		exit(0);
	}

	if(array_key_exists('total', $_GET)){
		
		$total = $_GET['total'];
		$total = htmlspecialchars($userID);
		$userID = $_SESSION['loggedin'];
		$userID = htmlspecialchars($userID);
		
		//check if requested quantity > inventory quantity
		$STH5 = query_db('SELECT ProductName FROM Inventory,ShoppingCart WHERE pid = ProductID AND uid = :userID AND ShoppingCart.Qty NOT BETWEEN 1 AND Inventory.Qty', array(':userID' => $userID) );
		if( $row5 = $STH5->fetch() ) //requested qty > inventory qty!!
		{
			$pName5 = $row5['ProductName'];
			$pName5 = htmlspecialchars($pName5);
			echo <<<ZZEOF
			<h4>One or more items requested not available in stock for the quantities requested, such as: $pName5.</h4>
			<p>Go back to the <a href="cart.php">shopping cart</a>.</p>

ZZEOF;
			output_footer();
			exit(0);
		}
		
		//Deduct balance from user 
		$STH4 = query_db("SELECT * FROM Users WHERE UserID = :uid", array(':uid' => $userID));
		if( $row4 = $STH4->fetch() ){
			$balance = $row4['ByteCoins'];
		}else{
			echo "Database error";
		}//end if

		//Insert new balance into db
		$newBalance = $balance - $total;
		query_db("UPDATE Users SET ByteCoins=:newBalance WHERE UserID = :userID", array(':newBalance' => $newBalance,':userID' => $userID));
		
		
		//Create order id
		$STH4 = query_db("SELECT MAX(OrderID)+1 FROM Orders", array());
		if( $row4 = $STH4->fetch() ){
			$orderID = $row4['MAX(OrderID)+1'];
		}else{
			echo "error";
		}
		
		
		//Insert info into order table
		date_default_timezone_set('America/New_York');
		$date = date('m/d/Y h:i:s a', time());
		$date = $date.' EST';
		

		$cartHandle = query_db("SELECT Price, ShoppingCart.Qty, ProductID FROM ShoppingCart, Inventory WHERE uid=:userID AND ProductID = pid", array(':userID' => $userID));
		while($row = $cartHandle->fetch()) {
			$qty =  $row['Qty'];
			$price = $row['Price'] * $qty;
			$pid = $row['ProductID'];
			$pid = htmlspecialchars($pid);
			
			$orderHandle = query_db("INSERT INTO Orders (OrderID,ProductID,UserID,Quantity,Price,Date) VALUES (:orderID,:pid,:userID,:qty,:price,:date)",
				array(':orderID' => $orderID, ':pid' => $pid, 'userID' => $userID, ':qty' => $qty,':price' => $price,':date' => $date));
			 
			$updateHandle1 = query_db("SELECT Qty FROM Inventory WHERE ProductID = :pID", array(':pID' => $pid));
			if( $rowU1 = $updateHandle1->fetch() )
			{
				$qtyU1 = $rowU1['Qty'];
				$qtyU1 = htmlspecialchars($qtyU1);
				$qtyU1 = $qtyU1 - $qty;
				$updateHandle2 = query_db("UPDATE Inventory SET Qty = :qtyU1 WHERE ProductID = :pID", array(':qtyU1' => $qtyU1,':pID' => $pid));
			}
		}//end while

		//remove all from users cart
		$userID = $_SESSION['loggedin'];
		$userID = htmlspecialchars($userID);
		query_db("DELETE FROM ShoppingCart WHERE uid = :uid", array(':uid' => $userID ));

		header('Location: purchased.php');

	}else{
		echo "<h1> Thank you for your Purchase!!! </h1>";
	}//end if
	
?>




<?php
	output_footer();
?> 