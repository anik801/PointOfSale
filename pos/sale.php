<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';
	
	if(isset($_SESSION['cart_item']))	
		$cartItem=$_SESSION['cart_item'];
	if(isset($_POST['cartSubmit'])){
		$customerName=$_POST['name'];
		$customerContact=$_POST['contact'];
		$employeeNo=$_SESSION['id'];

		//Selecting customer
		$sql="SELECT customer_id FROM customers WHERE customer_name='$customerName' AND customer_contact='$customerContact'";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		if(!mysql_num_rows($result)){
			$sql="INSERT INTO customers (customer_name,customer_contact) VALUES ('$customerName','$customerContact')";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
			$sql="SELECT customer_id FROM customers WHERE customer_name='$customerName' AND customer_contact='$customerContact'";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}

		}
		$row=mysql_fetch_array($result);
		$customerId=$row['customer_id'];

		//Set current date and time
		$entryDate=date("Y-m-d H:i:s",time()+14400);
		//echo $entryDate;

		//Creating invoice
		$sql="INSERT INTO invoices (selling_date,customer_id,employee_no) VALUES ('$entryDate','$customerId','$employeeNo')";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$sql="SELECT invoice_id FROM invoices WHERE selling_date='$entryDate'";
		$result=mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$row=mysql_fetch_array($result);
		$invoiceId=$row['invoice_id'];

		for($i=1;$i<=$cartItem;$i++){
			$x="productId".$i;
			$y="quantity".$i;
			$productId=$_SESSION[$x];
			$quantity=$_SESSION[$y];

			$sql="INSERT INTO sales (invoice_id,product_id,quantity) VALUES ('$invoiceId','$productId','$quantity')";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}

			$sql="SELECT current_quantity FROM stocks WHERE product_id='$productId'";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}
			$row=mysql_fetch_array($result);
			$currentQuantity=$row['current_quantity'];

		
			$newQuantity=$currentQuantity-$quantity;

			//echo $currentQuantity."  ".$quantity."   ".$newQuantity."<br>";

			$sql="UPDATE stocks SET current_quantity='$newQuantity' WHERE product_id='$productId'";
			$result=mysql_query($sql);
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			}

		}
		echo "
		<script>
			
			document.location.href='sale.php';
		</script>
		";
		//header("Location: bill.php");
	}

	function showCartNum(){
		$_SESSION['cart_item']=0;
		$cartItem=$_SESSION['cart_item'];
		echo "<p id='itemNum'>Cart item(s): ".$cartItem."</p>";	
	}	
?>

<!DOCTYPE html>
<html>

<head>
  <title>Sale</title> 
  <script type="text/javascript">
  //AJAX functions dynamic changes.
  	function showProducts(str) {
	  if (str=="") {
	    document.getElementById("txtHint").innerHTML="";
	    return;
	  } 
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	      document.getElementById("productsDiv").innerHTML=xmlhttp.responseText;
	    }
	  }
	  xmlhttp.open("GET","getProducts.php?q="+str,true);
	  xmlhttp.send();
	}
  
  	function addProduct(quantity,productId) {
  	  //alert(quantity+" "+productId);
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	      document.getElementById("itemNum").innerHTML=xmlhttp.responseText;
	      //$("#productName").val("");
	      document.getElementById("cartMessageDiv").innerHTML="Item added to cart. To edit cart, please click the reset button.";
	      showProducts($("#productName").val());

	    }	
	  }
	  xmlhttp.open("GET","addProduct.php?x="+quantity+"&y="+productId,true);
	  xmlhttp.send();
	}

	function showCart() {
  	  //alert("Hello");
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	      document.getElementById("modalDiv").innerHTML=xmlhttp.responseText;
	    }
	  }
	  xmlhttp.open("GET","showCart.php",true);
	  xmlhttp.send();
	}

	function showReturnCash(x){
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	      document.getElementById('returnCashTemp').innerHTML=xmlhttp.responseText;
	      var value = document.getElementById('temp').value;
	      returnAmount= xmlhttp.responseText;
	      minAmount=value-returnAmount;
	      document.getElementById('cash').placeholder="Enter the amount of cash given by the customer. Minimum: "+minAmount;
	      $("#returnCashTemp").val(x);

	    }
	  }
	  xmlhttp.open("GET","showReturnCash.php?x="+x,true);
	  xmlhttp.send();
	}

  </script>
</head>

<body>
	<div>		
			<div id="salesDiv">
				
				<input autocomplete="off" class="form-control" id="productName" name="productName" placeholder="Enter Product Name." required type="text" onclick="showSuggestions()" onkeyup="showProducts(this.value);"> 
				<div id="livesearch"></div>
				<div id="productsDiv"></div>
		    	<div id="cartMessageDiv"></div>

		    	<hr>	   
		    	<div id="leftDiv">
		    	<b><?php showCartNum() ?></b>
		    	</div>
		    	<div id="rightDiv">
		    		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
						<a class="btn btn-sm btn-info" href="#cartForm" role="button" data-toggle="modal" id="newStock" onclick="showCart();">Checkout</a>
						<input class="btn btn-sm btn-danger" type="button" value="Reset" onclick="location.reload();">
						<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
					</form>
				</div>
			</div>

			<div>
				<!--MODAL DIV-->
				<div class="modal fade" id="cartForm">
				  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				  <div class="modal-dialog" id="signinDialog">
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
				          <h4 class="modal-title">Current Cart</h4>
				        </div>

				        <div class="modal-body">
				        	<div id="modalDiv"></div>				        	
				        </div>

				      </div>
				    </div>
				  </form> 
				</div>
				<!--MODAL DIV END-->
	    	</div>
	</div>

</body>

</html>

