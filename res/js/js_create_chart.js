/******************************************************************************
* Determines what statistics to show in the stats view.
******************************************************************************/
function select_chart(data) {

    var use_case = $('#chart_dropdown_selector option:selected').val();
  
    switch(use_case) {
        /**********************************************************************
        *
        **********************************************************************/
        case "types_as_percent":
          
            $('#canvas-holder').show();
            $("#top_posts").hide();
            var labels = ["Website", "Book", "Article", "Video"];
            create_chart(data, labels);
            
            break;
        /**********************************************************************
        *
        **********************************************************************/
        case "upvotes_per_type":
            
            $('#canvas-holder').show();
            $("#top_posts").hide();
            var labels = ["Website", "Book", "Article", "Video"];
            create_chart(data, labels);
            
            break;
        /**********************************************************************
        *
        **********************************************************************/
    	case "get_top_posts_upvotes":
    	    
            display_top_3(data);
    	    
    	    break;
         /**********************************************************************
        *
        **********************************************************************/
        case "get_top_posts_comments":
            
            display_top_3(data);
            
            break;
        /**********************************************************************
        *
        **********************************************************************/
        default:
            // Nothing
    }
}

function display_top_3(data) {
    // Clear current text
    $("#first_post").text('');
    $("#second_post").text('');
    $("#third_post").text('');

    $('#canvas-holder').hide();
    $("#top_posts").show();
    
    $("#first_post").text(data[1]);
    $("#second_post").text(data[2]);
    $("#third_post").text(data[3]);
}

/******************************************************************************
* Shows / Hides the statistics view.
******************************************************************************/
function toggle_stats_view() {

    var btn_text   = $('#btn');
    var stats_view = $('.stats');

    if ( stats_view.css('display') == 'none' ){
        stats_view.slideDown();
        btn_text.text('Hide Statistics Resources');
    }
    else {
        stats_view.slideUp();
        btn_text.text('Show Statistics Resources');
    }
}

/******************************************************************************
* Ajax call to the php script. use_case is based on the value of the selected
* option tag.
******************************************************************************/
function select_ajax() {

    var use_case = $('#chart_dropdown_selector option:selected').val();

    $.ajax({
    
        url:    config.AJAX_PATH,
        cache:  false,
        method: 'POST',
        data:   {
                    use_case: use_case
                },
        dataType: 'json',
        success: function(msg){
     
            select_chart(msg);

        }
    });
}

/******************************************************************************
* This creates the javascript charts
******************************************************************************/
function create_chart(data, labels) {
   
   // Clear the chart area so charts don't overlap but are redrawn.
    $('#chart-area-1').remove();
    $('#canvas-holder').append('<canvas id="chart-area-1"></canvas>');

    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };
    var configOne = {
        type: 'pie',
        data: {
            datasets: [{
                data: data,
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.green,
                    window.chartColors.blue,
                    //window.chartColors.yellow,
                    window.chartColors.orange
                ],
                label: 'Dataset 1'
            }],
            labels: labels
        },
        options: {
            responsive: true
        }
    };
    var ctx = document.getElementById("chart-area-1").getContext("2d");
    window.myPie = new Chart(ctx, configOne);

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
}
