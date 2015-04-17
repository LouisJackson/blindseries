<?php 	

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Connexion variables
	define('DB_HOST','mysql51-73.perso');
	define('DB_NAME','louisami111');
	define('DB_USER','louisami111');
	define('DB_PASS','9fBz7203W7jt');
	define('apikey','caac8cf02d2de0f116a96aeb3b26aafe');
	try
	{
	    // Try to connect to database
	    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);

	    // Set fetch mode to object
	    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	}
	catch (Exception $e)
	{
	    // Failed to connect
	    die('Could not connect');
	}

	function api_get($path,$params = array ()) {
		$params['api_key'] = apikey;
		$query = http_build_query($params);
		$url = 'http://api.themoviedb.org/3/'.$path.'?'.$query;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result);
		return $result;
	}
