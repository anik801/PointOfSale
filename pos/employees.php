<?php
	ob_start();
	require 'mask.php';	
	require 'loginCheck.php';
	require 'ownerCheck.php';

	if(isset($_POST['employeeSubmit'])){
		$name=$_POST['employeeName'];	
		$phone=$_POST['employeePhone'];
		$address=$_POST['employeeAddress'];
		$nationalId=$_POST['employeeNationalId'];
		$password=$_POST['employeePassword'];
		$isAdmin=$_POST['accountType'];

		$sql="INSERT INTO accounts (employee_name,employee_phone,employee_address,employee_national_id,password,is_admin) values ('$name','$phone','$address','$nationalId','$password','$isAdmin')";
		$result=mysql_query($sql);
		if (!$result) {
		    die('Invalid query: ' . mysql_error());
		}		
	}

	$adminId=$_SESSION['id'];

	$sql="SELECT * FROM accounts WHERE account_id!='$adminId' AND (is_admin='0' OR is_admin>(SELECT is_admin FROM accounts WHERE account_id='$adminId')) ORDER BY is_admin";
	$result=mysql_query($sql);
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	if(mysql_num_rows($result)){
		echo "
		<div id='tableTitleDiv'>
		Employees List
		</div>
		";
		echo"		
		<table class='table table-responsive sortable'>
			<thead>
				<tr>
					<td>Name</td>
					<td>Phone No.</td>
					<td>Address</td>
					<td>National ID</td>
					<td>Password</td>
					<!--<td>Action</td>-->
					<td>Account Type</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
		";
		while($row=mysql_fetch_array($result)){
			$name=$row['employee_name'];
			$phone=$row['employee_phone'];
			$address=$row['employee_address'];
			$nationalId=$row['employee_national_id'];
			$password=$row['password'];
			$id=$row['account_id'];
			$typeNo=$row['is_admin'];
			if($typeNo==='0'){
				$type="Employee";
			}else if($typeNo==='1'){
				$type="Admin";
			}else if($typeNo==='2'){
				$type="Owner";
			}else if($typeNo==='3'){
				$type="Supervisor";
			}else{
				$type="N/A";
			}
			echo "
				<tr>
					<td>$name</td>
					<td>$phone</td>
					<td>$address</td>
					<td>$nationalId</td>
					<td>$password</td>
					<!--<td><a class='btn btn-xs btn-info' href='#employeeChangeForm' role='button' data-toggle='modal' onClick='checkEmployeeChangeInput($id);'>MODIFY</a></td>-->
					<td>$type</td>
					<td><input type='button' value='DELETE' onclick='deleteEmployee($id);' class='btn btn-danger btn-xs'></td>
				</tr>
			";
		}
		echo"
			</tbody>
		</table>
		";
	}else{
		echo "No employees found.<br>";
	}

?>

<!DOCTYPE html>
<html>

<head>
  <title>User Accounts</title>  
</head>

<body>
	<div id="tableButtons">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<a class="btn btn-sm btn-info" href="#employeeForm" role="button" data-toggle="modal" id="createNewCategoryButton">Create New User Account</a>
			<a href="javascript:history.back()" class="btn btn-warning btn-sm">Back</a>
		</form>

	</div>	


	<div class="modal fade" id="employeeForm">
	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	  <div class="modal-dialog" id="signinDialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	          <h4 class="modal-title">Create New User Account</h4>
	        </div>

	        <div class="modal-body">
	          <input class="form-control" id="employeeName" name="employeeName" placeholder="Enter employee name. This will be the login username." required type="text" value="" autocomplete="off">
	          <input class="form-control" id="employeePhone" name="employeePhone" placeholder="Enter phone number." required type="text" value="" autocomplete="off">
	          <input class="form-control" id="employeeAddress" name="employeeAddress" placeholder="Enter address." required type="text" value="" autocomplete="off">
	          <input class="form-control" id="employeeNationalId" name="employeeNationalId" placeholder="Enter national identification number." required type="text" value="" autocomplete="off">
	          <input class="form-control" id="employeePassword" name="employeePassword" placeholder="Enter Desired password. At least 8 digits." required type="password" value="" autocomplete="off">	 
	          <input class="form-control" id="employeeRePassword" name="employeeRePassword" placeholder="Enter password again." required type="password" value="" autocomplete="off">
			<?php
				if(isset($_SESSION['id'])){
			        require 'myConnection.php';
			        $id=$_SESSION['id'];
			        $sql="SELECT is_admin FROM accounts WHERE account_id='$id'";
			        $result=mysql_query($sql);
			        if (!$result) {
			            die('Invalid query: ' . mysql_error());
			        }
			        $row=mysql_fetch_array($result);
			        $level=$row['is_admin'];
			        if($level==='1'){
			        	echo "
			        	<select class='form-control' name='accountType'>
			        		<option value='0'>Employee</option>
			        		<option value='3'>Supervisor</option>
			        		<option value='2'>Owner</option>
			        	</select>
			        	";
			        }else if($level==='2'){
			        	echo "
			        	<select class='form-control' name='accountType'>
			        		<option value='0'>Employee</option>
			        		<option value='3'>Supervisor</option>
			        	</select>
			        	";
			        }
			    }
			?>	          
	        </div>


	        <div class="modal-footer">
	          <a href="#" data-dismiss="modal" class="btn btn-default">Close</a>      
	          <input type="button" class="btn btn-primary" value="Create" onclick="checkEmployeeInput();">
	          <input type="submit" id="employeeSubmit" name ="employeeSubmit" style="display:none">     
	        </div>
	      </div>
	    </div>
	  </form> 
	</div>

	<div class="modal fade" id="employeeChangeForm">
	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	  <div class="modal-dialog" id="signinDialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	          <h4 class="modal-title">Edit User Account</h4>
	        </div>

	        <div class="modal-body">
	          <input class="form-control" id="employeeChangeName" value="" name="employeeChangeName" placeholder="Enter employee name. This will be the login username." required type="text">
	          <input class="form-control" id="employeeChangePhone" value="" name="employeeChangePhone" placeholder="Enter phone number." required type="text">
	          <input class="form-control" id="employeeChangeAddress" value="" name="employeeChangeAddress" placeholder="Enter address." required type="text">
	          <input class="form-control" id="employeeChangeNationalId" value="" name="employeeChangeNationalId" placeholder="Enter national identification number." required type="text">
	          <input class="form-control" id="employeeChangePassword" value="" name="employeeChangePassword" placeholder="Enter Desired password. At least 8 digits." required type="password">	 
	          <input class="form-control" id="employeeChangeRePassword" value="" name="employeeChangeRePassword" placeholder="Enter password again." required type="password"> 
	          <input id="employeeChangeId" name="employeeChangeId" value="" required type="text" style="display:none">        
	        </div>


	        <div class="modal-footer">
	          <a href="#" data-dismiss="modal" class="btn btn-default">Close</a>      
	          <input type="button" class="btn btn-primary" value="Create" onclick="checkEmployeeChangeInput();">
	          <input type="submit" id="employeeChangeSubmit" name ="employeeChangeSubmit" style="display:none">     
	        </div>
	      </div>
	    </div>
	  </form> 
	</div>

</body>

</html>