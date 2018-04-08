<?PHP

	session_start();

	// Get all constants from config file.
    include '../../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

	// Set variables for easy access.
	$post_id = $_POST['post_id'];

	// Construct the query.
$query = <<<SQL

	SELECT COUNT(comment) AS num_comments
	FROM project_comments
	WHERE post_id = "{$post_id}"

SQL;
	 
	// Perform the query.
    $result = mysqli_query($db_connection, $query);

    // Get row as array.
    $row = mysqli_fetch_array($result);

    // Ajax call, return number of comments.
    echo $row['num_comments'];
	
?>