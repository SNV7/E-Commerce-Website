<?php
	require_once('lib.php');
	output_header("Product", array("stylesheet.css"));

	// Get Product information -->
  if(array_key_exists('id', $_GET))
	{
		//Show selected product
		$id = htmlspecialchars($_GET['id']);
		
		$STH = query_db("SELECT * FROM Inventory WHERE ProductID = :id", array(':id' => $id));

		if( $row = $STH->fetch() )
		{
			$pName = $row['ProductName'];
			$pPrice = $row['Price'];
			$pQty = $row['Qty'];
			$pDesc = $row['Description'];
			$fileName = $row['Picture'];
			$pID = $row['ProductID'];
			$pQty = $row['Qty'];
			
			$pName = htmlspecialchars($pName);
			$pDesc = htmlspecialchars($pDesc);
			$fileName = htmlspecialchars($fileName);
			$pID = htmlspecialchars($pID);
			$pQty = htmlspecialchars($pQty);

?>
            <div class="productBox">
            	<!--Get product image path-->
                <div class="productThumb">
                <?php
                	//image must be h:110 and w:110

            		//chdir ('../private_html');//go up and change to private dir
            		echo "<img src='getimage.php?name=$fileName' alt='$pName Image' width=110 height=110 />"; //display image in private dir 
  					//echo "<img src='$fileName' alt='$fileName Image'>"; //display image in private dir
  					//chdir ('../public_html');//go up and change back to public dir
  					
            	?>
            	</div>
                <div class="productTitle"><?php echo $pName ?><br /> <?php echo $pPrice ?> Coins, <?php echo $pQty ?> left in stock</div>
            </div>
            
           <div class="productDesc">
				<?php echo $pDesc ?>
           </div>
           
           <div class="buyProduct">
							<?php if( array_key_exists( 'loggedin', $_SESSION ) )
							{
?>
           		<br />
           		<a href="cart.php?id=<?php echo $pID ?>">Add To Shopping Cart</a>
           		<br />
           		<a href="cart.php">View Shopping Cart</a>
<?php					}
							else
							{ ?>
							<h3>Please Login or Register to access your Shopping Cart</h3>
<?php					}	?>
           </div>
        </div>
        
<?php
		} //end if (no search result)
		else
		{
			echo <<<ZZEOF
		<h4>No Item Selected</h4>

ZZEOF;
		}
	} //end if (no 'id' in $_GET)
	else
	{
		echo <<<ZZEOF
		<h4>No Item Selected</h4>

ZZEOF;
	}
	output_footer();
?>  