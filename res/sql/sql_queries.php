<?PHP

    session_start();
    
    // Get all constants from config file.
    include_once '../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    /******************************************************************************
    * Returns all posts for the current course.
    ******************************************************************************/
    function sql_select_post_all() {

        $course_id =  $_SESSION['course_id'];

        $query = <<<SQL

        SELECT *
        FROM project_posts
        WHERE (course_id = '{$course_id}')
        ORDER BY post_id DESC 
SQL;

        global $db_connection;
        return mysqli_query($db_connection, $query);
    }

    /******************************************************************************
    * Returns vote status for the post. Returns 1 or 0, 
    * 1 = Has upvoted, 0 = Hasn't upvoted.
    ******************************************************************************/
    function sql_select_post_vote_status($post_id) {

        $course_id =  $_SESSION['course_id'];
        $user_id   =  $_SESSION['user_id'];

        $query = <<<SQL

        SELECT 1
        FROM project_upvotes
        WHERE (course_id = '{$course_id}') AND (post_id = '{$post_id}') AND (user_id = '{$user_id}')

SQL;
  
        global $db_connection;
        return mysqli_num_rows(mysqli_query($db_connection, $query));
    }

    /******************************************************************************
    * Returns the number of upvotes for the post.
    ******************************************************************************/
    function sql_select_post_vote_total($post_id) {

        $query = <<<SQL

        SELECT COUNT(user_id) AS num_upvotes
        FROM project_upvotes
        WHERE (post_id = '{$post_id}')

SQL;
        global $db_connection;
        $result = mysqli_query($db_connection, $query);
        $row    = mysqli_fetch_array($result);
        return $row['num_upvotes'];
    }

    /******************************************************************************
    * Returns the number of comments for the post.
    ******************************************************************************/
    function sql_select_post_comment_total($post_id) {

        $query = <<<SQL

        SELECT COUNT(comment) AS num_comments
        FROM project_comments
        WHERE (post_id = '{$post_id}')        

SQL;
        global $db_connection;
        $result = mysqli_query($db_connection, $query);
        $row    = mysqli_fetch_array($result);
        return $row['num_comments'];
    }


    /******************************************************************************
    * Inserts user upvote for post into the database.
    ******************************************************************************/
    function sql_insert_post_vote($post_id) {

        $course_id =  $_SESSION['course_id'];
        $user_id   =  $_SESSION['user_id'];

        $query = <<<SQL

        INSERT INTO project_upvotes (course_id, post_id, user_id)
        VALUES ('{$course_id}', {$post_id}, '{$user_id}')   

SQL;
        global $db_connection;
        mysqli_query($db_connection, $query);
    }


    /******************************************************************************
    * Deletes user upvote for post from the database.
    ******************************************************************************/
    function sql_delete_post_vote($post_id) {

        $course_id =  $_SESSION['course_id'];
        $user_id   =  $_SESSION['user_id'];

        $query = <<<SQL

        DELETE FROM project_upvotes 
        WHERE (course_id = '{$course_id}') and (post_id = '{$post_id}') and (user_id = '{$user_id}')

SQL;
        global $db_connection;
        mysqli_query($db_connection, $query);
    }

    /******************************************************************************
    * Returns all the comments for a post.
    ******************************************************************************/
    function sql_select_post_comment_all($post_id) {

        $query = <<<SQL

        SELECT *
        FROM project_comments
        WHERE post_id = {$post_id}

SQL;
        global $db_connection;
        return mysqli_query($db_connection, $query);
    }

    /******************************************************************************
    * Inserts a comment for the post into the database.
    ******************************************************************************/
    function sql_insert_post_comment($post_id, $comment) {

        $course_id  = $_SESSION['course_id'];
        $user_id    = $_SESSION['user_id'];
        $user_name  = $_SESSION['user_name'];

        $query = <<<SQL

        INSERT INTO project_comments (course_id, post_id, user_id, date, comment, user_name)
        VALUES ("{$course_id}", {$post_id}, "{$user_id}", NOW(), "{$comment}", "{$user_name}")

SQL;
        global $db_connection;
        mysqli_query($db_connection, $query);
    }

    /******************************************************************************
    * Inserts a post into the database.
    ******************************************************************************/
    function sql_insert_post($title, $description, $link, $type) {

        $course_id  = $_SESSION['course_id'];
        $user_id    = $_SESSION['user_id'];

        $query = <<<SQL

    INSERT INTO project_posts (title, description, link, course_id, posted_by, type)
    VALUES ('{$title}', '{$description}', '{$link}', '{$course_id}','{$user_id}', '{$type}')

SQL;
        global $db_connection;
        mysqli_query($db_connection, $query);
    }

    /******************************************************************************
    * Inserts a post into the database.
    ******************************************************************************/
    function sql_count_by_type($type) {

        $course_id  = $_SESSION['course_id'];

        $query = <<<SQL

    SELECT COUNT(*) AS num
    FROM project_posts 
    WHERE type = '{$type}'

SQL;
        global $db_connection;
        $row = mysqli_fetch_array(mysqli_query($db_connection, $query));
        return $row['num'];
    }


    /******************************************************************************
    * Inserts a post into the database.
    ******************************************************************************/
    function sql_upvote_count_by_type($type) {

        $course_id  = $_SESSION['course_id'];

        $query = <<<SQL

    SELECT COUNT(*) AS num 
    FROM project_upvotes 
    WHERE post_id IN ( 
        SELECT post_id 
        FROM project_posts 
        WHERE type = '{$type}'
    )


SQL;
        global $db_connection;
        $row = mysqli_fetch_array(mysqli_query($db_connection, $query));
        return $row['num'];
    }

    /******************************************************************************
    * Inserts a post into the database.
    ******************************************************************************/
    function sql_top_3_posts($table, $count_by, $limit) {

        $course_id  = $_SESSION['course_id'];

        $query = <<<SQL

    SELECT *
    FROM project_posts 
    where post_id in
    ( 
        SELECT post_id
        FROM 
        (
            select post_id
            from {$table}
            WHERE course_id = '{$course_id}' 
            GROUP BY post_id
            ORDER BY COUNT('{$count_by}') DESC
            limit {$limit}
        ) as insert_anything_here
    )

SQL;
        global $db_connection;
        return mysqli_query($db_connection, $query);
    }

?>