<?PHP
    
    session_start();

   // Get all constants from config file.
    include '../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    include $path_post_functions;

?>


<html>
<title>CIS 371 Project</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
    $result = page_load_query_all_posts($db_connection);

    // Loop through all the posts.
    while($row = mysqli_fetch_array($result)) {

        $upvote_text = page_load_query_post_vote_text($db_connection, $row['post_id']);  

        $func_add_link  = page_load_post_add_link($row['link']);
        $func_add_title = page_load_post_add_title($row['title']);
        $func_add_image = page_load_post_handle_image($row);
        $func_add_btn_vote    = create_post_button_vote($row['post_id'], $upvote_text);
        $func_add_btn_comment = create_post_button_comment($row['post_id']);
        $func_add_count_votes    = create_post_box_total_votes($db_connection, $row['post_id']);
        $func_add_count_comments = create_post_box_total_comments($db_connection, $row['post_id']);

        echo <<<HTML

            <div    id="{$row['post_id']}" 
                    class="w3-card-4 w3-margin w3-white">
                {$func_add_image}
                <div class="w3-container">
                    {$func_add_title}
                    {$func_add_link}
                </div>
                <div class="w3-container">
                    <p>
                        {$row['description']}
                    </p>
                    <div class="w3-row">   
                        <div class='w3-col m8 s12'>
                            <p>
                                {$func_add_btn_vote}
                                {$func_add_btn_comment}
                            </p>
                        </div>
                        <div class='w3-col m4 w3-hide-small'>
                            {$func_add_count_votes}
                            {$func_add_count_comments}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
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
  
  <!-- Posts -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding">
      <h4>Popular Posts</h4>
    </div>
    <ul class="w3-ul w3-hoverable w3-white">
      <li class="w3-padding-16">
        <img src="/w3images/workshop.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Lorem</span><br>
        <span>Sed mattis nunc</span>
      </li>
      <li class="w3-padding-16">
        <img src="/w3images/gondol.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Ipsum</span><br>
        <span>Praes tinci sed</span>
      </li> 
      <li class="w3-padding-16">
        <img src="/w3images/skies.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Dorum</span><br>
        <span>Ultricies congue</span>
      </li>   
      <li class="w3-padding-16 w3-hide-medium w3-hide-small">
        <img src="/w3images/rock.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Mingsum</span><br>
        <span>Lorem ipsum dipsum</span>
      </li>  
    </ul>
  </div>
  <hr> 
 
  <!-- Labels / tags -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding">
      <h4>Tags</h4>
    </div>
    <div class="w3-container w3-white">
    <p><span class="w3-tag w3-black w3-margin-bottom">Travel</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">New York</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">London</span>
      <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">IKEA</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">NORWAY</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">DIY</span>
      <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Ideas</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Baby</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Family</span>
      <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">News</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Clothing</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Shopping</span>
      <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Sports</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Games</span>
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



</body>
</html>
