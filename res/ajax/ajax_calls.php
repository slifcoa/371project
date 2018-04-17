<?PHP

	session_start();

	// Get all constants from config file.
    include_once '../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    include_once $path_sql_queries;

    switch ($_POST['use_case']) {
    	
        /**********************************************************************
        * Return the number of votes for a post.
        **********************************************************************/
    	case 'select_post_vote_total':
    		echo sql_select_post_vote_total($_POST['post_id']);
    		break;
    	
        /**********************************************************************
        * Return the number of comments for a post.
        **********************************************************************/
    	case 'select_post_comment_total':
    		echo sql_select_post_comment_total($_POST['post_id']);
    		break;
    	
        /**********************************************************************
        * Return all the posts for the course.
        **********************************************************************/
    	case 'select_post_all':
    		echo sql_select_post_all();
    		break;
    	
        /**********************************************************************
        * Return the vote status (voted=1 or didn't=0) for a post.
        **********************************************************************/
    	case 'select_post_vote_status':
    		echo sql_select_post_vote_status($_POST['post_id']);
    		break;

        /**********************************************************************
        * Toggle the vote status of a post.
        **********************************************************************/
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

        /**********************************************************************
        * Return all the comments for a post.
        **********************************************************************/
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

        /**********************************************************************
        * Add a comment to a post.
        **********************************************************************/
    	case 'post_add_comment':
    		sql_insert_post_comment($_POST['post_id'], $_POST['comment']);
    		echo "";
    		break;

        /**********************************************************************
        * Add a comment to a post.
        **********************************************************************/
        case 'insert_post':

            global $db_connection;
            $title       = mysqli_real_escape_string($db_connection, $_POST['title']);
            $description = mysqli_real_escape_string($db_connection, $_POST['description']);
            $link        = mysqli_real_escape_string($db_connection, $_POST['link']);
            $type        = mysqli_real_escape_string($db_connection, $_POST['type']);
            
            sql_insert_post($title, $description, $link, $type);
            echo "";
            break;


        /**********************************************************************
        * Add a comment to a post.
        **********************************************************************/
        case 'types_as_percent':

            $data = [];
            $data[] = sql_count_by_type("website");
            $data[] = sql_count_by_type("book");
            $data[] = sql_count_by_type("article");
            $data[] = sql_count_by_type("video");
            
            echo json_encode($data);
            break;

        /**********************************************************************
        * Add a comment to a post.
        **********************************************************************/
        case 'upvotes_per_type':

            $data = [];
            $data[] = sql_upvote_count_by_type("website");
            $data[] = sql_upvote_count_by_type("book");
            $data[] = sql_upvote_count_by_type("article");
            $data[] = sql_upvote_count_by_type("video");
            
            echo json_encode($data);
            break;



    /**********************************************************************
    * Show 3 most popular posts.
	***********************************************************************/
	case 'get_top_posts_upvotes':
		$posts = sql_top_3_posts(' project_upvotes ','user_id' ,3);
        $data[] = [];
		
		while($row = mysqli_fetch_array($posts)){

            $data[] = $row['title'];
	    }
		
        echo json_encode($data);
	    	  
	   break;

    /**********************************************************************
    * Show 3 most popular posts.
    ***********************************************************************/
    case 'get_top_posts_comments':
        $posts = sql_top_3_posts(' project_comments ',' post_id ', 3);
        $data[] = [];
        
        while($row = mysqli_fetch_array($posts)){

            $data[] = $row['title'];
        }
        
        echo json_encode($data);
              
       break;

    /**********************************************************************
    * Show 3 most popular posts.
    ***********************************************************************/
    case 'get_top_posts2':
        $posts = sql_select_post_all();
        $tempSizeCurrent = 0;

        $tempSize1 = 0;
        $post_one = "a";
        $tempSize2 = 0;
        $post_two = "b";
        $tempSize3 = 0;
        $post_three = "c";
        // get every post
        while($row = mysqli_fetch_array($posts)){
            // get the size of the current post
            $tempSizeCurrent = intval(sql_select_post_vote_total($row['post_id']));
                
            // check if the size is greater than the current 3rd place post
            if($tempSizeCurrent >= $tempSize3){
                
                // check if the size is greater than the current 2nd place post
                if($tempSizeCurrent >= $tempSize2) {
                    
                    // check if the size is greater than the current 1st place post
                    if($tempSizeCurrent > $tempSize1){
                        //size is greater than the 1st place post, set as 1st place post
                            $post_three = $post_two;
                            $post_two   = $post_one;
                            $post_one   = $row['title'];
                    }
                    // size is not greater than the current 1st place post, set as 2nd place post       
                    else {
                        $post_three = $post_two;
                        $post_two = $row['title'];
                    }
                    
                }
                // size is not greater than the current 2nd place post, set as 3rd place post
                else {
                    $post_three = $row['title'];
                }
            }
            // size is not greater than current 3rd place post, do nothing
            else{ 
              //
            }
        }
    
        $data[] = [];
        $data[] = $post_one;
        $data[] = $post_two;
        $data[] = $post_three;
        
                echo json_encode($data);
              
            break;




        /**********************************************************************
        * Return empty string.
        **********************************************************************/
    	default:
    		echo '';
    		break;
    }

?>
