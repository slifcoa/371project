<?PHP

    //echo 'yes';
    
	session_start();

	// Get all constants from config file.
    include_once '../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);
    global $db_connection;

    $course_id = $_SESSION['course_id'];
    $user_id   = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($db_connection, $_POST['title']);
    $link =  mysqli_real_escape_string($db_connection, $_POST['link']);
    $type =  mysqli_real_escape_string($db_connection, $_POST['type']);
    $description = mysqli_real_escape_string($db_connection, $_POST['description']);

    $query = <<<SQL

        INSERT INTO project_posts (course_id, posted_by, description, link, title, type)
        VALUES ('{$course_id}', '{$user_id}', '{$description}', '{$link}', '{$title}', '{$type}')   

SQL;


    mysqli_query($db_connection, $query);

    echo '';
    

?>