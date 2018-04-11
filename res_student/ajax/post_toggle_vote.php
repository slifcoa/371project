<?php

	session_start();

	// Get all constants from config file.
    include_once '../../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

	// Set variables for easy access.
	$post_id   = $_POST['post_id'];
	$course_id =  $_SESSION['course_id'];
	$user_id   =  $_SESSION['user_id'];

	// Construct the query. Did the user upvote already. 
$query = <<<SQL

	SELECT 1 
	FROM project_upvotes
	WHERE (course_id = '{$course_id}') and (post_id = '{$post_id}') and (user_id = '{$user_id}')

SQL;

	// Check the number of rows returned from the database. Zero rows = upvote | One row = downvote.
    if (mysqli_num_rows(mysqli_query($db_connection, $query)) < 1) {
    	$upvotes_text = "DOWNVOTE";

$query = <<<SQL

	INSERT INTO project_upvotes (course_id, post_id, user_id)
	VALUES ('{$course_id}', {$post_id}, '{$user_id}')

SQL;
    	// Perform the query.
    	mysqli_query($db_connection, $query);
    }
    else {
    	$upvotes_text = "UPVOTE";

$query = <<<SQL

	DELETE FROM project_upvotes 
	WHERE (course_id = '{$course_id}') and (post_id = '{$post_id}') and (user_id = '{$user_id}')

SQL;
    	// Perform the query.
    	mysqli_query($db_connection, $query);
    }

    // get the total number of upvotes for the post.
    $upvotes_total = include 'post_get_total_votes.php';

    // Construct array to hold total upvotes and vote option text.
    $myArray = array(
    	'upvotes_total' => $upvotes_total,
    	'upvotes_text'  => $upvotes_text
    );

    // Ajax call, return total upvaotes and current vote text option.
    echo json_encode($myArray);
	 
?>