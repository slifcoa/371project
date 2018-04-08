<?php

	session_start();
	
	// Get all constants from config file.
    include '../../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

	// Set variables for easy access.
	$post_id = $_POST['entry_name']; 
	
	// Construct the query.
$query = <<<SQL

	SELECT *
	FROM project_comments
	WHERE post_id = {$post_id}

SQL;

	// Perform the query.
    $r = mysqli_query($db_connection, $query);


    // Array of all comments returned by the database.
    $array_comments_all = array();

    // Loop through each row returned by the database.
    // Insert needed information into array holding data
    // for all the comments.
    while($row = mysqli_fetch_array($r)) {

    	$array_comments_all[] = array(

    		'entry_id'   => $row['post_id'],
    		'author'     => $row['user_name'],
    		'story'      => $row['comment'],
    		'date'       => $row['date'],
    		'comment_id' => $row['comment_id']

    	);	    				
    }

    // Ajax call, return json of all comments gathered.
    echo json_encode($array_comments_all);

?>