<?PHP
//Start the session, important for passing data 
session_start();

// Needed for initialization of config file.
include 'config.php';

$url = $_POST['launch_presentation_return_url'];
$query=parse_url($url,PHP_URL_QUERY);
parse_str($query, $out);
$course_id=$out['course_id'];
$course_title=$_POST['context_title'];
$course_batchUID=$_POST['context_label'];
$user_id=$_POST['user_id'];
$name=$_POST['lis_person_name_full'];
$clientURL="http://bb.dataii.com:8080";

require_once('classes/Rest.class.php');
require_once('classes/Token.class.php');

$rest = new Rest($clientURL);
$token = new Token();
$token = $rest->authorize();
$access_token = $token->access_token;

//Use's the uuid to read the current user data 
$user = $rest->readUser($access_token, 'uuid:'.$user_id);

//assign user id to the normal user id
$user_id  = $user->id;

//Reads the Membership of the current user
$membership = $rest->readMembership($access_token, $course_id, $user_id);

$email = $user->contact->email;

//Store relevant rest data into session variables, so data can be used on other pages
$_SESSION['user_id']   = $user_id;
$_SESSION['course_role_id'] = $membership->courseRoleId;
$_SESSION['user_name'] = $user->userName;
$_SESSION['course_id'] = $course_id;
$_SESSION['email']     = $email;
$_SESSION['user_fullname'] = $user->name->given . ' ' . $user->name->family;


/**********************************
* SECRET KEY 
**********************************/
$_SESSION['secret_key'] = $secret_key;

if($membership->courseRoleId == "Student"){
	/********Insert student-version form here********/
	echo "<meta http-equiv='refresh' content='0;URL=res_student/student.php' />";
} elseif ($membership->courseRoleId == "Instructor"){
	/********Insert instructor-version form here********/
	echo"<meta http-equiv='refresh' content='0;URL=res_instructor/instructor.php' />";
} else {
	/********NOT GOOD If this gets accessed********/
	echo "NOT GOOD";
}
?>