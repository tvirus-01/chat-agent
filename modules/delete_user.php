<?php

include 'db_con.php';

if (isset($_POST['uid'])) {
	$uid = $_POST['uid'];
	
	$query = "SELECT * FROM tbl_daily_production WHERE userid = {$uid}";
	$metas = $conn->query($query);
	foreach ($metas as $meta) {
		$metaid = $meta['id'];
		$sql = "DELETE FROM `tbl_daily_production` WHERE `id` = {$metaid}";
		$conn->query($sql);
	}
	$sql = "DELETE FROM `tbl_agent` WHERE `id` = {$uid}";

	if ($conn->query($sql)) {
		echo 'Success';
	}else{
		echo "Failed";
	}
}
