var window_position;

/******************************************************************************
* Save the current window position.
******************************************************************************/
function js_store_window_position() {
    
    window_position = $(window).scrollTop();


}

/******************************************************************************
* Set the current window position.
******************************************************************************/
function js_restore_window_position() {
    
    // Old solution.
    //$(window).scrollTop(window_position);

    $('body,html').animate({
        scrollTop: window_position
    }, 1000);

}

/******************************************************************************
* 
******************************************************************************/  
function js_post_toggle_vote(entry_id) {
 
    $.ajax({
    
        url:    config.AJAX_PATH,
        cache:  false,
        method: 'POST',
        data:   {
                    use_case: 'post_toggle_vote',
                    post_id: entry_id

                },
        dataType: 'json',
        success: function(msg){
            
            $('#upvotes'+entry_id).text(msg.votes_total);
            var upvote_btn = $('#btnupvote'+entry_id);
            $(upvote_btn).text(msg.votes_text);
            $(upvote_btn).css("font-weight","Bold");
        }
    });
}

/******************************************************************************
* 
******************************************************************************/  
function js_view_comments(entry_id, recursed=false) {

    // Only store the window position if 'view comments' is clicked.
    if (!recursed){
        js_store_window_position();
    }

    var scrollSpeed = window_position;
    if (window_position > 1000) {
        scrollSpeed = 1000;
    }

    $('body').animate({
        scrollTop: 0
    }, scrollSpeed, function() {

        $('#'+entry_id).siblings().hide('slow');

        //$('body').scrollTop(0);
        //$('html, body').animate({ scrollTop: 0 }, 'fast');

        //$('#'+entry_id).siblings().hide('slow');
        $('#btn'+entry_id).text("RETURN  »");
        $('#btn'+entry_id).css("font-weight","Bold");
        $('#btn'+entry_id).attr("onclick","comments_return('"+entry_id+"')");

        $('<div/>', {
            id: 'xz',
            class: 'w3-card-4 w3-margin w3-white ent-cmt'
        }).appendTo('#entry_grid');  

        $('<div/>', {
            id: 'xzz',
            class: 'w3-container'
        }).appendTo('#xz');  

        //$('<h3><b>Add a comment to this post</b></h3>').appendTo('#xzz');
        $('<p><b>Add a comment to this post  </b><span class="w3-padding-large w3-right"> <span onmouseover="" style="cursor: pointer;" onclick="new_comment(\''+entry_id+'\')" class="w3-tag">COMMENT</span></span></p>').appendTo('#xzz');

        $('<div/>', {
            id: 'xzzz',
            class: 'w3-container'
        }).appendTo('#xz');  

        $('<textarea id="txtareaID" class="w3-border" rows=3 style="width: 100%; margin-bottom: 25px; resize: none"></textarea>').appendTo('#xzzz'); 

       // Fetch all the comments/comment info and create html/css for each.
        $.ajax({
        
            url:    config.AJAX_PATH,
            cache:  false,
            method: 'POST',
            data:   {
                        use_case: 'post_comments_all',
                        post_id: entry_id
                    },
            dataType: 'json',
            success: function(msg){

                for (i = msg.length - 1; i >= 0; i--){

                    $('<div/>', {
                        id: 'commentOuterDiv'+msg[i].comment_id,
                        class: 'w3-card-4 w3-margin w3-white ent-cmt'
                    }).appendTo('#entry_grid');  

                    $('<div/>', {
                        id: 'commentInnerTopDiv'+msg[i].comment_id,
                        class: 'w3-container'
                    }).appendTo('#commentOuterDiv'+msg[i].comment_id);  

                    $('<h3><b>'+msg[i].author+'</b></h3>').appendTo('#commentInnerTopDiv'+msg[i].comment_id);
                    $('<h5><b>'+msg[i].date+'</b></h5>').appendTo('#commentInnerTopDiv'+msg[i].comment_id);

                    $('<div/>', {
                        id: 'commentInnerBottomDiv'+msg[i].comment_id,
                        class: 'w3-container'
                    }).appendTo('#commentOuterDiv'+msg[i].comment_id);  

                    $('<p>'+msg[i].story+'</p>').appendTo('#commentInnerBottomDiv'+msg[i].comment_id);
                }      
            }
        });

        $('#id_div_filter_posts').hide();

    });

}

/******************************************************************************
* 
******************************************************************************/  
function comments_return(entry_id) {

    $('.ent-cmt').fadeOut('slow', function(){ $(this).remove(); });
    $('#'+entry_id).siblings().fadeIn('slow');
    $('#btn'+entry_id).text("VIEW COMMENTS »");
    $('#btn'+entry_id).attr("onclick","js_view_comments('"+entry_id+"')");

    js_restore_window_position();

    $('#id_div_filter_posts').show();
 
}

/******************************************************************************
* 
******************************************************************************/  
function new_comment(entry_id){

    var textbox = $('#txtareaID');

    $.ajax({
        
        url:    config.AJAX_PATH,
        cache:  false,
        method: 'POST',
        data:   {   
                    use_case: "post_add_comment",
                    post_id:  entry_id,
                    comment:  textbox.val()
                },
    
        success: function(msg){
            
            //$('.ent-cmt').hide('fast', function(){ $(this).remove(); });
            $('.ent-cmt').remove();
            js_view_comments(entry_id, true);
            post_get_total_comments(entry_id);

        }
    });
}

/******************************************************************************
* 
******************************************************************************/  
function post_get_total_comments(entry_id) {

    $.ajax({
        
        url:    config.AJAX_PATH,
        cache:  false,
        method: 'POST',
        data:   {   
                    use_case: "select_post_comment_total",
                    post_id:  entry_id
                },
    
        success: function(msg){
        
            $('#comments'+entry_id).text(msg);

        }
    });

}

function js_scroll_top() {

    var scrollSpeed = window_position;
    if (window_position > 1000) {
        scrollSpeed = 1000;
    }

    $('body').animate({
        scrollTop: 0
    }, scrollSpeed);

}

