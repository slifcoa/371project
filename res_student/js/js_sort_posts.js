


function sort_posts_oldest() {

	
	// get array of elements
	var myArray = $(".w3-card-4");


	// sort based on timestamp attribute
	myArray.sort(function (a, b) {
	    
	    // convert to integers from strings
	    a = parseInt($(a).attr("id"), 10);
	    b = parseInt($(b).attr("id"), 10);
	
	    // compare
	    if(a > b) {
	        return 1;
	    } else if(a < b) {
	        return -1;
	    } else {
	        return 0;
	    }
	});

	// put sorted results back on page
	$("#entry_grid").append(myArray);


}

// https://jsfiddle.net/MikeGrace/Vgavb/
function sort_posts_newest() {

	// get array of elements
	var myArray = $(".w3-card-4");


	// sort based on timestamp attribute
	myArray.sort(function (a, b) {
	    
	    // convert to integers from strings
	    a = parseInt($(a).attr("id"), 10);
	    b = parseInt($(b).attr("id"), 10);
	
	    // compare
	    if(a < b) {
	        return 1;
	    } else if(a > b) {
	        return -1;
	    } else {
	        return 0;
	    }
	});

	// put sorted results back on page
	$("#entry_grid").append(myArray);



}