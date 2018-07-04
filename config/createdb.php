<?php
	$ini_array = parse_ini_file("config.ini");
	$dbhost=$ini_array['host'];
	$dbname=$ini_array['name'];
	$dbcharset=$ini_array['charset'];
	$dbuser=$ini_array['user'];
	$dbpass=$ini_array['password'];
	try {
		$conn = new PDO('mysql:host='.$dbhost.'', $dbuser, $dbpass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

		$conn->exec($sql);
		echo "Created DB <br>";
    }
	catch(PDOException $e)
	{
		echo "Failed creating DB <br>" . $e->getMessage();
    }
	$parolata=password_hash('parolata',PASSWORD_DEFAULT);
	$asdf=password_hash('asdf',PASSWORD_DEFAULT);
	$tablesql="CREATE TABLE IF NOT EXISTS `conventions` (
		`Name` varchar(200) NOT NULL,
		`LecturerID` int(1) NOT NULL,
		`LecturerUName` varchar(15) NOT NULL,
		`Timer` int(2) NOT NULL,
		`FromHour` int(2) NOT NULL,
		`ToHour` int(2) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
		CREATE TABLE IF NOT EXISTS`timeslots` (
	  `ConvName` varchar(200) NOT NULL,
	  `FromHour` int(2) NOT NULL,
	  `FromMins` int(2) NOT NULL,
	  `ToHour` int(2) NOT NULL,
	  `ToMins` int(2) NOT NULL,
	  `LecturerID` int(1) NOT NULL,
	  `StudentID` int(3) NOT NULL,
	  `hasStarted` tinyint(1) NOT NULL DEFAULT '0'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
		CREATE TABLE IF NOT EXISTS`users` (
	  `Username` varchar(15) NOT NULL,
	  `Password` varchar(500) NOT NULL,
	  `id` int(3) NOT NULL,
	  `studentof` int(3) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	
		INSERT IGNORE INTO `conventions` (`Name`, `LecturerID`, `LecturerUName`, `Timer`, `FromHour`, `ToHour`) VALUES
	('Представяне на реферати', 1, 'lecturer1', 10, 9, 17);
	
		INSERT IGNORE INTO `timeslots` (`ConvName`, `FromHour`, `FromMins`, `ToHour`, `ToMins`, `LecturerID`, `StudentID`, `hasStarted`) VALUES
	('Представяне на реферати', 9, 0, 9, 10, 1, 0, 0),
	('Представяне на реферати', 9, 10, 9, 20, 1, 0, 0),
	('Представяне на реферати', 9, 20, 9, 30, 1, 0, 0),
	('Представяне на реферати', 9, 30, 9, 40, 1, 0, 0),
	('Представяне на реферати', 9, 40, 9, 50, 1, 0, 0),
	('Представяне на реферати', 9, 50, 10, 0, 1, 0, 0),
	('Представяне на реферати', 10, 0, 10, 10, 1, 0, 0),
	('Представяне на реферати', 10, 10, 10, 20, 1, 0, 0),
	('Представяне на реферати', 10, 20, 10, 30, 1, 0, 0),
	('Представяне на реферати', 10, 30, 10, 40, 1, 0, 0),
	('Представяне на реферати', 10, 40, 10, 50, 1, 0, 0),
	('Представяне на реферати', 10, 50, 11, 0, 1, 0, 0),
	('Представяне на реферати', 11, 0, 11, 10, 1, 0, 0),
	('Представяне на реферати', 11, 10, 11, 20, 1, 0, 0),
	('Представяне на реферати', 11, 20, 11, 30, 1, 0, 0),
	('Представяне на реферати', 11, 30, 11, 40, 1, 0, 0),
	('Представяне на реферати', 11, 40, 11, 50, 1, 0, 0),
	('Представяне на реферати', 11, 50, 12, 0, 1, 0, 0),
	('Представяне на реферати', 12, 0, 12, 10, 1, 0, 0),
	('Представяне на реферати', 12, 10, 12, 20, 1, 0, 0),
	('Представяне на реферати', 12, 20, 12, 30, 1, 0, 0),
	('Представяне на реферати', 12, 30, 12, 40, 1, 0, 0),
	('Представяне на реферати', 12, 40, 12, 50, 1, 0, 0),
	('Представяне на реферати', 12, 50, 13, 0, 1, 0, 0),
	('Представяне на реферати', 13, 0, 13, 10, 1, 0, 0),
	('Представяне на реферати', 13, 10, 13, 20, 1, 0, 0),
	('Представяне на реферати', 13, 20, 13, 30, 1, 0, 0),
	('Представяне на реферати', 13, 30, 13, 40, 1, 0, 0),
	('Представяне на реферати', 13, 40, 13, 50, 1, 0, 0),
	('Представяне на реферати', 13, 50, 14, 0, 1, 0, 0),
	('Представяне на реферати', 14, 0, 14, 10, 1, 0, 0),
	('Представяне на реферати', 14, 10, 14, 20, 1, 0, 0),
	('Представяне на реферати', 14, 20, 14, 30, 1, 0, 0),
	('Представяне на реферати', 14, 30, 14, 40, 1, 0, 0),
	('Представяне на реферати', 14, 40, 14, 50, 1, 0, 0),
	('Представяне на реферати', 14, 50, 15, 0, 1, 0, 0),
	('Представяне на реферати', 15, 0, 15, 10, 1, 0, 0),
	('Представяне на реферати', 15, 10, 15, 20, 1, 0, 0),
	('Представяне на реферати', 15, 20, 15, 30, 1, 0, 0),
	('Представяне на реферати', 15, 30, 15, 40, 1, 0, 0),
	('Представяне на реферати', 15, 40, 15, 50, 1, 0, 0),
	('Представяне на реферати', 15, 50, 16, 0, 1, 0, 0),
	('Представяне на реферати', 16, 0, 16, 10, 1, 0, 0),
	('Представяне на реферати', 16, 10, 16, 20, 1, 0, 0),
	('Представяне на реферати', 16, 20, 16, 30, 1, 0, 0),
	('Представяне на реферати', 16, 30, 16, 40, 1, 0, 0),
	('Представяне на реферати', 16, 40, 16, 50, 1, 0, 0),
	('Представяне на реферати', 16, 50, 17, 0, 1, 0, 0);

		INSERT IGNORE INTO `users` (`Username`, `Password`, `id`, `studentof`) VALUES
	('lecturer1', '$parolata', 1, 1),
	('lecturer2', '$parolata', 2, 2);
	
		ALTER TABLE `users`
	ADD UNIQUE KEY `id` (`id`);
		
		ALTER TABLE `conventions`
	ADD UNIQUE KEY `Name` (`Name`);
	
	
	";
	
	try {
		$conn = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset='.$dbcharset. '', $dbuser, $dbpass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->query($tablesql);
		echo "Created tables";
    }
	catch(PDOException $e)
	{
		echo "Failed creating tables" . $e->getMessage();
	}
	
?>

