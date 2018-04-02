# 371project

The student.php and instructor.php files are currently just dummy files used to make sure that my index.php file was handling student vs instructor correctly.

To get to our LTI, go to the course (listed as $teamName), then go to Content and click on the teacher-student LTI.

I tweaked the Rest.class.php file so it's important to make sure yours is updated. 

We will need to use the same database for storage so heres the commands to connect to my database and use it:

mysql -h34.224.83.184 -P3306 -ustudent23 -pphppass23
use student23;

I registered the admin user as the instructor of the course, so that's how you can view the instructor -version. In order to view the student version, you can either switch to student preview mode when you're logged in as the admin user, or use my dummy student account (username "gdubs" password "america") to log into BB. 

P.S: the student preview mode's alot easier. 

Session Variables:
  Here are current session variables that I created for you guys to use on your pages. See my student and instructor dummy pages to get an idea of how to use them. 
  Make sure to have the session_start() method declared at the top of your file(s).
  
  For User ID: $_SESSION['userID'];
  
  
  For Course Role: $_SESSION['courseRoleID'];
  
  
  For User Name: $_SESSION['userName'];
  
  if you need any other variables let me know and i'll add them. 
  
  
