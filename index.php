<?php
$path = '';
require_once 'modules/db_con.php';
require_once 'modules/dbh.php';
if (isset($_COOKIE['client']) && isset($_COOKIE['client_type'])) {
	$client = $_COOKIE['client'];
	$type = $_COOKIE['client_type'];

	if ($type == 'admin' ) {
		header('Location: templates/dashboard/admin/admin_dashboard.php');
	}elseif ($type == 'agent') {
		header('Location: templates/dashboard/user/user_dashboard.php');		
	}else{
		include 'templates/login.php';
	}
}else{
	include 'header.php';
	include 'templates/login.php';
	include 'footer.php';
}