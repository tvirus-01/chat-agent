<?php

include 'db_con.php';

if (isset($_POST['username'])) {
	$username = $_POST['username'];
	$usermail = $_POST['usermail'];
	$nmsid = $_POST['nmsid'];

	$str = 'abCdeFGHij1234590';
	$userpass = str_shuffle($str);

	$sql = "INSERT INTO `tbl_agent` (`id`, `user_name`, `user_email`, `user_pass`, `user_pic`, `user_phone`, `user_skype`, `emergency_contact`, `nmsid`) VALUES (NULL, '{$username}', '{$usermail}', '{$userpass}', '', '', '', '', '{$nmsid}')";

	if ($conn->query($sql)) {
		echo "!".$username." successfully added";
	}
}