<?PHP

	session_start();

	// Get all constants from config file.
    include_once '../../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    include_once $path_sql_queries;

    switch ($_POST['use_case']) {
    	
    	case 'select_post_vote_total':
    		echo sql_select_post_vote_total($_POST['post_id']);
    		break;
    	
    	case 'select_post_comment_total':
    		echo sql_select_post_comment_total($_POST['post_id']);
    		break;
    	
    	case 'select_post_all':
    		echo sql_select_post_all($_POST['post_id']);
    		break;
    	
    	case 'select_post_vote_status':
    		echo sql_select_post_vote_status($_POST['post_id']);
    		break;

    	case 'post_toggle_vote':
    		$votes_text;
    		if (sql_select_post_vote_status($_POST['post_id']) < 1){
    			sql_insert_post_vote($_POST['post_id']);
    			$votes_text = "DOWNVOTE";

    		}
    		else {
    			sql_delete_post_vote($_POST['post_id']);
    			$votes_text = "UPVOTE";
    		}
    		$votes_total = sql_select_post_vote_total($_POST['post_id']);

    		$myArray = array(
    			'votes_total' => $votes_total,
    			'votes_text'  => $votes_text
    		);

			echo json_encode($myArray);

    		break;

    	case 'post_comments_all':
		    $return_data = array();
    		$results = sql_select_post_comment_all($_POST['post_id']);
		    while($row = mysqli_fetch_array($results)) {

		    	$return_data[] = array(

		    		'entry_id'   => $row['post_id'],
		    		'author'     => $row['user_name'],
		    		'story'      => $row['comment'],
		    		'date'       => $row['date'],
		    		'comment_id' => $row['comment_id']

		    	);	    				
		    }
		    echo json_encode($return_data);
    		break;

    	case 'post_add_comment':
    		sql_insert_post_comment($_POST['post_id'], $_POST['comment']);
    		echo "";
    		break;
    
    	default:
    		echo '';
    		break;
    }

?>