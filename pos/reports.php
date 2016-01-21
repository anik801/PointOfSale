<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';
  require 'supervisorCheck.php';
  
	if(isset($_POST['reportSubmit'])){
		$type=$_POST['reportType'];
		$date1=$_POST['startingDate'];
		$date2=$_POST['endingDate'];

		header("Location: showReport.php?type=$type&d1=$date1&d2=$date2");
	}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Reports</title>  
  <script src="apiFiles/jquery-ui.js"></script>
  <link rel="stylesheet" href="apiFiles/jquery-ui.css">
</head>

<body>	
	<div id="reportDiv">
    <div id="reportTitle">
      Report Query
    </div>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  			<p><b>Starting Date:</b> <input type="text" name="startingDate" id="startingDate" class="form-control" placeholder="Click to select starting date."></p>
  			<p><b>Ending Date:</b> <input type="text" name="endingDate" id="endingDate" class="form-control" placeholder="Click to select ending date."></p>
  			<p><b>Report on:</b>
  			<select id='reportType' name="reportType" class="form-control">
  				<option value="sales">Sales</option>
  				<option value="stocks">Stocks</option>
  			</select>
  			</p>

  			<p>
  			<input type="button" value="Show Report" onclick="checkReport();" class="btn btn-info btn-sm">
        <input type="reset" value="Reset" class="btn btn-danger btn-sm">
        <a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
  			<input type="submit" name="reportSubmit" id="reportSubmit" style="display:none">
  			</p>
    	</form>
	</div>
</body>

</html>