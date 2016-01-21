<html>
<head>
	<script type="text/javascript" src="apiFiles/jquery-1.10.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/pageStyle.css">
  	<script type="text/javascript" src="scripts/myscripts.js"></script>
</head>
</html>

<?php
	$currentDate=date("Y-m-d H:i:s",time()+14400);
	echo $currentDate;

	echo "
	<script>
		OpenInNewTab(9);
	</script>
	";
?>