<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Създаване на конференция</title>
	<link href="style/style.css" rel="stylesheet">
</head>
<body>
	<h2>Създаване на конференция</h2>
	<form id="creatorform" action="" method="post">
		Име на конфренецията: <input id="name" type="text" name="Name" required><br>
		Големина на слота: <input id="slot" type="text" name="Timer" required><br>
		Начало на конфренецията: <input id="begin" type="text" name="FromHour" required><br>
		Край на конфренецията: <input id="end" type="text" name="ToHour" required><br>
		<input id="createsubmitBtn" type="submit" value="Създаване">
	</form>
	<?php
		if(!empty($_POST['Name']) && !empty($_POST['Timer']) && !empty($_POST['FromHour']) && !empty($_POST['ToHour']))
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
				echo "<br>";
			}
			else{
				if(($convtimer/60) > ($convtohour-$convfromhour)){
					echo "Големината на слота разделя конференцията на еднакви слотове. Не може да е по-голяма от времетраенето на конференцията";
					echo "<br>";
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
								'$slottohour','$slottomins','$userid','0','0');";
						$slotfrommins=$slottomins;
						$convfromhour=$slottohour;
							
					}
					$result=$conn->query($sql) or die ("failed!");
					header("Location: home.php");
					}
				}
		}

	?>
	<a href="home.php">Назад</a>
</body>
</html>