<?php
	require_once('lib.php');
	output_header("Shopping Cart", array("stylesheet.css"));
	
	if( !array_key_exists( 'loggedin', $_SESSION ) )
	{
		not_logged_in_response();
		output_footer();
		exit(0);
	}

	$userID = $_SESSION['loggedin'];
	$userID = htmlspecialchars($userID);

	//Clear out cart 
	if(array_key_exists('action', $_GET)){
		$action = $_GET['action'];
		$action = htmlspecialchars($action);
	
		if($action == "all") {
			//remove all for user id
			$stm = query_db("DELETE FROM ShoppingCart WHERE uid = :uid", array(':uid' => $userID ));
		}else{
			$stm = query_db("DELETE FROM ShoppingCart WHERE uid=:userID and pid=:action", array(':userID' => $userID, ':action' => $action));
		}
		header('Location: cart.php');
		exit(0);
	}//end if

	//Update quantity
	if(isset($_POST["qtyField"]) && isset($_POST["pidField"])){
		$qty = $_POST['qtyField'];
		$pid = $_POST['pidField'];
		$qty = htmlspecialchars($qty);
		$pid = htmlspecialchars($pid);

		query_db("UPDATE ShoppingCart SET Qty=:qty WHERE uid = :userID AND pid = :pid", array(':qty' => $qty,':userID' => $userID, ':pid' => $pid));
		header('Location: cart.php');
		exit(0);
	}//end if

	//Add Item to cart
	if(array_key_exists('id', $_GET)){
		//Show selected product
		$productID = $_GET['id'];
		$productID = htmlspecialchars($productID);

		$STH = query_db("SELECT * FROM ShoppingCart WHERE uid = :userID AND pid = :productID", array(':userID' => $userID, ':productID' => $productID));

		if( $row1 = $STH->fetch() ) //if such an item exists, then update, else add
		{
			$qty = $row1['Qty'];
			$qty = htmlspecialchars($qty);
			query_db("UPDATE ShoppingCart SET Qty=:qty WHERE uid = :userID AND pid = :productID", array(':qty' => $qty + 1,':userID' => $userID, ':productID' => $productID));
		}
		else
		{
			query_db("INSERT INTO ShoppingCart (uid,pid,qty) VALUES (:userID,:productID,1)", array(':userID' => $userID, ':productID' => $productID)); 
		}
		header('Location: cart.php');
		exit(0);
	}
?>

<script language="javascript" type="text/javascript">
function ajaxFunction(){
	var ajaxRequest;  
	
	//Check for browser support of AJAX
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}//end try
		}//end try
	}//end try
	
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//document.myForm.time.value = ajaxRequest.responseText;
			document.getElementByClassName('cartProductPrice').innerHTML = ajaxRequest.responseText;
			//document.getElementById("cartProductActions2").innerHTML = ajaxRequest.responseText;
		}//end if
	}//end function
	ajaxRequest.open("GET", "updateCart.php", true);
	ajaxRequest.send(null); 
}//end function
</script>


<h1>Shopping Cart</h1>

<br>
<?php

	$total = 0; //variable to keep track of total cost

	$STH3 = query_db("SELECT * FROM Inventory, ShoppingCart WHERE Inventory.ProductID = ShoppingCart.pid AND ShoppingCart.uid = :uid", array(':uid' => $userID));

	//Display Cart
	$i = 1;
	while($row = $STH3->fetch()) {
		$priceT = $row['Price'];
		$priceT = htmlspecialchars($priceT);
		$qtyT = $row['Qty'];
		$qtyT = htmlspecialchars($qtyT);
		$subtotal = $priceT * $qtyT;
		$total = $total + $subtotal;
		$pName = $row['ProductName'];
		$pName = htmlspecialchars($pName);
		$pID = $row['ProductID'];
		$pID = htmlspecialchars($pID);

		echo <<<ZZEOF
			<div id='cartProductBox'>
				<div id='cartProductTitle'>$pName</div>
				<div id='cartProductActions'><a href='cart.php?action=$pID'>Remove</a></div>
				<div id='cartProductPrice'>
					<form action="" method="POST">
						<input type="text" name="qtyField" value="{$row['Qty']}" style="width: 20px; height:12px;"> @ {$row['Price']} C = $subtotal C
						<input type="hidden" name="pidField" value={$row['ProductID']}>
						<input type="Submit" name="submit" value="Update">
					</form>
				</div>
			</div>

ZZEOF;

	}//end while

	$STH4 = query_db("SELECT * FROM Users WHERE UserID = :uid", array(':uid' => $userID));
	if( $row4 = $STH4->fetch() )
	{
		$balance = $row4['ByteCoins'];
		$balance = htmlspecialchars($balance);
	}

	if( $balance < $total )
	{
		echo <<<ZZEOF
			<div id="cartTotalBox">
				Total: $total ByteCoins<br>
				<h6>You cannot afford to make the purchase. You only have $balance C</h6>
				<form action="cart.php?action=all" method="post">
				<input type="Submit" value="Clear Cart">
				</form>
			</div>
ZZEOF;
	}
	else
	{
?>

    <!-- Display cart total -->
    <div id="cartTotalBox">
    	Total: <?php echo $total ?> ByteCoins<br>

<?php
    		echo <<<ZZEOF
    			<form action="purchased.php?total=$total" method="post">
ZZEOF;
?>
			<input type="Submit" value="Buy Now">
		</form>
		
		<form action="cart.php?action=all" method="post">
			<input type="Submit" value="Clear Cart">
		</form>
    </div>
<?php
	} //end if
	output_footer();
?>  