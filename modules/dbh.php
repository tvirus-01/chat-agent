<?php

$query = "CREATE TABLE IF NOT EXISTS `tbl_admin` (
				`id` INT(30) NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(50) NOT NULL,
				`email` VARCHAR(50) NOT NULL,
				`password` VARCHAR(50) NOT NULL,
				`admin_name` VARCHAR(50) NOT NULL,
				`admin_pic` VARCHAR(50) NOT NULL,
				PRIMARY KEY(`id`)	
) ENGINE = InnoDB";

if ($conn->query($query)) {
	$admin = $conn->query("SELECT * FROM tbl_admin WHERE admin_name = 'sudo'");
	$admin_row = mysqli_num_rows($admin);
	if($admin_row != 1){
		$conn->query("INSERT INTO `tbl_admin`(`id`, `name`,`email`, `password`, `admin_name`, `admin_pic`) VALUES(null,'root', 'sudo@email.com', 'root911', 'sudo', '')");
	}
}

$query = "CREATE TABLE IF NOT EXISTS `tbl_agent` (
				`id` INT(30) NOT NULL AUTO_INCREMENT,
				`user_name` VARCHAR(50) NOT NULL,
				`user_email` VARCHAR(50) NOT NULL,
				`user_pass` VARCHAR(50) NOT NULL,
				`user_pic` VARCHAR(50) NOT NULL,
				`user_phone` VARCHAR(50) NOT NULL,
				`user_skype` VARCHAR(50) NOT NULL,
				`emergency_contact` VARCHAR(50) NOT NULL,
				`nmsid` VARCHAR(10) NOT NULL,
				PRIMARY KEY(`id`)	
) ENGINE = InnoDB";
$conn->query($query);

$query = "CREATE TABLE IF NOT EXISTS `tbl_daily_production` ( `id` INT(50) NOT NULL AUTO_INCREMENT , `date` VARCHAR(10) NOT NULL , `userid` INT(30) NOT NULL , `num_of_mssg` INT(50) NOT NULL , `rate` FLOAT(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
$conn->query($query);