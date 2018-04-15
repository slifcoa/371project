<?PHP
    session_start();
    
    // Get all constants from config file.
    include_once 'res/config.php';
    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    include_once $path_sql_queries;
?>

<!DOCTYPE html>
<html>
<head>

    <script src="https://code.jquery.com/jquery-git.js"></script>
    <script src="https://code.jquery.com/ui/jquery-ui-git.js"></script>
    <link href="https://code.jquery.com/ui/jquery-ui-git.css" rel="stylesheet" type="text/css" />


    <script type="text/javascript" src="res/js/js_config.js"></script>
    <script type="text/javascript" src="res/js/js_util.js"></script>
    <script type="text/javascript" src="res/js/js_create_chart.js"></script>
    <script type="text/javascript" src="res/js/Chart.bundle.js"></script>
    <script type="text/javascript" src="res/js/utils.js"></script>    
   
    <link rel="stylesheet" type="text/css" href="res/css/css_instructor.css">
    <link rel="stylesheet" type="text/css" href="res/css/css_main.css">
    <link rel="stylesheet" type="text/css" href="res/css/css_student.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>

<body class="w3-light-grey">
<div class="page">
    <br/><br/>

    <!-- HEADER -->
    <div class="header">
        <h1>Share a Resource with <?php echo $_SESSION['course_name']; ?></h1>
    </div>
    <br /><br />

    <!-- CONTENT -->

    <!-- FORM -->
    <div class="container">
      
        <div class="row">
            <div class="col-25">
                <label for="fname">Resource Title*</label>
            </div>
            <div class="col-75">
                <input type="text" id="title" name="title" placeholder="Title of your resource" required>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="lname">Link*</label>
            </div>
            <div class="col-75">
                <input type="text" id="link" name="link" placeholder="URL for your resource" required>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="country">Type*</label>
            </div>
            <div class="col-75">
                <select id="type" name="type" required>
    	           <option>--</option>
                    <option value="website"> Website </option>
                    <option value="book">    Book    </option>
                    <option value="article"> Article </option>
    	            <option value="video">   Video   </option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="subject">Description</label>
            </div>
            <div class="col-75">
                <textarea id="description" name="description" placeholder="Describe what you're sharing" style="height:200px"></textarea>
            </div>
        </div>
        <div class="row">
            <input type="submit" name="submit_btn" value="Share with Course" onclick="new_post()">
        </div>
      
    </div>
    <!-- END FORM -->

    <!-- STATS BUTTON -->
    <div class="stats_btn">
        <button id="btn" onclick="toggle_stats_view()">Show Statistics Resources</button>
    </div>

    <!-- STATS DIV, CANVASES -->
    <div class="stats" style="display: none;">
        <h4 style="text-align: center">Please Select a Statistics Category to View</h4>
        <select id="chart_dropdown_selector" name="chart" onchange="select_chart()">
            <option>-----</option>
            <option value="types_as_percent">Each post type as a percentage of all posts</option>
            <option value="upvotes_per_type">Number of upvotes per post type</option>
        
        </select>

        <div id="canvas-holder" style="width:40%;margin: auto;">
    	
            <canvas id="chart-area-1"></canvas>
        </div>

    </div>
    <br/><br/>
</div>

<!-- SHOW POSTS -->

<br/>
<h3>Posts</h3>
<div class="w3-content width_max_75 w3-light-grey">

<div id=entry_grid class="w3-col l8 s12">
    <?PHP

    $postQuery = "SELECT * FROM project_posts ORDER BY post_id DESC";
    $results = mysqli_query($db_connection, $postQuery);

    if ($results == false){
        echo "No posts to view";
    }

    while($row = mysqli_fetch_array($results)){

        $post_id = $row['post_id'];
        $title = $row['title'];
        $link  = $row['link'];
        $description = $row['description'];
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
                            &ensp;
                            <span   id="upvotes{$post_id}" 
                                    class="w3-tag">
                                {$num_upvotes}
                            </span>
                        </span>
                    </p>                         
                    <p>
                        <span class="w3-padding-large w3-right">
                            <b>
                                Comments  
                            </b> 
                            &ensp;
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
</div> 
</div>   
<br/><br/>
<!-- END POSTS -->


<script type="text/javascript" src="res/js/js_filter_posts.js"></script>
<script type="text/javascript" src="res/js/js_sort_posts.js"></script>
</body>
</html>

