
<?php

	session_start();

	// Get all constants from config file.
    include '../../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

	// Set variables for easy access.
	$post_id   = $_POST['post_id'];
	$course_id = $_SESSION['course_id'];

	// Construct the query.
$query = <<<SQL

	SELECT COUNT(*) AS num_upvotes
	FROM project_upvotes
	WHERE (course_id = "{$course_id}") AND (post_id = "{$post_id}") 

SQL;

	// Perform the query.
	$result = mysqli_query($db_connection, $query);
	
	// Get row as array.
	$row = mysqli_fetch_array($result);

	// Return based on Ajax vs Include call.
	if (!empty($_POST['echo'])) {
		echo $row['num_upvotes'];
	}
	else {
		return $row['num_upvotes'];
	}

?>