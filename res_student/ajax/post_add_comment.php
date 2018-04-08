<?PHP

	session_start();
	
	// Get all constants from config file.
    include '../../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);
	

	$comment    = $_POST['comment'];
	$entry_post = $_POST['post_id'];

	$course_id  = $_SESSION['course_id'];
	$user_id    = $_SESSION['user_id'];
	$user_name  = $_SESSION['user_name'];

	$query = <<<SQL

	INSERT INTO project_comments (course_id, post_id, user_id, date, comment, user_name)
	VALUES ("{$course_id}", {$entry_post}, "{$user_id}", NOW(), "{$comment}", "{$user_name}")

SQL;

	$r = mysqli_query($db_connection, $query);

	echo '';


?>