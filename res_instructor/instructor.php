<?PHP
    session_start();
    
    // Get all constants from config file.
    include '../config.php';

    // Authenticate that the user came from BlackBoard.
    require_once($path_auth);

    $conn = mysqli_connect("34.224.83.184","student33","phppass33","student33");
    if(isset($_POST['submit_btn'])) {
	$title = mysqli_real_escape_string($conn, $_POST['title']);
	$link =  mysqli_real_escape_string($conn, $_POST['link']);
	$type =  mysqli_real_escape_string($conn, $_POST['type']);
	$description = mysqli_real_escape_string($conn, $_POST['description']);
	/* $instructor */
	$course_id = $_SESSION['course_id'];
    $user_name = $_SESSION['user_name'];

	

$query = <<<SQL

    INSERT INTO project_posts (title, description, link, course_id, posted_by, type)
    VALUES ('{$title}', '{$description}', '{$link}', '{$course_id}','Chris', '{$type}')

SQL;

	$result = mysqli_query($conn, $query); 

    }
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://cis371a.hopto.org:9040/demo/Chart.bundle.js"></script>
    <script src="https://cis371a.hopto.org:9040/demo/utils.js"></script>
    <link href="https://code.jquery.com/ui/jquery-ui-git.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-git.js"></script>
    <script src="https://code.jquery.com/ui/jquery-ui-git.js"></script>
<style>
* {
    box-sizing: border-box;
}


input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
}

label {
    padding: 12px 12px 12px 0;
    display: inline-block;
}

input[type=submit] {
    background-color: #0065a4;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
    margin-top: 10px;
}

input[type=submit]:hover {
    color: black;
}
.page {
    background-color: #0065a4;
}

.header {
    width: 80%;
    margin: auto;
    background-color: white;
    padding: 10px 10px;
    text-align: center;
}

.container {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
    width: 90%;
    margin: auto;
}

.col-25 {
    float: left;
    width: 25%;
    margin-top: 6px;
}

.col-75 {
    float: left;
    width: 75%;
    margin-top: 6px;
}

.post {
    background-color: white;
    width: 30%;
    padding: 15px;
    border: 1px solid;
    box-shadow: 0 4px 10px 0 rgba(0,0,0,0.2), 0 4px 20px 0 rgba(0,0,0,0.19);
}

.stats_btn {
    margin: 20px auto;
    width: 50%;
}
#btn {
    background-color: white;
    color: black;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: block;
    margin: auto;
}

.stats {
    background-color: white;
    width: 70%;
    margin: auto;     
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
    .col-25, .col-75, input[type=submit] {
        width: 100%;
        margin-top: 0;
    }
}
</style>

</head>


<body>
<div class="page">
<br/><br/>
<div class="header">
<h1>$teamName</h1>
<h2>Share a Resource with [get course name]</h2>
<p>Resize the browser window to see the effect. When the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other.</p>
</div>
<br /><br />
<div class="container">
  <form action="#" method="POST">
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
      <input type="submit" name="submit_btn" value="Share with Course">
    </div>
  </form>
</div>

<div id="posts-container">
<br/>
<h3>Posts</h3>
    <?PHP
	$postQuery = "SELECT * FROM project_posts ORDER BY post_id DESC";
	$results = mysqli_query($conn, $postQuery);

    if ($results == false){
        echo "Bad Dog";
    }

	while($row = mysqli_fetch_array($results)){
	    echo "<div class=post>";
		echo $row['title'];
		echo $row['link'];
		echo $row['description'];
	    echo "</div>";
	    echo "<br/><br/>";
	}	
    ?>     
<br/><br/>
</div>

<div class="stats_btn">
    <button id="btn" type="button">Get Resource Statistics for this Course</button>
</div>

<div class="stats">

    <div id="canvas-holder" style="width:40%;margin: auto;">
	<h4 style="text-align: center">Each post type as a percentage of all posts</h4>
        <canvas id="chart-area">
    </div>

<?PHP
	$totalQuery = "SELECT * FROM project_posts";
        $websiteQuery = "SELECT * FROM project_posts WHERE type='website'";
	$bookQuery = "SELECT * FROM project_posts WHERE type='book'";
	$articleQuery = "SELECT * FROM project_posts WHERE type='article'";
	$videoQuery = "SELECT * FROM project_posts WHERE type='video'";
	
	$result = mysqli_query($conn, $websiteQuery);
	$numWebsites = $result->num_rows;
	
	$result= mysqli_query($conn, $bookQuery);
	$numBooks = $result->num_rows;
	 
	$result = mysqli_query($conn, $articleQuery);
	$numArticles = $result->num_rows;
	
	$result = mysqli_query($conn, $videoQuery);
	$numVideos = $result->num_rows;

?>
<script>
    $(".stats").hide();
    $("#btn").click(function(){
         $(".stats").show();
    });
</script>

<script>
var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
};

var config = {
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
window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
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
    </script>

</div>

<br/><br/>
</div>

</body>
</html>

