

/**************************************************************************
* 
**************************************************************************/  
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

	$(".w3-card-4").css('background-color','white').hover(
    function(){
        $(this).css('box-shadow', '0 4px 20px 0 rgba(0,0,0,0.79)');
    },
    function(){
        $(this).css('box-shadow', '0 4px 10px 0 rgba(0,0,0,0.2)');
    });

}

/**************************************************************************
* 
**************************************************************************/ 
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


/**************************************************************************
* 
**************************************************************************/ 
function sort_posts_upvotes() {

	var upvote_list = new Array();
	
	$(".w3-card-4").each(function() {
		//alert(this.id);
		upvote_total_box = $('#upvotes'+this.id);
		//alert(upvote_total_box.text());
		upvote_list.push({name: this.id, val: parseInt(upvote_total_box.text())});
	            
	});
	//alert(upvote_list);
	
	upvote_list.sort(function(a,b) {
    	return b.val - a.val;
	});

	upvote_list.forEach(function(post) {
		$("#entry_grid").append($("#"+post.name));
	});

	//alert(upvote_list[0].name);

}


/**************************************************************************
* 
**************************************************************************/ 
function sort_posts_comments() {

	var comment_list = new Array();
	
	$(".w3-card-4").each(function() {
		//alert(this.id);
		comment_total_box = $('#comments'+this.id);
		//alert(upvote_total_box.text());
		comment_list.push({name: this.id, val: parseInt(comment_total_box.text())});
	            
	});
	//alert(upvote_list);
	
	comment_list.sort(function(a,b) {
    	return b.val - a.val;
	});

	comment_list.forEach(function(post) {
		$("#entry_grid").append($("#"+post.name));
	});

	//alert(upvote_list[0].name);

}

/**************************************************************************
* 
**************************************************************************/ 
function sort_posts_upvotes_old() {

	var upvote_list = new Array();
	var myArray = $(".w3-card-4");
	var myArrayLength = myArray.length;
	var count = 0;
	
	$(myArray).each(function() {
		var this_obj = this;
	    $.ajax({
        
	        url:    config.AJAX_PATH + "post_get_total_votes.php",
	        cache:  false,
	        async: false,
	        method: 'POST',
	        data:   {   
	                    post_id: this_obj.id,
	                    echome: 'yes'
	                },
	    
	        success: function(msg){
	        	
	            //$('#upvotes' + this.id).text(msg);
	            upvote_list.push({name: this_obj.id, val: parseInt(msg)});
	            //upvote_list['upvotes'+this.id] = msg;
	            //count++;


	        }
    	}); 
	});

	//alert("h1");
	//while(count != myArrayLength-1){
		// Nothing
	//}
	//alert('h3');

	//https://stackoverflow.com/questions/12788051/how-to-sort-an-associative-array-by-value
	upvote_list.sort(function(a,b) {
    	return b.val - a.val;
	});


	//alert(upvote_list[0].name);
	upvote_list.forEach(function(a){
		var aa = a;
		$(myArray).each(function(){
			if (this.id == aa.name){
				$("#entry_grid").append(this);
			}
			//alert(this.id + 'ak');
		});
	});


}