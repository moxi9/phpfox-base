<?php

$process = curl_init($_SERVER['HTTP_API_ENDPOINT'] . 'user');
curl_setopt($process, CURLOPT_HEADER, false);
curl_setopt($process, CURLOPT_USERPWD, $_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']);
curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($process);
curl_close($process);

$users = json_decode($response);
?><html>
	<head>
		<title>PHPfox Base Api Test</title>
	</head>
	<body>
<?php
	foreach ($users as $user) {
		echo '<div class="row">';
		echo '<div class="row-10">' . $user->id . '</div>';
		echo '<div class="row-70">' . $user->name . '</div>';
		echo '</div>';
	}
?>
	</body>
</html>