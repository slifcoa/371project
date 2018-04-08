<?PHP

    session_start();
    
    // Get all constants from config file.
    include '../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    /******************************************************************************
    *
    ******************************************************************************/
    function page_load_query_all_posts($connection) {

        $query = <<<SQL

        SELECT *
        FROM project_posts
        ORDER BY post_id DESC 
SQL;
        return mysqli_query($connection, $query);
    }

    /******************************************************************************
    *
    ******************************************************************************/
    function page_load_query_post_vote_text($connection, $post_id){

        $course_id =  $_SESSION['course_id'];
        $user_id   =  $_SESSION['user_id'];

        $query = <<<SQL

        SELECT 1
        FROM project_upvotes
        WHERE (course_id = '{$course_id}') AND (post_id = '{$post_id}') AND (user_id = '{$user_id}')

SQL;
  
        $upvote_text;

        if (mysqli_num_rows(mysqli_query($connection, $query)) < 1) {
            $upvote_text = "UPVOTE";
        }
        else{
            $upvote_text = "DOWNVOTE";
        }

        return $upvote_text;
    }

    /******************************************************************************
    *
    ******************************************************************************/
    function page_load_post_handle_image($row) {

        if (!empty($row['image'])){
            return "<img src=$row[image] alt=Nature style=width:100%>";
        }
    }

    /******************************************************************************
    *
    ******************************************************************************/
    function page_load_query_post_total_upvotes($connection, $post_id){

        $query = <<<SQL

        SELECT COUNT(user_id) AS num_upvotes
        FROM project_upvotes
        WHERE (post_id = '{$post_id}')

SQL;

        $result = mysqli_query($connection, $query);
        $row    = mysqli_fetch_array($result);
        return $row['num_upvotes'];
    }

    /******************************************************************************
    *
    ******************************************************************************/
    function page_load_query_post_total_comments($connection, $post_id){

        $query = <<<SQL

        SELECT COUNT(comment) AS num_comments
        FROM project_comments
        WHERE (post_id = '{$post_id}')        

SQL;

        $result = mysqli_query($connection, $query);
        $row    = mysqli_fetch_array($result);
        return $row['num_comments'];
    }

    /******************************************************************************
    *
    ******************************************************************************/
    function create_post_button_vote($post_id, $upvote_text) {
    return <<<HTML
                        
        <button id="btnupvote{$post_id}" 
                onClick="js_post_toggle_vote({$post_id})" 
                class="w3-button w3-padding-large w3-white w3-border">
            <b>
                {$upvote_text}
            </b>
        </button>
                           
HTML;

    }

    /******************************************************************************
    *
    ******************************************************************************/
    function create_post_button_comment($post_id) {
    return <<<HTML
                        
        <button id="btn{$post_id}" 
                onClick="js_view_comments({$post_id})" 
               class="w3-button w3-padding-large w3-white w3-border">
            <b> 
                VIEW COMMENTS »
            </b>
        </button>
                           
HTML;

    }

    /******************************************************************************
    *
    ******************************************************************************/
    function create_post_box_total_votes($l, $post_id) {

        $num_upvotes = page_load_query_post_total_upvotes($l, $post_id);
        return <<<HTML

            <p>
                <span class="w3-padding-large w3-right">
                    <b> 
                        Upvotes 
                    </b> 
                    <span   id="upvotes{$post_id}" 
                            class="w3-tag">
                        {$num_upvotes}
                    </span>
                </span>
            </p>
HTML;

    }

    /******************************************************************************
    *
    ******************************************************************************/
    function create_post_box_total_comments($l, $post_id) {

    $num_comments = page_load_query_post_total_comments($l, $post_id);
    return <<<HTML
                        
        <p>
            <span class="w3-padding-large w3-right">
                <b>
                    Comments  
                </b> 
                <span   id="comments{$post_id}" 
                        class="w3-tag">
                    {$num_comments}
                </span>
            </span>
        </p>
HTML;

    }

    /******************************************************************************
    *
    ******************************************************************************/
    function page_load_post_add_title($title) {   

        return <<<HTML
             <h3>
                 <b>
                     {$title}
                 </b>
             </h3>
HTML;
    }   

    /******************************************************************************
    *
    ******************************************************************************/
    function page_load_post_add_link($link) {

        return <<<HTML
            <h5>
                <a href="{$link}">
                    {$link}
                </a>
            </h5>
HTML;
    }    

?>