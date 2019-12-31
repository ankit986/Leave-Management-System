<?php
	// Retrieving values from textboxes
	
	$staff_id = $_GET['staff_id'];
	
	/*$first_name = $_POST['first_name'];
	$middle_name = $_POST['middle_name'];
	$last_name = $_POST['last_name'];
	$email_id = $_POST['email_id'];
	$password = $_POST['password'];
	$user_type = "Staff";*/
	
	// Initializing the values, following DRY (Don't Repeat Yourself) Approach
	$dsn_name = "lms";
	$db_user = "root";
	$db_pass = "";
	
	// Obtaining connection using DSN and ODBC
	$connection = odbc_connect($dsn_name, $db_user, $db_pass);
	
	// Sql query
	$sql1 = "SELECT * FROM staff WHERE staff_id = '".$staff_id."'";
	$sql2 = "SELECT password FROM login WHERE user_id = '".$staff_id."'"; 
	
	
	// Firing query
	$result1 = odbc_exec($connection, $sql1);
	$result2 = odbc_exec($connection, $sql2);
	/*$affected_rows = odbc_affected_rows($result);	// Obtaining the number of rows affected
	echo $affected_rows;	*/						// Printing nuber of rows affected
	if(odbc_num_rows($result1) == 0)
	{
		echo 	"<script>
				alert(\"Staff ID ".$staff_id." does not exist !\");
				window.location=\"search_staff_for_updation.php\";</script>";
	}
	while($row1 = odbc_fetch_array($result1))
	{
		$first_name = $row1['first_name'];
		$middle_name = $row1['middle_name'];
		$last_name = $row1['last_name'];
	}
	while($row2 = odbc_fetch_array($result2))
	{
		$password =  $row2['password'];
	}
	// Closing Connection
	odbc_close($connection);
	
?>
<?php
	session_start();
	if($_SESSION['sid'] == session_id() && $_SESSION['user'] == "admin")
	{
		?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Staff</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../images/bg.gif);
}
</style>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="container">
  <div id="header">
    <div id="title">Leave Management System</div>
    <div id="quick_links">
   	  <ul>
        	<li><a class="home" href="index.php">Home</a></li>
            <li>|</li>
          
        <li><a class="logout" href="../logout.php">Logout</a></li>
         <li>|</li>
        <li><a class="greeting" href="#">Hi <?php echo $_SESSION['user']; ?></a></li>
      </ul>
    </div>
  </div>
  <div id="content_panel">
    <div id="heading">Update Staff<hr size="2" color="#FFFFFF" ice:repeating=""/></div>
    <form action="update_staff_db.xphp" method="post">
     <p>
        <label for="staff_id" ><span>Staff ID </span><span class="db_data"> <?php echo $staff_id; $_SESSION['staff_id'] = $staff_id; ?></span></label>
      </p>
        <label for="full_name" ><span>Name </span>
        <input type="text" name="first_name" id="first_name" value="<?php echo $first_name ?>" required="required"/>
      <input type="text" name="middle_name" id="middle_name" value="<?php echo $middle_name?>" />
      <input type="text" name="last_name" id="last_name" value="<?php echo $last_name ?>" required="required"/>
        <!--<input type="text" value="<?php echo $first_name ." ". $middle_name ." ". $last_name ?>" required="required"/> --> 
          <!--<span class="db_data"><?php echo $first_name ." ". $middle_name ." ". $last_name ?></span>-->
        </label>
        <label for="password" ><span>Password </span><input type="text" name="password" id="password" value="<?php echo $password ?>" required="required" />
         <!--<span class="db_data"> <?php echo $password ?></span><span class="edit">Edit</span> -->
        </label>
      <label>
          <input type="submit" value="Save Changes" />
        </label>
    </form>
  </div>
  <div id="side_bar">
  	<ul>
    	<li class="menu_head">Controls</li>
        <li><a href="add_staff.php">Add Staff</a></li>
        <li><a href="search_staff_for_updation.php">Update Staff</a></li>
        <li><a href="search_staff_for_deletion.php">Delete Staff</a></li>
    	<li><a href="add_leave.php">Add Leave</a></li>
        <li><a href="delete_leave_type.php">Delete Leave</a></li>
        <li><a href="search_staff_to_assign_pc.php">Assign HOD</a></li>
    </ul>
  </div>
  <div id="footer">
  	<p><br />LMS</p>
  </div>
</div>
</body>
</html>
<?php
	}
	else
	{
		header("Location: ../index.html");
	}
?>
