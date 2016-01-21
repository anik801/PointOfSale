<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';
	require 'adminCheck.php';

	if(isset($_POST['companyEditSubmit'])){
		$name=$_POST['name'];

		$sql="UPDATE company SET company_name='$name' WHERE 1";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		echo "<script>window.location.reload();</script>";
	}
	function showName(){
		$sql="SELECT company_name FROM company WHERE 1";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		$row=mysql_fetch_array($result);
		$var=$row['company_name'];
		echo $var;
	}

?>


<!DOCTYPE html>
<html>

<head>
  <title>Company Information</title>  
</head>

<body>	
	<div id="accountEditDiv">
		<div>
			<h2><p align="center">Company Information</p></h2>
		</div>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" required name="myForm">
			<table class="table table-responsive">
			<tbody>
				<tr>
					<td><b>Company Name: </b></td>
					<td><input type="text" class="form-control" value="<?php showName(); ?>" id="name" required name="name"></td>
				</tr>
			</tbody>
			</table>
			<div id="rightDiv">
				<input class="btn btn-sm btn-info" type="submit" name="companyEditSubmit" id="companyEditSubmit" value="Change Name">				
				<input class="btn btn-sm btn-danger" type="button" value="Reset" onclick="location.reload();">
				<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
			</div>
		</form>			
		
	</div>
</body>

</html>