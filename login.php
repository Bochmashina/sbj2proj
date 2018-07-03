<?php
	session_start();
	$ini_array = parse_ini_file("config/config.ini");
	$dbhost=$ini_array['host'];
	$dbname=$ini_array['name'];
	$dbcharset=$ini_array['charset'];
	$dbuser=$ini_array['user'];
	$dbpass=$ini_array['password'];
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Начална страница</title>
	<link href="style/style.css" rel="stylesheet">
</head>
<body>
	<h2>Система за организиране на студентска конференция</h2>
	<form id="loginform" action="" method="post">
		Потребителско име: <input type="text" name="name"><br>
		Парола: <input type="password" name="password" id="pwd"><br>
		<input class="submitBtn" type="submit" value="Вход">
	</form>
	<?php
		if($_POST){
			$username=$_POST['name'];
			$conn = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset='.$dbcharset. '', $dbuser, $dbpass);
			$sql = "SELECT * FROM `users` WHERE `Username`='$username'";
			$query = $conn->query($sql) or die("failed!");
			$row = $query->fetch();
			if(password_verify($_POST['password'],$row['Password'])){
				$_SESSION['id']=$row['id'];
				$_SESSION['username']=$row['Username'];	
				$_SESSION['studentof']=$row['studentof'];	
				header("Location: home.php");	
			}
			else{
				echo "Грешно потребителско име или парола";
			}
		}
	?>
</body>
</html>