<?PHP
    session_start();
    
    // Get all constants from config file.
    include_once '../config.php';
    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    include_once $path_sql_queries;


    //$conn = mysqli_connect("34.224.83.184","student33","phppass33","student33");
    //if(isset($_POST['submit_btn'])) {
	$title = mysqli_real_escape_string($db_connection, $_POST['title']);
	$link =  mysqli_real_escape_string($db_connection, $_POST['link']);
	$type =  mysqli_real_escape_string($db_connection, $_POST['type']);
	$description = mysqli_real_escape_string($db_connection, $_POST['description']);
	/* $instructor */
	$course_id = $_SESSION['course_id'];
        $user_name = $_SESSION['user_name'];

	

$query = <<<SQL

    INSERT INTO project_posts (title, description, link, course_id, posted_by, type)
    VALUES ('{$title}', '{$description}', '{$link}', '{$course_id}','{$user_name}', '{$type}')

SQL;

	$result = mysqli_query($db_connection, $query); 
	if($result==true){
	    unset($_POST['submit_btn']);
	}
    //}
?>


<!DOCTYPE html>
<html>
<head>
    <!--<script src="https://cis371a.hopto.org:9040/demo/Chart.bundle.js"></script>
    <script src="https://cis371a.hopto.org:9040/demo/utils.js"></script>-->

    <script src="https://nlc3.hopto.org:9033/371project/res_instructor/Chart.bundle.js"></script>
    <script src="https://nlc3.hopto.org:9033/371project/res_instructor/utils.js"></script>
    <link href="https://code.jquery.com/ui/jquery-ui-git.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-git.js"></script>
    <script src="https://code.jquery.com/ui/jquery-ui-git.js"></script>
   
    <script type="text/javascript" src="../res_student/js/js_config.js"></script>
    <script type="text/javascript" src="../res_student/js/js_util.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/instructor_styles.css">
    <link rel="stylesheet" type="text/css" href="../res_student/css/css_main.css">
    <link rel="stylesheet" type="text/css" href="../res_student/css/css_student.css">
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
          <option value="website">Website</option>
          <option value="book">Book</option>
          <option value="article">Article</option>
	  <option value="video">Video</option>
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
      <input type="submit" name="submit_btn" value="Share with Course" onclick="submitPost()">
    </div>
  
</div>
<!-- END FORM -->

<!-- STATS BUTTON -->
<div class="stats_btn">
    <button id="btn" type="button">Get Resource Statistics for this Course</button>
</div>

<!-- STATS DIV, CANVASES -->
<div class="stats">

    <div id="canvas-holder" style="width:40%;margin: auto;">
	<h4 style="text-align: center">Each post type as a percentage of all posts</h4>
        <canvas id="chart-area-1"></canvas>
    </div>

    <div id="canvas-holder" style="width:40%;margin: auto;">
	<h4 style="text-align: center">Number of upvotes per post type</h4>
        <canvas id="chart-area-2"></canvas>
    </div>

<?PHP
	$totalQuery = "SELECT * FROM project_posts";
        $websiteQuery = "SELECT * FROM project_posts WHERE type='website'";
	$bookQuery = "SELECT * FROM project_posts WHERE type='book'";
	$articleQuery = "SELECT * FROM project_posts WHERE type='article'";
	$videoQuery = "SELECT * FROM project_posts WHERE type='video'";
	
	$result = mysqli_query($db_connection, $websiteQuery);
	$numWebsites = $result->num_rows;
	
	$result= mysqli_query($db_connection, $bookQuery);
	$numBooks = $result->num_rows;
	 
	$result = mysqli_query($db_connection, $articleQuery);
	$numArticles = $result->num_rows;
	
	$result = mysqli_query($db_connection, $videoQuery);
	$numVideos = $result->num_rows;

?>
<script>
    $(".stats").hide();
    $("#btn").click(function(){
	$(".stats").show();
        
    });
</script>

<!--<script>
var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
};

var config-1 = {
        type: 'pie',
        data: {
                datasets: [{
                    data: [
                <?PHP
                /*echo $numWebsites.",".$numBooks.",".$numArticles.",".$numVideos*/;
                ?>
                ],
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.green,
		    window.chartColors.blue,
		    window.chartColors.yellow
                                    ],
                label: 'Dataset 1'
                }],
                labels: [
                    "Website",
                    "Book",
	    	    "Article",
	    	    "Video"
                ]
        },
        options: {
            responsive: true
        }
    };
window.onload = function() {
        var ctx = document.getElementById("chart-area-1").getContext("2d");
        window.myPie = new Chart(ctx, config);
    };

    document.getElementById('randomizeData').addEventListener('click', function() {
        config.data.datasets.forEach(function(dataset) {
            dataset.data = dataset.data.map(function() {
                return randomScalingFactor();
            });
        });

        window.myPie.update();
    });
 var colorNames = Object.keys(window.chartColors);
    document.getElementById('addDataset').addEventListener('click', function() {
        var newDataset = {
            backgroundColor: [],
            data: [],
            label: 'New dataset ' + config.data.datasets.length,
        };

        for (var index = 0; index < config.data.labels.length; ++index) {
            newDataset.data.push(randomScalingFactor());

            var colorName = colorNames[index % colorNames.length];;
            var newColor = window.chartColors[colorName];
            newDataset.backgroundColor.push(newColor);
        }

        config.data.datasets.push(newDataset);
        window.myPie.update();
    });

    document.getElementById('removeDataset').addEventListener('click', function() {
        config.data.datasets.splice(0, 1);
        window.myPie.update();
    });
