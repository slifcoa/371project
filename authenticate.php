<?php

	session_start();

	include 'config.php';

	if (empty($_SESSION['secret_key'])) { 
		
		header('Location: '. $url_login);
		die();

	} 
	elseif ($_SESSION['secret_key'] != $secret_key) {
		
		header('Location: '. $url_login);
		die();

	}

?>