<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
	$ini_array = parse_ini_file("config/config.ini");
	$dbhost=$ini_array['host'];
	$dbname=$ini_array['name'];
	$dbcharset=$ini_array['charset'];
	$dbuser=$ini_array['user'];
	$dbpass=$ini_array['password'];
?>

<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<title>Начало</title>
		<link href="style/style.css" rel="stylesheet">
	</head>
	<body>
		<h2>Конференции</h2>
		<?php
			$convlink="convention.php?category=";
			$username = $_SESSION['username'];
			$userid = $_SESSION['id'];
			$studentof = $_SESSION['studentof'];
			
			$conn = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset='.$dbcharset. '', $dbuser, $dbpass);
			$sql = "SELECT * FROM `conventions` WHERE `LecturerID`='$studentof'";
			$query = $conn->query($sql) or die("failed!");

			while($row = $query->fetch())
			{
				if($row['LecturerID']==$studentof)
				{
					$coname=$row['Name'];
					echo "<a href='$convlink$coname'>" . $coname . "</a>";
					echo "<br>";
				}
			}
			echo "<br>";
			if($userid < 10)
			{
				$link="convcreator.php";
				$link2="regnewuser.php";
				$link3="regmanyusers.php";
				echo "<br><br><br>";
				echo "<a href='$link'>Създаване на конференция</a>";
				echo "<br><br>";
				echo "<a href='$link2'>Регистриране на един студент</a>";
				echo "<br><br>";
				echo "<a href='$link3'>Регистриране на много студенти (csv)</a>";
				echo "<br><br>";
			}
		?>
		<form method="post">
			<input id="homesubmitBtn" type="submit" name="logout" value="Изход">
		</form>
		<?php
			if($_POST){
				if(!empty($_POST['logout'])){
					session_destroy();
					header("Location:login.php");
				}
			}
		?>
	</body>
</html>