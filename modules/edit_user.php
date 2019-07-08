<?php

include 'db_con.php';

if (isset($_POST['uid'])) {
	$uid = $_POST['uid'];
	$uname = $_POST['uname'];
	$umail = $_POST['umail'];
	$nmsid = $_POST['nmsid'];

	$sql = "UPDATE tbl_agent SET user_name = '{$uname}', user_email = '{$umail}', nmsid = '{$nmsid}' WHERE id = {$uid}";

	if ($conn->query($sql)) {
		echo "!Success";
	}else{
		echo "!failed";
	}
}