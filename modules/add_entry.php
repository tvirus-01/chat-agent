<?php

include 'db_con.php';

if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$num_of_mssg = $_POST['num_of_mssg'];

	$rate = '';
	if ($num_of_mssg < 200) {
		$rate = $num_of_mssg * 0.02;
	}elseif ($num_of_mssg == 200) {
		$rate = 5;
	}elseif ($num_of_mssg > 200 && $num_of_mssg < 400) {
		$rate = 5;
		$num_of_mssg_sub = $num_of_mssg - 200;
		$rate += $num_of_mssg_sub * 0.02;
	}elseif ($num_of_mssg == 400){
		$rate = 10;
	}elseif ($num_of_mssg > 400 && $num_of_mssg < 600) {
		$rate = 10;
		$num_of_mssg_sub = $num_of_mssg - 400;
		$rate += $num_of_mssg_sub * 0.02;
	}
	//elseif ($num_of_mssg > 250) {
	// 	$rate = $num_of_mssg * 0.028;
	// }elseif ($num_of_mssg == 250) {
	// 	$rate = 7;
	// }

	//echo '$'.$rate.' : '.$num_of_mssg;

	$sql = "UPDATE `tbl_daily_production` SET `num_of_mssg` = '{$num_of_mssg}', `rate` = '{$rate}' WHERE `id` = {$id}";

	if ($conn->query($sql)) {
		echo "!Success";
	}
}