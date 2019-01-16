<?php
	//$y = $_GET['y'];
	//$m = $_GET['m'];
	$d = $_GET['d'];
	//echo $d;

	$servername = "localhost";
	$username = "ABCalender";
	$password = "password";
	$dbname = "abcalender";

	$conn = mysqli_connect($servername, $username, $password, $dbname); // Create connection

	if (!$conn) {
		die("Connection failed <br>"); // Check connection
	}
	//echo("Connection seccess <br>");

	//$day = date("l", $d);
	$firstDay = date('2018-09-06'); //first day of school
	$lastDay = date('2019-06-21'); //last day of school
	$findDay = date($d); //day we are finding
	$day = date('w', strtotime($findDay));
	
	$daysOffBetween = 0;
	$off = 0;

	if($day == "6"|| $day == "0"){
		echo("<br>It's a weekend!");
	}
	elseif (strtotime($findDay) > strtotime($lastDay)||strtotime($findDay) < strtotime($firstDay)){
		echo("<br>Summer Break!");
	}
	else{
		$sql = "SELECT * FROM daysoff";
		$result = mysqli_query($conn, $sql);
		while($row = $result->fetch_assoc()){
			if( strtotime($findDay) > strtotime($row['day']) ) {
				$daysOffBetween++;
			}
			if ($findDay == $row['day']){
				echo("<br>".$row['reason']);
				$off = 1;
			}
		}
		//echo $daysOffBetween . "<br>";
		if($off == 0){
			$holder1 = strtotime($findDay);
			$holder2 = strtotime($firstDay);

			$dateDiff = $holder1 - $holder2;
			$dateDiff = round($dateDiff / (60*60*24));
			$dateDiff = $dateDiff - $daysOffBetween;

			if($dateDiff % 2 == 1){
				echo("<br>It is a B day!");
			}else{
				echo("<br>It is an A day!");
			}
		}
	}

	mysqli_close($conn);
?>