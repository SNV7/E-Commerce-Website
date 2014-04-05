<?php
  require_once('lib.php');
  output_header("Admin Page", array('stylesheet.css'));
  
	if( ! array_key_exists( 'loggedin', $_SESSION ) )
	{
		not_logged_in_response();
		output_footer();
		exit(0);
	}
	else
	{
		$STH = query_db("SELECT Admin FROM Users WHERE UserID = :userid", array(':userid' => $_SESSION['loggedin']));
		if( $row = $STH->fetch() )
		{
			$AdminTag = $row['Admin'];
			$AdminTag = htmlspecialchars($AdminTag);
			if( ! $AdminTag )
			{
				echo <<<ZZEOF
			<h3>You are not an administrator.</h3>
		
ZZEOF;
				output_footer();
				exit(0);
			}
		}
		else
		{
			not_logged_in_response();
			output_footer();
			exit(0);
		}
	}
  
  if( array_key_exists( 'added', $_SESSION ) )
  {
		echo "<h4>Item successfully added</h4><br />";
		unset($_SESSION['added']);
  }
  if( array_key_exists( 'errorpic', $_SESSION ) )
  {
		echo "<h4>Picture format incorrect</h4><br />";
		unset($_SESSION['errorpic']);
  }
  if( array_key_exists( 'picexists', $_SESSION ) )
  {
		echo "<h4>Picture already exists!!</h4><br />";
		unset($_SESSION['picexists']);
  }
	if( array_key_exists( 'uploaderror', $_SESSION ) )
  {
		echo "<h4>Picture upload error.</h4><br />";
		unset($_SESSION['uploaderror']);
  }

?>
<div id="updateinventory">

<form action="update_inventory.php" method="post"enctype="multipart/form-data">
<fieldset>
  <legend>Update Inventory</legend>
           <table> 
            <tr>
            <td>
            <label> Product Name </label>
            </td>
             <td>
            <input type="text" name="productName" value="" required = "required" >
             </td>
             </tr>

             <tr>
             <td>            
            <label> Description </label></td>
            <td>
            <input type="text" name="description" id="description" value="" required = "required" >
             </td>
             </tr>
              
              <tr>
             <td>            
            <label> Quantity </label></td>
            <td>
            <input type="number" name="quantity"  value="" required = "required" >
             </td>
             </tr>

             <tr>
            <td>
            <label> Price </label></td>
            <td>
            <input type="number" name="price"  value="" required = "required" >
             </td>
             </tr>

             <tr>
             <td>
              <label>Select Categories</label></td>
             <td>
             <select name="Category" id="Category">
							<option value="">--Categories--</option>
							<?php
            
            //Loop through and select data
						$STH = query_db('SELECT * FROM Category', array());
            while($row = $STH->fetch())
						{
							$catName = $row['CategoryName'];
							$catName = htmlspecialchars($catName);

							echo <<<ZZEOF
							<option value="$catName">$catName</option>"

ZZEOF;
						}
            ?>
            </select>
             </td>
             </tr>

            <tr>
            <td>
            <label for="file"> Picture </label>
            <td>
            <input type="file" name="file" id="file">
             </td>
              </tr>    
          </table>
         <hr />
          <span id="PageError" class="ErrorDisplay"></span> <br />
          <input type="submit" name="updateinv" value="Update" />
            <input type="reset" value="Reset"/>
       </fieldset>
   </form>
 
 </div>    
 <br />
 <br />
 <br /> 
 
 <?php
 	if( array_key_exists( 'cannotdelete', $_SESSION ) )
  {
		echo "<h4>Error deleting item.</h4><br />";
		unset($_SESSION['cannotdelete']);
  }
  if( array_key_exists( 'deleted', $_SESSION ) )
  {
		echo "<h4>Successfully deleted item.</h4><br />";
		unset($_SESSION['deleted']);
  }
 ?>
 
 <div id="deleteinventory">
 <form action="update_inventory.php" method="post"enctype="multipart/form-data">
<fieldset>
  <legend>Delete Inventory</legend>
           <table> 
              
            <tr>
            <td>
            <label> Product Name </label>
            </td>
             <td>
							<select name="ProductDropDown" id="ProductDropDown">
								<option value="">--Products--</option>
							<?php
            
            //Loop through and select data
						$STH = query_db('SELECT * FROM Inventory', array());
            while($row = $STH->fetch())
						{
							$pName = $row['ProductName'];
							$pName = htmlspecialchars($pName);
							$pID = $row['ProductID'];
							$pID = htmlspecialchars($pID);
							echo <<<ZZEOF
								<option value="$pID">$pName</option>"

ZZEOF;
						}
            ?>
							</select>
             </td>
             </tr>
             
          </table>
         <hr />
          <input type="submit" value="Delete"  />
            <input type="reset" value="Reset"/>
       </fieldset>
   </form>
 </div> 
 
 <br />
 <br />
 <br />

 <?php
 	if( array_key_exists( 'editsuccess', $_SESSION ) )
  {
		echo "<h4>Edit Successful.</h4><br />";
		unset($_SESSION['editsuccess']);
  }
  if( array_key_exists( 'cannotupdate', $_SESSION ) )
  {
		echo "<h4>Failed to edit.</h4><br />";
		unset($_SESSION['cannotupdate']);
  }
 ?>

<div class="editinventory">
 <form action="update_inventory.php" method="post"enctype="multipart/form-data">
<fieldset>
  <legend>Edit Inventory</legend>
           <table> 
            
            <span> Edit Price for any Product below</span>  
            <tr>
            <td>
            <label> Product Name </label>
            </td>
             <td>
							<select name="ProductDropDown2" id="ProductDropDown2">
								<option value="">--Products--</option>
							<?php
            
            //Loop through and select data
						$STH = query_db('SELECT * FROM Inventory', array());
            while($row = $STH->fetch())
						{
							$pName2 = $row['ProductName'];
							$pName2 = htmlspecialchars($pName2);
							$pID2 = $row['ProductID'];
							$pID2 = htmlspecialchars($pID2);
							$price2 = $row['Price'];
							$price2 = htmlspecialchars($price2);
							$pQty2 = $row['Qty'];
							$pQty2 = htmlspecialchars($pQty2);
							echo <<<ZZEOF
								<option value="$pID2">$pName2 (Currently $price2 C, Qty: $pQty2)</option>"

ZZEOF;
						}
            ?>
							</select>
             </td>
             </tr>

             <tr>
            <td>
            <label> Price </label></td>
            <td>
            <input type="number" name="price"  value="" >
             </td>
             </tr>
             
             <tr>
            <td>
            <label> Quantity </label></td>
            <td>
            <input type="number" name="quantity"  value="" >
             </td>
             </tr>
             
          </table>
         <hr />
          <input type="submit" value="Edit"  />
            <input type="reset" value="Reset"/>
       </fieldset>
   </form>
 </div>     
 
<?php
  output_footer();
?>