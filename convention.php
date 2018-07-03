<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
	$username = $_SESSION['username'];
	$userid = $_SESSION['id'];
	$studentof = $_SESSION['studentof'];
	$convname=$_GET['category'];
	$ini_array = parse_ini_file("config/config.ini");
	$dbhost=$ini_array['host'];
	$dbname=$ini_array['name'];
	$dbcharset=$ini_array['charset'];
	$dbuser=$ini_array['user'];
	$dbpass=$ini_array['password'];
?>
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<meta charset="UTF-8">
		<title>Конференции</title>
		<link href="style/style.css" rel="stylesheet">
	</head>
	<body>
		<h2><?php if(isset($_SESSION['username'])) echo $convname;?></h2>
		<a href="home.php">Назад</a><br>
		<div id="popUp" align="center">
			Този див казва колко време остава (напр: 2 минути, 1 минута)
		</div>
		<?php
			if($userid<10){
		?>
		<form id="convform" method="post">
			<input id="begin" type="submit" name="beginconf" value="Начало на конференцията"></input><br>
			<input id="end" type="submit" name="endconf" value="Край на конференцията" onclick="save()"></input><br>
		</form>
		<?php
			}
			$conn = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset='.$dbcharset. '', $dbuser, $dbpass);
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
				<p style="margin:0.3%" id="<?php echo $studentID;?>"><?php echo $timermins . " : " . $timersecs;?></p>
				<input type="button" id="<?php echo $studentID;?>.btn" value="Старт" onclick="printDuration(this.id)"/><br>
				<textarea id="<?php echo $studentID;?>.txtarea"><?php echo $studentID;?>: </textarea>
				<br>
				Оценка:			
				<select>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
				<select>
				<br>
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
					if($userid>=10){
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
						}
					}
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
		
		<script type="text/javascript">
			//Timer script
				var popUp = document.getElementById("popUp");
				var showPopUp = function(timeLeft) {
					popUp.textContent = "Остават още " + timeLeft + " минути.";
					popUp.style.display = "block";
					setTimeout(function() {
					hidePopUp()
					}, 2000);
				};
				var hidePopUp = function() {
				popUp.style.display = "none";
				};
				function printDuration(id) {
					var win=window.open('', 'Timer');
					win.document.body.style.fontSize = "1500%";
					win.document.body.style.textAlign= "center";
					var winpara=document.createElement('p');
					win.document.body.appendChild(winpara);
					var mins="<?php echo $timermins; ?>";
					var secs="<?php echo $timersecs;?>";
					setInterval(function () {
						if(mins==2 && secs==1){
							showPopUp(2);
						}
						if(mins==1 && secs==1){
							showPopUp(1);
						}
						if(mins==0){
							if(secs>0){
								secs-=1;
							}
							document.getElementById(id.split(".")[0]).innerHTML = mins+" : "+secs;
							win.document.body.innerHTML = mins+" : "+secs;
						}
						if(mins>0){
							if(secs==0){
								secs=59;
								mins-=1;	
							}
							else{
								secs -= 1;	
							}
							document.getElementById(id.split(".")[0]).innerHTML = mins+" : "+secs;
							win.document.body.innerHTML = mins+" : "+secs;
						}
					
					}, 1000);
			    }
				
				function save() {
				var commasv="";
				var lecturer=<?php echo $userid;?>;
				var today=new Date();
				var textareas = document.getElementsByTagName('textarea');
				var selects = document.getElementsByTagName("select");
				for(var i = 0; i < textareas.length; i++) {
					var studid=textareas[i].value.split(":")[0];
					var comments=textareas[i].value.split(":")[1];
					commasv+=studid + ";" + comments + ";" + selects[i].options[selects[i].selectedIndex].value + ";" + today + ";" + lecturer + "\r\n";
				}
                var a = document.createElement('a');
                with (a) {
                    href='data:text/csv;charset=utf-8,%EF%BB%BF' + commasv;
                    download='<?php echo $convname;?>' + '.csv';
                }
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
			</script>
	</body>
</html>