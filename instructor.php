<?PHP
    session_start();
    
    // Get all constants from config file.
    include_once 'res/config.php';
    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    include_once $path_sql_queries;
    include_once $path_new_post;
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
                <input type="text" id="title" name="title" placeholder="Title of your resource">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="lname">Link*</label>
            </div>
            <div class="col-75">
                <input type="text" id="link" name="link" placeholder="URL for your resource">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="country">Type*</label>
            </div>
            <div id='typediv' class="col-75" name="options">
                <select id="type" name="type">
    	           <option value="default">--</option>
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
            <input id="btnpost" type="submit" name="submit_btn" value="Share with Course" onclick="new_post()">
             <div id="btndeletewrapper" style="display: none;">
                <input id="btndelete" type="submit" name="delete_btn" value="Delete this Post">    
            </div>
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
        <select id="chart_dropdown_selector" name="chart" onchange="select_ajax()">
            <option>-----</option>
            <option value="types_as_percent">Each post type as a percentage of all posts</option>
            <option value="upvotes_per_type">Number of upvotes per post type</option>
            <option value="get_top_posts_upvotes">Most Upvoted Posts</option>
            <option value="get_top_posts_comments">Most Commented Posts</option>
        </select>

        <div id="canvas-holder" style="width:40%;margin: auto;">
    	
            <canvas id="chart-area-1"></canvas>
	   </div>
	
    	<div id="top_posts" style="width:40%;margin: auto;">
    	    <h2 id="first_post" style="text-align:center;"></h2>
    	    <h3 id="second_post" style="text-align:center;"></h3>
    	    <h4 id="third_post" style="text-align:center;"></h4>
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

        create_new_post($row);

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

