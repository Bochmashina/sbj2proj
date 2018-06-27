<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
	$username = $_SESSION['username'];
	$userid = $_SESSION['id'];
	$studentof = $_SESSION['studentof'];
	$convname=$_GET['category'];
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Конференции</title>
	<link href="style/homestyle.css" rel="stylesheet">
</head>
	<body>
		<h2><?php if(isset($_SESSION['username'])) echo $convname;?></h2>
		<a href="home.php">Назад</a><br>
		<?php
			if($userid<10){
		?>
		<form method="post">
			<br><input type="submit" name="beginconf" value="Начало на конференцията"></input>
			<input type="submit" name="endconf" value="Край на конференцията"></input><br>
		</form>
		<?php
			}
			$conn = new PDO('mysql:host=localhost;dbname=wwwprojectdb;charset=utf8', 'root', '');
			$sql = "SELECT DISTINCT`timeslots`.`FromHour`, `timeslots`.`FromMins`,`timeslots`.`ToHour`,`timeslots`.`ToMins`, `timeslots`.`StudentID`, `timeslots`.`hasStarted`
					FROM `timeslots` INNER JOIN `users` ON `timeslots`.`LecturerID`=`users`.`studentof` AND `timeslots`.`ConvName`='$convname'";
			$query = $conn->query($sql) or die("failed!");
			$studentID=0;
			$enter="Записване";
			$enterbtn="enterbtn";
			$exit="Отписване";
			$exitbtn="exitbtn";
			$submit="submit";
			$post="post";
			$hidden="hidden";
			$fromhour="fromHour";
			$frommins="fromMins";
			$tohour="toHour";
			$tomins="toMins";
			$idchecksql="SELECT * FROM `timeslots` WHERE `StudentID`=$userid AND `ConvName`='$convname'";
			$idcheckq=$conn->query($idchecksql) or die("failed!");
			$idcheck=$idcheckq->fetch()['StudentID']; //Студентът дали не се е записал вече за някой слот
			if($_POST){
				if(!empty($_POST['endconf'])){
					$startsql = "UPDATE `timeslots` SET `hasStarted`=0 WHERE `ConvName`='$convname' AND `LecturerID`='$studentof'";
					$conn->query($startsql) or die ("failed");
					echo "<meta http-equiv='refresh' content='0'>";
				}
				if(!empty($_POST['beginconf'])){
					$startsql = "UPDATE `timeslots` SET `hasStarted`=1 WHERE `ConvName`='$convname' AND `LecturerID`='$studentof'";
					$conn->query($startsql) or die ("failed");
					while($row = $query->fetch()){
						if($row['StudentID']>0){
							$studentID=$row['StudentID'];
							$timeFHour=$row['FromHour'];
							$timeFMins=$row['FromMins'];
							$timeTHour=$row['ToHour'];
							$timeTMins=$row['ToMins'];
							$timermins=$row['ToMins']-$row['FromMins'];
							$timersecs=0;
							echo "<br>$timeFHour:$timeFMins $timeTHour:$timeTMins<br>";
							echo "<b>Номер: $studentID</b><br>";
			?>				
							
			<p style="margin:0.3%"id="para"><?php echo $timermins . " : " . $timersecs;?></p>
			<input id="btnStart" type="button" value="Start" onclick="printDuration();"/>
			<script type="text/javascript">
			//Timer script
				var mins="<?php echo $timermins; ?>";
				var secs="<?php echo $timersecs;?>";
				function printDuration() {
						setInterval(function () {
							if(mins==0){
								if(secs>0){
									secs-=1;
								}
								document.getElementById("para").innerHTML = mins+" : "+secs;
							}
							if(mins>0){
								if(secs==0){
									secs=59;
									mins-=1;	
								}
								else{
									secs -= 1;	
								}
								document.getElementById("para").innerHTML = mins+" : "+secs;
							}
							
						
						}, 1000);
				}
			</script>
			<?php
						}
					}
				}
			}
			while($row = $query->fetch()){
				if($row['hasStarted']==0){ //Convention has NOT started yet
					$studentID=$row['StudentID'];
					$timeFHour=$row['FromHour'];
					$timeFMins=$row['FromMins'];
					$timeTHour=$row['ToHour'];
					$timeTMins=$row['ToMins'];
					if($studentID==0){
						echo "<br>";
						echo "<form method='$post'><input type='$hidden' name='$fromhour' value='$timeFHour'>" . $row['FromHour'] . ":";
						echo "<input type='$hidden' name='$frommins' value='$timeFMins'>" . $row['FromMins'] . " ";
						echo "<input type='$hidden' name='$tohour' value='$timeTHour'>" . $row['ToHour'] . ":";
						echo "<input type='$hidden' name='$tomins' value='$timeTMins'>" . $row['ToMins'] . " ";
						echo "<br>";
						if($idcheck=="" && $userid>=10){
							echo "<input type='$submit' name='$enterbtn' value='$enter'></form>";
							echo "<br>";
						}
					}
					else{
						echo "<br>";
						echo $row['FromHour'] . ":" . $row['FromMins'] . " " . $row['ToHour'] . ":" . $row['ToMins'];
						echo "<br><b>" . "Номер: ". "$studentID</b><br>";
						if($userid==$studentID){
							echo "<form method='$post'><input type='$submit' name='$exitbtn' value='$exit'></form>";
						}
					}
				}
				else{ //Convention has started
					
				}
			}
			if($_POST){
				if(!empty($_POST['enterbtn'])){
					if($userid>=10){
						$postFHour=$_POST['fromHour'];
						$postFMins=$_POST['fromMins'];
						$postTHour=$_POST['toHour'];
						$postTMins=$_POST['toMins'];
						$sql = "UPDATE `timeslots` SET `StudentID`='$userid' WHERE `ConvName`='$convname' AND 
						`FromHour`='$postFHour' AND `FromMins`='$postFMins' AND `ToHour`='$postTHour' AND `ToMins`='$postTMins'";
						$query = $conn->query($sql) or die("failed!");
						echo "<meta http-equiv='refresh' content='0'>";
					}
				}
				if(!empty($_POST['exitbtn'])){
					$sql = "UPDATE `timeslots` SET `StudentID`=0 WHERE `ConvName`='$convname' AND `StudentID`='$userid'";
					$query = $conn->query($sql) or die("failed!");
					echo "<meta http-equiv='refresh' content='0'>";
				}
					
					
			}
		?>
	</body>
</html>