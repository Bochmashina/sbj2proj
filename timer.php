<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Timer</title>
	<?php
		session_start();
		$timermins=10;
		$timersecs=0;
		$post="post";
		$hidden="hidden";
		$mins="mins";
		$secs="secs";
		$para="para";
		$submit="submit";
		$enterbtn="enterbtn";
		$enter="Enter";
		$onclick="printDuration();";
		echo "<form method='$post'>";
		echo "<input type=$hidden name='$mins' value='1'>";
		echo "<input type=$hidden name='$secs' value='5'>";
		echo "<br>";
		echo "<input type='$submit' name='$enterbtn' value='$enter' onclick='$onclick'></form>";
		echo "<br>";
		if($_POST){
			$timermins=$_POST['mins'];
			$timersecs=$_POST['secs'];
		}
	?>
    <script type="text/javascript">
	//Timer script
		var cntfromphp="<?php echo $timermins; ?>";
		var secs="<?php echo $timersecs;?>";
		var cnt=cntfromphp;
		function printDuration() {
                setInterval(function () {
					if(cnt==0){
						if(secs>0){
							secs-=1;
						}
						document.getElementById("para").innerHTML = cnt+" : "+secs;
					}
					if(cnt>0){
						if(secs==0){
							secs=59;
							cnt-=1;	
						}
						else{
							secs -= 1;	
						}
						document.getElementById("para").innerHTML = cnt+" : "+secs;
					}
					
				
                }, 1000);
        }
		
        // function printDuration() {
            // if (check == null) {
                // check = setInterval(function () {
					// if(cnt>0){
						// if(secs==0){
							// secs=59;
							// cnt-=1;
						// }
						// else{
							// secs -= 1;	
						// }
						
						// document.getElementById("para").innerHTML = cnt+" : "+secs;
					// }
                // }, 1000);
            // }
			// else  {
				// check = setInterval(function () {
					// if(cnt>0){
						// if(secs==0){
							// secs=59;
							// cnt-=1;
						// }
						// else{
							// secs -= 1;	
						// }
						
						// document.getElementById("para").innerHTML = cnt+" : "+secs;
					// }
                // }, 1000);
			// }
        // }

        // function stop() {
            // clearInterval(check);
            // check = null;
            // document.getElementById("para").innerHTML = cntfromphp;
			// cnt=cntfromphp;
        // }
		
		// function pause() {
            // clearInterval(check);
            // document.getElementById("para").innerHTML = cnt;
        // }
    </script>
</head>
<body>
   <!-- <input id="btnStart" type="button" value="Start"
        onclick="printDuration();" />
    <input id="btnStop" type="button" value="Stop"
        onclick="stop();" />
	<input id="Pause" type="button" value="Pause"
        onclick="pause();" />-->
		<input id="btnStart" type="button" value="Start"
        onclick="printDuration();" />
	<p id="para"><?php echo $timermins . " : " . $timersecs;?></p>
</body>
</html>