<?php
	require_once('lib.php');
	output_header("List of Products", array("stylesheet.css"));
        	
	// Get products
	
	//Check if a category POST request exists
	if(array_key_exists('c', $_GET) && count($_GET) == 1){
		//Show selected category
		$category = $_GET['c'];
		$category = htmlspecialchars($category);
		$STH = query_db("SELECT * FROM Inventory WHERE Category = :category", array(':category' => $category));

	}else{
		//No category specified, show all categories
		$STH = query_db("SELECT * FROM Inventory", array());

	}//end if



	//Loop through and select data
	while( $row = $STH->fetch() )
	{
		$fileName = $row['Picture'];
		$fileName = htmlspecialchars($fileName);
		$pName = $row['ProductName'];
		$pName = htmlspecialchars($pName);
		$pID = $row['ProductID'];
		$pID = htmlspecialchars($pID);
		$qty = $row['Qty'];
		$qty = htmlspecialchars($qty);
		$price = $row['Price'];
		$price = htmlspecialchars($price);
		
?>
				<!-- List products -->
				<div class="productBox">
					<div class="productThumb">
						<?php echo "<img src='getimage.php?name=$fileName' alt='$pName Image' width=110 height=110 />"; ?>
					</div>
					<div class="productTitle">
						<?php echo "<a href='product.php?id=$pID'>$pName</a><br />" ?>
						<?php echo "$price ByteCoins<br />" ?>
						<?php echo "$qty Left in Stock<br />" ?>
					</div>
				</div>

<?php
	}//end while

	output_footer();
?>           
        