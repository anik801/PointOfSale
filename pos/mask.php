<?php
  ob_start();
  session_start();

  if(isset($_POST['logOutButton'])){
    session_destroy();
    header('Location:index.php');
  }

  function showTitle(){
    require 'myConnection.php';
    $sql="SELECT company_name FROM company";
    $result=mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
    $row=mysql_fetch_array($result);
    $companyName=$row['company_name'];

    echo $companyName;
  }
  function showLogOutButton(){
    if(isset($_SESSION['id'])){
      echo '<input type="button" class="btn btn-sm btn-danger" role="button" id="signOutButton" value="Log Out" onClick="logOut();" /></p>';
    }
  }
?>

<!DOCTYPE html>
<html>

<head>  
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
  <div class="hiddenDiv">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <input type="submit" id="logOutButton" name="logOutButton"> 
    </form>
  </div>

  <div id="header">
    <a href="panel.php" id="titleText"><?php showTitle(); ?></a>  
    <div id="logOutDiv"><?php showLogOutButton(); ?></div>

  <div id="ribonBar">
  <div id="ribons">
    <a href="sale.php">
      <img src="images/sale.png">
      <div>Sale Products</div>
    </a>    

    <a href="returnProduct.php">
      <img src="images/returnProduct.png">
      <div>Return Product</div>
    </a>

    <a href="stocks.php">
      <img src="images/stocks.png">
      <div>Stocks</div>
    </a>

    <a href="products.php">
      <img src="images/products.png">
      <div>Products</div>
    </a>    

    <a href="bill.php">
      <img src="images/bills.png">
      <div>Bills</div>
    </a>

    <a href="accountSettings.php">
      <img src="images/accountSettings.png">
      <div>Personal Settings</div>
    </a>
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

        if($row['is_admin']==='1'){
          echo'
    <a href="reports.php">
      <img src="images/reports.png">
      <div>Reports</div>
    </a>

    <a href="categories.php" id="categories">
      <img src="images/categories.png">
      <div>Categories</div>
    </a>

    <a href="types.php">
      <img src="images/types.png">
      <div>Types</div>
    </a>

    <a href="customers.php">
      <img src="images/customers.png">
      <div>Customers</div>
    </a>

    <a href="employees.php">
      <img src="images/employees.png">
      <div>User Accounts</div>
    </a>

    <a href="companySettings.php">
      <img src="images/company.png">
      <div>Company Settings</div>
    </a>
          ';
        }else if($row['is_admin']==='2'){
          echo'
    <a href="reports.php">
      <img src="images/reports.png">
      <div>Reports</div>
    </a>

    <a href="categories.php" id="categories">
      <img src="images/categories.png">
      <div>Categories</div>
    </a>

    <a href="types.php">
      <img src="images/types.png">
      <div>Types</div>
    </a>

    <a href="customers.php">
      <img src="images/customers.png">
      <div>Customers</div>
    </a>

    <a href="employees.php">
      <img src="images/employees.png">
      <div>User Accounts</div>
    </a>
          ';
        }else if($row['is_admin']==='3'){
          echo'
    <a href="reports.php">
      <img src="images/reports.png">
      <div>Reports</div>
    </a>

    <a href="categories.php" id="categories">
      <img src="images/categories.png">
      <div>Categories</div>
    </a>

    <a href="types.php">
      <img src="images/types.png">
      <div>Types</div>
    </a>

    <a href="customers.php">
      <img src="images/customers.png">
      <div>Customers</div>
    </a>
          ';
        }
      }
    ?>

    

  </div>
  </div>

  </div>
  <div id="footerDiv">
    Developped by <span id="footerSpan">HAUNTED</span>
  </div>
</body>

</html>
