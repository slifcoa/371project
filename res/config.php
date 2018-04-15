<?PHP

	session_start();

	$dir_base = $_SERVER['DOCUMENT_ROOT'] . '/371project/';


	/**********************************
	* SECRET KEY (Laughing So Hard My Sombrero Fell Off My Head And It Blew Away In The Wind)
	**********************************/
	$secret_key = "lshmsfomhaibaitw";

	/**********************************
	* URLs
	**********************************/
	$url_login      = "http://bb.dataii.com:8080/webapps/login/";
	$url_student    = "student.php";
	$url_instructor = "instructor.php";

	/**********************************
	* PATHS
	**********************************/
	$path_auth  		 = $dir_base . 'res/authenticate.php'; 
	$path_sql_queries    = $dir_base . "res/sql/sql_queries.php";
	$path_ajax_calls	 = $dir_base . "res/ajax/ajax_calls.php";

	/**********************************
	* DATABASE RESOURCES
	**********************************/
	$db_location = "34.224.83.184";
	$db_username = "student33";
	$db_password = "phppass33";
	$db_database = "student33";

	$db_connection = mysqli_connect($db_location, $db_username, $db_password, $db_database);

	/**********************************
	* Gravatar
	**********************************/
	$default = "mm";
    $email   = $_SESSION['email'];
    $size    = 500;
    $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;

?>