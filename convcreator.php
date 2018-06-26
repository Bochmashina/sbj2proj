<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Създаване на конференция</title>
	<link href="style/homestyle.css" rel="stylesheet">
</head>
<body>
	<h2>Създаване на конференция</h2>
	<form action="" method="post">
		Име на конфренецията: <input type="text" name="Name"><br>
		Големина на слота: <input type="text" name="Timer"><br>
		Начало на конфренецията: <input type="text" name="FromHour"><br>
		Край на конфренецията: <input type="text" name="ToHour"><br>
		<input type="submit">
	</form>
	<?php
		if($_POST)
		{ 		
			$username = $_SESSION['username'];
			$userid = $_SESSION['id'];
				
			$convname=$_POST['Name'];
			$convtimer=$_POST['Timer'];
			$convfromhour=$_POST['FromHour'];
			$convtohour=$_POST['ToHour'];
			if($convfromhour>=$convtohour)
			{
				echo "Краят на конференцията трябва да е СЛЕД началото!";
			}
			else{
				if(($convtimer/60) > ($convtohour-$convfromhour)){
					echo "Големината на слота разделя конференцията на еднакви слотове. Не може да е по-голяма от времетраенето на конференцията";
				}
				else{
					$conn = new PDO('mysql:host=localhost;dbname=wwwprojectdb;charset=utf8', 'root', '');
					$sql = "INSERT INTO `conventions` VALUES ('$convname','$userid','$username','$convtimer','$convfromhour','$convtohour');";
					$slotfrommins=0;
					$slottomins=0;
					$slottohour=$convfromhour;
					while((($convfromhour*60)+$slotfrommins+$convtimer)<=($convtohour*60)){
						$slottomins=$slotfrommins+$convtimer;
						if($slottomins>=60){
							$slottomins = $slottomins%60;
							$slottohour+=1;
						}
						$sql .= "INSERT INTO `timeslots` VALUES ('$convname','$convfromhour','$slotfrommins',
								'$slottohour','$slottomins','$userid','0');";
						$slotfrommins=$slottomins;
						$convfromhour=$slottohour;
							
					}
					$result=$conn->query($sql);
					header("Location: home.php");
					}
				}
		}
	?>
	<a href="home.php">Назад</a>
</body>
</html>