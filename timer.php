<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Timer</title>
	<?php
		session_start();
		$phpcnt=300;
	?>
    <script type="text/javascript">
	//Timer script
        var check = null;
		var cntfromphp="<?php echo $phpcnt; ?>";
		var cnt=cntfromphp;
        function printDuration() {
            if (check == null) {
                check = setInterval(function () {
					if(cnt>0){
						cnt -= 1;
						document.getElementById("para").innerHTML = cnt;
					}
                }, 1000);
            }
			else  {
				check = setInterval(function () {
					if(cnt>0){
						cnt -= 1;
						document.getElementById("para").innerHTML = cnt;
					}
                }, 1000);
			}
        }

        function stop() {
            clearInterval(check);
            check = null;
            document.getElementById("para").innerHTML = cntfromphp;
			cnt=cntfromphp;
        }
		
		function pause() {
            clearInterval(check);
            document.getElementById("para").innerHTML = cnt;
        }
    </script>
</head>
<body>
    <input id="btnStart" type="button" value="Start"
        onclick="printDuration();" />
    <input id="btnStop" type="button" value="Stop"
        onclick="stop();" />
	<input id="Pause" type="button" value="Pause"
        onclick="pause();" />
	<p id="para"><?php echo $phpcnt; ?></p>
</body>
</html>