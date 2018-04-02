# 371project

The student.php and instructor.php files are currently just dummy files used to make sure that my index.php file was handling student vs instructor correctly.

To get to our LTI, go to the course (listed as $teamName), then go to Content and click on the teacher-student LTI.

I tweaked the Rest.class.php file so it's important to make sure yours is updated. 

We will need to use the same database for storage so heres the commands to connect to my database and use it:

mysql -h34.224.83.184 -P3306 -ustudent23 -pphppass23
use student23;

I registered the admin user as the instructor of the course, so that's how you can view the instructor -version. In order to view the student version, you can either switch to student preview mode when you're logged in as the admin user, or use my dummy student account (username "gdubs" password "america") to log into BB. 

P.S: the student preview mode's alot easier. 
