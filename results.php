<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Результаты</title>
</head>

<body>


<?php 
	session_start();
	$conn = connect_to_db();
	
	if (!empty($_POST["dayspoll"]) && !empty($_SESSION['user_info'])) {
		$user_info = $_SESSION['user_info'];
		$uid = $user_info['uid'];
		$firstName = $user_info['firstName'];
		$lastName = $user_info['lastName'];
		$photo = $user_info['photo'];
		if (didntVote($uid)) {
			foreach ($_POST["dayspoll"] as $vote) {
				$sql = "INSERT INTO dayspoll ".
					"(uid, firstName, lastName, photo, vote)".
					"VALUES ".
					"('$uid','$firstName','$lastName','$photo','$vote')";
				$result = mysql_query($sql);
				if (!$result) {
					echo "Error: " . mysql_error();
				}
			}
		}
	}
	show_results();	
		
	mysql_close($conn);	
?> 
<table>
<tr>


</body>
</html>

<?php
function connect_to_db() {
	$servername = "localhost:3306";
	$username = "1037233";//"root";
	$password = "timpofwh";//"";
	$conn = mysql_connect($servername, $username, $password);
	mysql_select_db("1037233");//dayspoll
	return $conn;
}

function didntVote($uid) {
	$sql = "SELECT * FROM dayspoll WHERE uid='" . $uid."'";
	$result = mysql_query($sql);
	if (!$result) {
		echo "Error: " . mysql_error();
	}
	if (mysql_num_rows($result) > 0) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function show_results() {
	$ruEN = [
		["Понедельник", "mo"],
		["Вторник", "tu"],
		["Среда", "we"],
		["Четверг", "th"],
		["Пятница", "fr"],
		["Суббота до обеда", "saMorning"],
		["Суббота после обеда", "saAfternoon"],
		["Суббота вечером", "saEvening"],
		["Воскресенье до обеда", "suMorning"],
		["Воскресенье после обеда", "suAfternoon"],
		["Воскресенье вечером", "suEvening"],
	];
	echo "<h3>Результаты</h3><br>";
	echo "<table>";
	
	$img = "img/poll.gif";
	$sql = "SELECT DISTINCT firstName, lastName FROM dayspoll";
	$result = mysql_query($sql);
	if (!$result) {
		echo "Error: " . mysql_error();
	}
	$votesTotal = mysql_num_rows($result);
	for ($i = 0; $i < 11; $i++) {
		echo "<tr>";
		echo "<td align='right'>" . $ruEN[$i][0] . "</td>";
		$sql = "SELECT * FROM dayspoll WHERE vote='" . $ruEN[$i][1] . "'";
		$result = mysql_query($sql);
		if (!$result) {
			echo "Error: " . mysql_error();
		}
		$votes = mysql_num_rows($result);
		if ($votesTotal == 0) {
			$percent = 0;
		} else {
			$percent = round($votes/$votesTotal, 2);
		}
		echo "<td><img src='" . $img . "' width='" . ($percent * 500) . "' height='15' align='bottom'> " . ($percent * 100) . "%</td>";
		echo "</tr>";
		echo "<tr height='25'>";
		echo "<td></td>";
		echo "<td>";
		while($row = mysql_fetch_assoc($result)) {
			$uid = $row['uid'];
			$photo = $row['photo'];
			echo "<a href='https://vk.com/id" . $uid . "'><img src=" . $photo . " width='25' height='25'></a>";
		}
		echo "</td>";
		echo "</tr><tr height='5'></tr>";
	}
	echo "</table>";
}

/*if (!$conn) {
		die('Could not connect: ' . mysql_error());
	} else {
		mysql_select_db("dayspoll");
		$sql = 'SELECT * FROM dayspoll';
		$result = mysql_query($sql);
		if(!$result) {
			die('error: ' . mysql_error());
		} else {
			$num = mysql_num_rows($result);
			while($row = mysql_fetch_assoc($result)) {
				echo "ID :{$row['id']}  <br> ".
					 "uid: {$row['uid']} <br> ".
					 "firstName: {$row['firstName']} <br> ".
					 "LastName: {$row['lastName']} <br> ".
					 "photo: {$row['photo']} <br> ".
					 "vote: {$row['vote']} <br> ".
					 "--------------------------------<br>";
			} 
			echo "Fetched data successfully\n";
		}
		mysql_close($conn);
	}
	"INSERT INTO dayspoll".
	"(uid, firstName, lastName, photo, vote)".
	"VALUES".
	"('$uid','$firstName','$lastName','$photo','$vote')"
	$sql = "INSERT INTO tutorials_tbl ".
		   "(tutorial_title,tutorial_author, submission_date) ".
		   "VALUES ".
		   "('$tutorial_title','$tutorial_author','$submission_date')";*/
?>

