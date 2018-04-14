<?PHP

    //echo 'yes';
    
	session_start();

	// Get all constants from config file.
    include_once '../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    $course_id = $_SESSION['course_id'];
    $user_id   = $_SESSION['user_id'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $title = $_POST['title'];
    $type = $_POST['type'];

    $query = <<<SQL

        INSERT INTO project_posts (course_id, posted_by, description, link, title, type)
        VALUES ('{$course_id}', '{$user_id}', '{$description}', '{$link}', '{$title}', '{$type}')   

SQL;

    global $db_connection;
    mysqli_query($db_connection, $query);

    echo '';
    

?>