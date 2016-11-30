<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Множественное голосование</title>
</head>

<body>

<?php
	
	$app_id = "5086242";
	$app_secret = "y1J3iK2fiMz7ZQlOCpXy";
	$my_url = "http://voting.freetzi.com/index.php";
	$users_get_url = "https://api.vk.com/method/users.get";
	$authorize_url = "https://oauth.vk.com/authorize";
	$access_token_url = "https://oauth.vk.com/access_token";

	session_start();
	//test();
	
	$code = $_REQUEST["code"];
	if (empty($code)) {
		echo "Авторизация...";
		$dialog_url = $authorize_url . '?client_id='.$app_id . '&scope=offline&display=page&redirect_uri=' . $my_url . '&response_type=code';
		echo("<script> top.location.href='" . $dialog_url . "'</script>");
	} else {
		$token_url =  $access_token_url . '?client_id=' . $app_id . '&client_secret=' . $app_secret . '&redirect_uri=' . $my_url . '&code=' . $code . '';
		$token = get_and_decode($token_url);
		//print_r($token);
		$user_url = $users_get_url . '?user_ids=' . $token->user_id . '&fields=photo';
		$user = get_and_decode($user_url);
		$userResponse = $user->response[0];
		if ($userResponse->uid != '') {
			$user_info = [
				"uid" => $userResponse->uid,
				"firstName" => $userResponse->first_name,
				"lastName" => $userResponse->last_name,
				"photo" => $userResponse->photo,
			];
			$_SESSION['user_info'] = $user_info;
			
			$conn = connect_to_db();
			$sql = sprintf("SELECT * FROM dayspoll WHERE uid='%s'", mysql_real_escape_string($user_info['uid']));
			$result = mysql_query($sql);
			if (!$result) {
				echo "Error: " . mysql_error();
			}
			if (mysql_num_rows($result) == 0) {
				echo "<a href='poll.php'><h3>Голосование</h3></a>";
			}
			
			echo "<br><a href='results.php'><h3>Результаты</h3></a>";
			
			mysql_close($conn);
		} else {
			echo "<h3>Ошибка авторизации</h3>";
		}
	}

	function connect_to_db() {
		$servername = "localhost:3306";
		$username = "1037233";
		$password = "timpofwh";
		$conn = mysql_connect($servername, $username, $password);
		mysql_select_db("1037233");
		return $conn;
	}
	
	function test() {
		$user_info = [
			"uid" => '285904',
			"firstName" => 'Timur',
			"lastName" => 'Nurmagambetov',
			"photo" => 'http://cs09.vk.me/u285904/e_fce7b2c9.jpg',
		];
		$_SESSION['user_info'] = $user_info;
		
		$conn = connect_to_db();
		$sql = sprintf("SELECT * FROM dayspoll WHERE uid='%s'", mysql_real_escape_string($user_info['uid']));
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0) {
			$link = "results.php"; // did vote
			echo "voted";
		} else {
			$link = "poll.php";
			echo "didnt vote";
		}
		echo "<a href='" . $link . "'>Голосование</a>";
		mysql_close($conn);
		exit();
	}

	function get_and_decode($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		return json_decode($data);
	}
	
?>
</body>
</html>
