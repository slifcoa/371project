


function select_chart(post_ajax = false, data = null) {

    var use_case = $('#chart_dropdown_selector option:selected').val();
  
    switch(use_case) {
        /**********************************************************************
        *
        **********************************************************************/
        case "types_as_percent":
            if (post_ajax == false){
                select_ajax(use_case);
            }
            else{
                var labels = ["Website", "Book", "Article", "Video"];
                create_chart(data, labels);
            }
            break;
        /**********************************************************************
        *
        **********************************************************************/
        case "upvotes_per_type":
            if (post_ajax == false){
                select_ajax(use_case);
            }
            else{
                var labels = ["Website", "Book", "Article", "Video"];
                create_chart(data, labels);
            }
            break;
        /**********************************************************************
        *
        **********************************************************************/
        default:
            
            // Nothing

    }

}

function me(){
    alert("me");
}


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


function select_ajax(use_case) {

    $.ajax({
    
        url:    config.AJAX_PATH,
        cache:  false,
        method: 'POST',
        data:   {
                    use_case: use_case
                },
        dataType: 'json',
        success: function(msg){
            
            select_chart(true, msg);

        }
    });


}




function create_chart(data, labels) {
   
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