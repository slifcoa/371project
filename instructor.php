<?PHP

//Resumes session so that page can use session variables
session_start();

echo "User Id: " . $_SESSION['userID'];
echo "<br>";
echo "Course Role: " . $_SESSION['courseRoleID'];
echo "<br>";
echo "User Name: " . $_SESSION['userName'];
echo "<br>";

echo "INSTRUCTOR PAGE";

?>
