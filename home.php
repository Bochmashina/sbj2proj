<?php
	session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<title>Конференции</title>
		<link href="style/homestyle.css" rel="stylesheet">
	</head>
	<body>
		<h2>Конференции</h2>
		<?php
			$convlink="convention.php?category=";
			$username = $_SESSION['username'];
			$userid = $_SESSION['id'];
			$studentof = $_SESSION['studentof'];
			
			$conn = new PDO('mysql:host=localhost;dbname=wwwprojectdb;charset=utf8', 'root', '');
			$sql = "SELECT * FROM `conventions` WHERE `LecturerID`='$studentof'";
			$query = $conn->query($sql) or die("failed!");

			while($row = $query->fetch())
			{
				if($row['LecturerID']==$studentof)
				{
					$coname=$row['Name'];
					echo "<a href='$convlink$coname'>" . $row['Name'] . "</a>";
					echo "<br>";
				}
			}
			if($userid < 10)
			{
				$link="convcreator.php";
				$link2="regnewuser.php";
				echo "<br>";
				echo "<a href='$link'>Създаване на конференция</a>";
				echo "<br>";
				echo "<a href='$link2'>Регистриране на потребител</a>";
			}
		?>
	</body>
</html>