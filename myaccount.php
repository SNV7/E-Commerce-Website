<?php

require_once('lib.php');

output_header("My Account", array('stylesheet.css'));

if( ! array_key_exists('loggedin', $_SESSION) )
{
	not_logged_in_response();
}
else
{
	$userid = $_SESSION['loggedin'];
	$bytecoins_query = query_db("SELECT ByteCoins FROM Users WHERE UserId = :userid", array(':userid' => $userid) );
	if( $bytecoins_row = $bytecoins_query->fetch() )
	{
		$bytecoins = $bytecoins_row['ByteCoins'];
	}
	else
	{
		$bytecoins = 0;
	}

	echo <<<ZZEOF
			<h3>My Account</h3>
			<p>ByteCoin Balance: $bytecoins</p>

ZZEOF;

	$orders_query = query_db("SELECT OrderId, ProductName, Quantity, Orders.Price FROM Orders, Inventory WHERE Orders.ProductID = Inventory.ProductID AND UserId = :userid ORDER BY OrderID", array(':userid' => $userid) );
	 

	$ordernumber = -1;
	$order_subtotal;
	while( $orders_row = $orders_query->fetch() )
	{
		if($ordernumber == -1) //Orders exist: create the table
		{
			echo <<<ZZEOF
			<table id=orders>
				<tr>
					<th>Order Number</th>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>ByteCoins Used</th>
				</tr>

ZZEOF;
		}
		echo <<<ZZEOF
				<tr class=orders>

ZZEOF;
		if($ordernumber != $orders_row['OrderId']) //Change in OrderId - print the OrderId. Don't print if same OrderId.
		{
			if($ordernumber != -1) //Check if a previous order was just outputted: print total if there was
			{
				echo <<<ZZEOF
					<td></td>
					<td></td>
					<td>Total = </td>
					<td>$subtotal</td>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>

ZZEOF;
			}
			$subtotal = 0;
			$ordernumber = $orders_row['OrderId'];
			echo <<<ZZEOF
					<td>{$orders_row['OrderId']}</td>

ZZEOF;
		}
		else
		{
			echo <<<ZZEOF
					<td></td>

ZZEOF;
		}
		echo <<<ZZEOF
					<td>{$orders_row['ProductName']}</td>
					<td>{$orders_row['Quantity']}</td>
					<td>{$orders_row['Price']}</td>
				</tr>

ZZEOF;
		$subtotal += $orders_row['Price'];
	}
	if($ordernumber != -1) //output ending of table
	{
		echo <<<ZZEOF
				<tr>
					<td></td>
					<td></td>
					<td>Total = </td>
					<td>$subtotal</td>
				</tr>
			</table>

ZZEOF;
	}
	else
	{
		echo <<<ZZEOF
			<br />
			<h3>You have no orders placed</h3>
			<br />

ZZEOF;
	}
}
output_footer();
?>