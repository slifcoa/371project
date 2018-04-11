<?PHP
    
    session_start();

   // Get all constants from config file.
    include_once '../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    //include $path_post_functions;

    include_once $path_sql_queries;
   
?>


<html>
<title>CIS 371 Project</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->

<?php
  if (!empty($_GET['hacker']) and $_GET['hacker'] == 'always'){
    echo '<link rel="stylesheet" href="css/css_hacker.css">';
  }
  else {
    echo '<link rel="stylesheet" href="css/css_main.css">';
  }
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/js_config.js"></script>
<script type="text/javascript" src="js/js_util.js"></script>

<body class="w3-light-grey">

<!-- w3-content defines a container for fixed size centered content, 
and is wrapped around the whole page content, except for the footer in this example -->
<div class="w3-content" style="max-width:1400px">

<!-- Header -->
<header class="w3-container w3-center w3-padding-32"> 
  <h1><b>$teamName</b></h1>
  <p>Welcome <span class="w3-tag">Students</span></p>
</header>

<!-- Grid -->
<div class="w3-row">

<!-- Blog entries -->
<div id=entry_grid class="w3-col l8 s12">

<?PHP

    // Get all the posts from the database.
    $result = sql_select_post_all();

    // Loop through all the posts.
    while($row = mysqli_fetch_array($result)) {

        $post_id     = $row['post_id'];
        $title       = $row['title'];
        $link        = $row['link'];
        $description = $row['description'];
        $type        = $row['type'];

        $image = NULL;
        if (!empty($row['image'])){
            $image = "<img src=$row[image] alt=Nature style=width:100%>";
        }

        $vote_text = "DOWNVOTE";
        if (sql_select_post_vote_status($row['post_id']) < 1) {
          $vote_text = "UPVOTE";
        } 

        $num_upvotes  = sql_select_post_vote_total($post_id);
        $num_comments = sql_select_post_comment_total($post_id);
        
        echo <<<HTML

            <div    id="{$post_id}" 
                    class="w3-card-4 w3-margin w3-white type{$type}">
                {$image}
                <div class="w3-container">
                    <h3>
                        <b>
                           {$row['title']}
                        </b>
                    </h3>
                    <h5>
                        <a href="{$link}">
                            {$link}
                        </a>
                    </h5>
                </div>
                <div class="w3-container">
                    <p>
                        {$description}
                    </p>
                    <div class="w3-row">   
                        <div class='w3-col m8 s12'>
                            <p>
                                <button id="btnupvote{$post_id}" 
                                        onClick="js_post_toggle_vote({$post_id})" 
                                        class="w3-button w3-padding-large w3-white w3-border">
                                    <b>
                                        {$vote_text}
                                    </b>
                                </button>
                                <button id="btn{$post_id}" 
                                        onClick="js_view_comments({$post_id})" 
                                       class="w3-button w3-padding-large w3-white w3-border">
                                    <b> 
                                        VIEW COMMENTS »
                                    </b>
                                </button>
                            </p>
                        </div>
                        <div class='w3-col m4 w3-hide-small'>
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
                            <br>
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
                        </div>
                    </div>
                </div>
            </div>
           <!-- <hr> -->
HTML;
    }

?>
  

<!-- END BLOG ENTRIES -->
</div>


<!-- Introduction menu -->
<div class="w3-col l4">
  <!-- About Card -->
  <?PHP

  $query = "select * from project_about";
  $r = mysqli_query($db_connection,$query);
  $row = mysqli_fetch_array($r);

  echo "<div class='w3-card w3-margin w3-margin-top'>";
  echo "<img src=$row[image] style='width:100%'>";
  echo  "<div class='w3-container w3-white'>";
  echo    "<h4><b>Instructor: $row[title]</b></h4>";
  echo    "<p>$row[description]</p>";
  echo  "</div>";
  echo "</div><hr>";
  ?>

  
  <!-- Sort Posts -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding">
      <h4>Sort Posts</h4>
    </div>
    <ul class="w3-ul w3-hoverable w3-white">

      <li class="w3-padding-16" onclick="sort_posts_newest()">
        <img src="images/icon_date_first.png" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Newest</span><br>
        <span> &ensp; </span>
      </li>

      <li class="w3-padding-16" onclick="sort_posts_oldest()">
        <img src="images/icon_date_last.png" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Oldest</span><br>
        <span> &ensp; </span>
      </li>

      <li class="w3-padding-16" onclick="sort_posts_upvotes()">
        <img src="images/icon_upvote.png" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Most Upvoted</span><br>
        <span>  &ensp;  </span>
      </li> 

      <!--li class="w3-padding-16 w3-hide-medium w3-hide-small">-->
      <li class="w3-padding-16" onclick="sort_posts_comments()">
        <img src="images/icon_comment.png" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Most Commented</span><br>
        <span>  &ensp;  </span>
      </li>  

    </ul>
  </div>
  <hr> 
 
  <!-- Filter Posts -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding">
      <h4>Filter Posts</h4>
    </div>
    <div class="w3-container w3-white">
    <p>
    
      <span id="post_filter_website" class="w3-tag w3-light-grey w3-small w3-margin-bottom" onmouseover="" style="cursor: pointer;">Website</span> 
      <span id="post_filter_book"    class="w3-tag w3-light-grey w3-small w3-margin-bottom" onmouseover="" style="cursor: pointer;">Book</span>
      <span id="post_filter_article" class="w3-tag w3-light-grey w3-small w3-margin-bottom" onmouseover="" style="cursor: pointer;">Article</span> 
      <span id="post_filter_video"   class="w3-tag w3-light-grey w3-small w3-margin-bottom" onmouseover="" style="cursor: pointer;">Video</span> 
      
    </p>
    </div>
  </div>
  
<!-- END Introduction Menu -->
</div>

<!-- END GRID -->
</div><br>

<!-- END w3-content -->
</div>

<!-- Footer 
<footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
  <button class="w3-button w3-black w3-disabled w3-padding-large w3-margin-bottom">Previous</button>
  <button class="w3-button w3-black w3-padding-large w3-margin-bottom">Next »</button>
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>-->


<script type="text/javascript" src="js/js_filter_posts.js"></script>
<script type="text/javascript" src="js/js_sort_posts.js"></script>
</body>
</html>
