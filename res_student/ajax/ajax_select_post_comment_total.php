<?PHP

	session_start();

	// Get all constants from config file.
    include '../../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

	echo sql_select_post_comment_total($_POST['post_id']);

?>