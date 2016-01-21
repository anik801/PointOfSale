<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';
?>

<!DOCTYPE html>
<html>

<head>
  <title>Return Product</title> 
  <script type="text/javascript">
  //AJAX functions dynamic changes.
  	function showBillProducts() {
  	  var id=$("#invoiceId").val();
  	  var str=$("#type").val();

  	  //alert(str+id);
	  if (str==='0') {
	    document.getElementById("productsDiv").innerHTML="Please select a type.";
	    return;
	  }else{ 
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
		  
		  //alert(id);
		  if(str==='1'){
		  	//alert(id);
		  	xmlhttp.open("GET","showBillProducts.php?q="+id,true);
		  }else if(str==='2'){
		  	//alert("sdfdsf");
		  	xmlhttp.open("GET","showReturnBills.php?q="+id,true);
		  }
		  xmlhttp.send();
	  }
	}  

  </script>
</head>

<body>
	<div>		
			<div id="returnDiv">			
				<div style="display:inline-block;width:59%;vertical-align: top">	
					<input autocomplete="off" class="form-control" id="invoiceId" name="invoiceId" placeholder="Enter Bill Number and select a type on the left." required type="text"> 
				</div>
				<div style="display:inline-block;width:30%;vertical-align: top">
					<select class="form-control" id="type" name="type"> 
						<option value="0">Please select an option.</option>
						<option value="1">Return product</option>
						<option value="2">Show previous</option>
					</select>
				</div>
				<div style="display:inline-block;width:9%;vertical-align: top">	
					<input class="btn btn-sm btn-info" type="button"  onclick="showBillProducts();" value="CHECK"> 
				</div>

				<div id="productsDiv"></div>

		    	<hr>	   
		    	<div id="rightDiv">
					<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
				</div>
			</div>
	</div>

</body>

</html>

