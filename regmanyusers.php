<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("Location:login.php");
	}
	$userid=$_SESSION['id'];
	$ini_array = parse_ini_file("config/config.ini");
	$dbhost=$ini_array['host'];
	$dbname=$ini_array['name'];
	$dbcharset=$ini_array['charset'];
	$dbuser=$ini_array['user'];
	$dbpass=$ini_array['password'];
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<title>Регистриране на студенти</title>
		<link href="style/style.css" rel="stylesheet">
	</head>
	<body>
		<h2>Регистриране на студенти</h2>
		<form id="regformmany" action="" method="post">
			Относителен път до csv файла: <input id="name" type="text" name="name" required><br>
			<input id="regmanyBtn" type="submit" value="Регистриране">
		</form>
		<?php
			if(!empty($_POST['name'])){
				$path=$_POST['name'];
				$conn = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset='.$dbcharset. '', $dbuser, $dbpass);
				$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				$row=0;
				$sql="";
				if (($handle = fopen($path, "r")) !== FALSE) {
					while (($data = fgetcsv($handle, 500, ",")) !== FALSE) {
						$row++;
						if($row==1) continue;
						$newuserarr=explode(';',$data[0]);
						$newusername=$newuserarr[0];
						if($newusername<10) continue;
						$newuserpass= password_hash($newuserarr[1], PASSWORD_DEFAULT);
						$sql = "INSERT IGNORE INTO `users` VALUES ('$newusername','$newuserpass','$newusername','1');";
						$conn->query($sql) or die("failed!");
					}
					fclose($handle);
				}
			}
		?>
		<a href="home.php">Назад</a>
	</body>
</html>