<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Начална страница</title>
	<link href="style/homestyle.css" rel="stylesheet">
</head>
<body>
	<h2>Система за организиране на студентска конференция</h2>
	<form action="" method="post">
		Потребителско име: <input type="text" name="name"><br>
		Парола: <input type="password" name="password" id="pwd"><br>
		<input type="submit" value="Вход">
	</form>
	<?php
		if($_POST){
			$username=$_POST['name'];
			$conn = new PDO('mysql:host=localhost;dbname=wwwprojectdb;charset=utf8', 'root', '');
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