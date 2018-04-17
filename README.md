# 371 Semester Project

Our project is a content-manager LTI for the Blackboard software. The idea behind our project was to enhance the instructors ability to share additional resources with students. Also, students would be able to upvote and comment on the instructors posts which provides the instructor with critical feedback.

Our projects Uses Blackboards REST API by retreiving the current users "UUID" and calling readUser to obtain more information about the user. It also retrieves the current course ID and uses the readCourse API call to obtain more information about the course and uses readMembership to determine if the user is an instructor or student. 

We use our own data for this project and store it into MySQL tables. The tables are lossless and don't contain any redundancy.
Users can add new data entries by upvoting on a post, commenting on a post, or creating a post. 

For styling, we use a combination of custom CSS as well as the W3.CSS framework

The server-side is written in PHP and the client-side is written in Javascript. Communication between the two is handled by JQuery/Ajax calls. 
  
