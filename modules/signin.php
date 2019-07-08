<?php

require_once 'db_con.php';
if(isset($_POST['username'])) {
	$uname = $_POST['username'];
	$upass = $_POST['password'];

	$query = "SELECT * FROM tbl_admin WHERE admin_name = '{$uname}' AND password = '{$upass}'";
	$result = $conn->query($query);
	$count = mysqli_num_rows($result);

	$query2 = "SELECT * FROM tbl_agent WHERE user_name = '{$uname}' AND user_pass = '{$upass}'";
	$result2 = $conn->query($query2);
	$count2 = mysqli_num_rows($result2);

	if ($count == 1) {
		$admin = htmlentities($uname);
		setcookie('client', $admin, time()+93600, '/');
		setcookie('client_type', 'admin', time()+93600, '/');
		header('Location: ../templates/dashboard/admin/admin_dashboard.php');
		//echo $_COOKIE['client'];
	}elseif ($count2 == 1) {
		$user = htmlentities($uname);
		setcookie('client', $user, time()+93600, '/');
		setcookie('client_type', 'agent', time()+93600, '/');
		header('Location: ../templates/dashboard/user/user_dashboard.php');
	}else{
		header('Location: ../index.php?error=91');
	}
}else{
	header('location: ../index.php');
}