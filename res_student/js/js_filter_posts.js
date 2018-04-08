var array_post_filter_const = ['website', 'book', 'article', 'video'];
var array_post_filter = [];

$(document).ready(function() {

	/**************************************************************************
	* 
	**************************************************************************/  	
	$("#post_filter_website").click( function() {
	    
	    var index = $.inArray("website", array_post_filter);
	    if (index == -1) {
	    	array_post_filter.push("website");
	    	$(this).removeClass("w3-light-grey").addClass("w3-black");
	    }
	    else {
	    	array_post_filter.splice(index, index+1);
	    	$(this).removeClass("w3-black").addClass("w3-light-grey");
	    }

	    filter_posts();

	});

	/**************************************************************************
	* 
	**************************************************************************/
	$("#post_filter_book").click( function() {
	    
	    var index = $.inArray("book", array_post_filter);
	    if (index == -1) {
	    	array_post_filter.push("book");
	    	$(this).removeClass("w3-light-grey").addClass("w3-black");
	    }
	    else {
	    	array_post_filter.splice(index, index+1);
	    	$(this).removeClass("w3-black").addClass("w3-light-grey");
	    }

	    filter_posts();

	});

	/**************************************************************************
	* 
	**************************************************************************/
	$("#post_filter_article").click( function() {
	    
	    var index = $.inArray("article", array_post_filter);
	    if (index == -1) {
	    	array_post_filter.push("article");
	    	$(this).removeClass("w3-light-grey").addClass("w3-black");
	    }
	    else {
	    	array_post_filter.splice(index, index+1);
	    	$(this).removeClass("w3-black").addClass("w3-light-grey");
	    }

	    filter_posts();

	});

	/**************************************************************************
	* 
	**************************************************************************/
	$("#post_filter_video").on('click', function() {

		var index = $.inArray("video", array_post_filter);
	    if (index == -1) {
	    	array_post_filter.push("video");
	    	$(this).removeClass("w3-light-grey").addClass("w3-black");
	    }
	    else {
	    	array_post_filter.splice(index, index+1);
	    	$(this).removeClass("w3-black").addClass("w3-light-grey");
	    }
	    
	    filter_posts();
	    
	});

});

function filter_posts() {

	if (array_post_filter.length == 0){
    	$('.typewebsite').show('slow');
    	$('.typebook').show('slow');
    	$('.typearticle').show('slow');
    	$('.typevideo').show('slow');
    }
    else {
    	for (var type in array_post_filter_const) {
  
    		if ($.inArray(array_post_filter_const[type], array_post_filter) == -1) {
    			$('.type' + array_post_filter_const[type]).slideUp('slow');
    
    		}
    		else {
    			$('.type' + array_post_filter_const[type]).slideDown('slow');	
    		}
    	}
    }
}