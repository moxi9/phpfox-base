<?php

// Small curl function to call our API
function call($endpoint) {
	// When the client contacts us they send the endpoint URL.
	$process = curl_init($_SERVER['HTTP_API_ENDPOINT'] . $endpoint);
	curl_setopt($process, CURLOPT_HEADER, false);
	curl_setopt($process, CURLOPT_USERPWD, $_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($process);
	curl_close($process);

	return json_decode($response);
}

// Get a list of users
$users = call('user');

// Connect to our own API route to get the sites menu
$menu = call('PHPfox_Base');

?><html>
	<head>
		<title>PHPfox Base Api Test</title>
	</head>
	<body>
		<!-- Special API tag for PHPfox -->
		<api>
			<!-- Add the section title -->
			<section>
				<name>PHPfox Base App</name>
				<url>/base</url>
			</section>
			<!-- Add the h1 -->
			<h1>
				<name>External Controller</name>
				<url>/base/external-controller</url>
			</h1>
			<!-- Add the sub section menu -->
			<menu><?php echo $menu->menu; ?></menu>
		</api>
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