</script> -->

<?PHP

	$numWebsiteVotes = 0;
	$numBookVotes = 0;
	$numArticleVotes = 0;
	$numVideoVotes = 0;
	$tempId;

	$result = mysqli_query($db_connection, $websiteQuery);
	while($row = mysqli_fetch_array($result)){
	    $tempId = $row['post_id'];
            $countQuery = 'SELECT * FROM project_upvotes WHERE post_id='.$tempId;
	    $countResult = mysqli_query($db_connection, $countQuery);
            $numWebsiteVotes += $countResult->num_rows;
	}

	$result = mysqli_query($db_connection, $articleQuery);
	while($row = mysqli_fetch_array($result)){
	    $tempId = $row['post_id'];
            $countQuery = 'SELECT * FROM project_upvotes WHERE post_id='.$tempId;
	    $countResult = mysqli_query($db_connection, $countQuery);
            $numArticleVotes += $countResult->num_rows;
	}


	$result = mysqli_query($db_connection, $bookQuery);
	while($row = mysqli_fetch_array($result)){
	    $tempId = $row['post_id'];
            $countQuery = 'SELECT * FROM project_upvotes WHERE post_id='.$tempId;
	    $countResult = mysqli_query($db_connection, $countQuery);
            $numBookVotes += $countResult->num_rows;
	}

	$result = mysqli_query($db_connection, $videoQuery);
	while($row = mysqli_fetch_array($result)){
	    $tempId = $row['post_id'];
            $countQuery = 'SELECT * FROM project_upvotes WHERE post_id='.$tempId;
	    $countResult = mysqli_query($db_connection, $countQuery);
            $numVideoVotes += $countResult->num_rows;
	}



?>
<script>
var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
};
var configOne = {
        type: 'pie',
        data: {
                datasets: [{
                    data: [
                <?PHP
                echo $numWebsites.",".$numBooks.",".$numArticles.",".$numVideos;
                ?>
                ],
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.green,
		    window.chartColors.blue,
		    window.chartColors.yellow
                                    ],
                label: 'Dataset 1'
                }],
                labels: [
                    "Website",
                    "Book",
	    	    "Article",
	    	    "Video"
                ]
        },
        options: {
            responsive: true
        }
    };
var configTwo = {
        type: 'pie',
        data: {
                datasets: [{
                    data: [
                <?PHP
                echo $numWebsiteVotes.",".$numBookVotes.",".$numArticleVotes.",".$numVideoVotes;
                ?>
                ],
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.green,
		    window.chartColors.blue,
		    window.chartColors.yellow
                                    ],
                label: 'Dataset 1'
                }],
                labels: [
                    "Website",
                    "Book",
	    	    "Article",
	    	    "Video"
                ]
        },
        options: {
            responsive: true
        }
    };
window.onload = function() {
        var ctx = document.getElementById("chart-area-1").getContext("2d");
        window.myPie = new Chart(ctx, configOne);

	var ctx = document.getElementById("chart-area-2").getContext("2d");
        window.myPie = new Chart(ctx, configTwo);
    };

    document.getElementById('randomizeData').addEventListener('click', function() {
        config.data.datasets.forEach(function(dataset) {
            dataset.data = dataset.data.map(function() {
                return randomScalingFactor();
            });
        });

        window.myPie.update();
    });
 var colorNames = Object.keys(window.chartColors);
    document.getElementById('addDataset').addEventListener('click', function() {
        var newDataset = {
            backgroundColor: [],
            data: [],
            label: 'New dataset ' + config.data.datasets.length,
        };

        for (var index = 0; index < config.data.labels.length; ++index) {
            newDataset.data.push(randomScalingFactor());

            var colorName = colorNames[index % colorNames.length];;
            var newColor = window.chartColors[colorName];
            newDataset.backgroundColor.push(newColor);
        }

        config.data.datasets.push(newDataset);
        window.myPie.update();
    });

    document.getElementById('removeDataset').addEventListener('click', function() {
        config.data.datasets.splice(0, 1);
        window.myPie.update();
    });
</script>
<script type="text/javascript">
    
    function submitPost() {

        $.ajax({
    
            url:    'https://nlc3.hopto.org:9033/371project/res_instructor/ajax.php',
            cache:  false,
            method: 'POST',
            data:   {
                        title: $('#title').val(),
                        link: $('#link').val(),
                        type: $('#type option:selected').text(),
                        description: $('#description').val()

                    },
            success: function(msg){
                
                location.reload();
            }
        });

    }

</script>

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
/*
        echo "<div class=post>";
        echo $row['title'];
        echo $row['link'];
        echo $row['description'];
        echo "</div>";
}*/     echo "<br/><br/>";
?> 
</div> 
</div>   
<br/><br/>
<!-- END POSTS -->




<script type="text/javascript" src="../res_student/js/js_filter_posts.js"></script>
<script type="text/javascript" src="../res_student/js/js_sort_posts.js"></script>
</body>
</html>

