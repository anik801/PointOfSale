<?php
	ob_start();
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>  
  <link rel="stylesheet" type="text/css" href="apiFiles/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="apiFiles/bootstrap-theme.css">
  <script type="text/javascript" src="apiFiles/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="apiFiles/bootstrap.js"></script>
  <script type="text/javascript" src="apiFiles/bootbox.js"></script>
  <script type="text/javascript" src="apiFiles/sorttable.js"></script>

  <link rel="icon" href="images/icon.ico">
  <link rel="stylesheet" type="text/css" href="css/pageStyle.css">
  <script type="text/javascript" src="scripts/myscripts.js"></script>
</head>

<body>	
	<div id="loginMainDiv" class="container">
	<div>
		
		<div id="loginTitleDiv"></div>
		<hr>
		<p id="loginText">Please login to continue.</p>		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<div>
			<input type="text" name="username" class="form-control" placeholder="Enter your username.">
			<input type="password" name="password" class="form-control" placeholder="Enter your password.">
		</div>
		<hr>
		<div id="rightDiv">
			<input type="submit" name="submit" value="Log In" class="btn btn-info">
			<input type="reset" value="Reset" class="btn btn-danger">
		</div>
		</form>
	</div>
	</div>
</body>

</html>


<?php
	require 'myConnection.php';

	if(isset($_SESSION['id'])){
		$id=$_SESSION['id'];
		$sql="SELECT * FROM accounts WHERE account_id='$id'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		if(mysql_num_rows($result)){
			header('Location: panel.php');
		}
	}

	$sql="SELECT company_name FROM company";
	$result=mysql_query($sql);
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	$row=mysql_fetch_array($result);
	$companyName=$row['company_name'];

	echo"
	<script>
		setTitle('$companyName');
	</script>";

	if(isset($_POST['submit'])){
		$username=$_POST['username'];
		$password=$_POST['password'];

		$sql="SELECT * FROM accounts WHERE employee_name='$username' AND password='$password'";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}
		if(mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
			//echo $row['account_id'];
			$_SESSION['id']=$row['account_id'];
			header('Location: panel.php');
		}else{
			session_destroy();
			echo"
			<script>
			alert('Username or password incorrect.');			
			window.location.href='login.php';
			</script>";	
		}
	}
?>
