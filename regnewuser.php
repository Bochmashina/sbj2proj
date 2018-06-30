<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("Location:login.php");
	}
	$userid=$_SESSION['id'];
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<title>Регистриране на нов потребител</title>
		<link href="style/style.css" rel="stylesheet">
	</head>
	<body>
		<h2>Регистриране на нов потребител</h2>
		<form id="regform" action="" method="post">
			Потребителско име: <input id="name" type="text" name="name" required><br>
			Парола: <input id="pass" type="text" name="password" id="pwd" required><br>
			Уникален номер на студента: <input id="id" type="text" name="studentid" required><br>
			<input id="regsubmitBtn" type="submit" value="Регистриране">
		</form>
		<?php
			if($_POST){
				$uname=$_POST['name'];
				$pwd=$_POST['password'];
				$studentid=$_POST['studentid'];
				$samecount=0;
					
				$conn = new PDO('mysql:host=localhost;dbname=wwwprojectdb;charset=utf8', 'root', '');
				$sql = "SELECT * FROM `users`";
				$query = $conn->query($sql) or die("failed!");
				while($row = $query->fetch()){
					if($row['Username']==$uname || $row['id']==$studentid){
						$samecount +=1;
						break;
					}
				}
				if($samecount==1){ //има такова id или потр.име в таблицата
					echo "Вече съществува потребител с такова потр. име или ID";
				}
				else{
					if($studentid<10){
						echo "Уникалният номер на студента трябва да е >= 10";
					}
					else{
						$hash = password_hash($pwd, PASSWORD_DEFAULT);
						$sql = "INSERT INTO `users` VALUES ('$uname','$hash','$studentid','$userid')";
						$conn->query($sql) or die("failed!");
					}
				}
			}
		?>
		<a href="home.php">Назад</a>
	</body>
</html>