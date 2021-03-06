var window_position;
window.onscroll = function() {scrollFunction()};
var text_scroll_speed = 15;


function scrollFunction() {
    if (document.body.scrollTop > 250 || document.documentElement.scrollTop > 250) {
        document.getElementById("btn_scroll_top").style.display = "block";
    } else {
        document.getElementById("btn_scroll_top").style.display = "none";
    }
}

/******************************************************************************
* Save the current window position.
******************************************************************************/
function js_store_window_position() {
    
    window_position = $(window).scrollTop();


}

jQuery(function($) {
    $('#scrolling_text').mouseover(function() {
        $(this).css({
            position: 'absolute'
        });
         var dWidth = screen.width - 100; // 100 = image width
           var dHeight = screen.height - 100; // 100 = image height
           // dWidth = dWidth/2;
           var nextX = Math.floor(Math.random() * dWidth);
           var nextY = Math.floor(Math.random() * dHeight);
            //alert(dWidth + " " +dHeight);
        $(this).animate({ left: nextX + 'px', top: nextY + 'px' });
    });
});

function text_speed() {

    text_scroll_speed = text_scroll_speed / 3;
    if (text_scroll_speed < 0.20) {
        text_scroll_speed = 15;
    }

    document.getElementById('scrolling_text').style.animationDuration=text_scroll_speed+"s";
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

/******************************************************************************
* 
******************************************************************************/  
function js_scroll_top() {

    var scrollSpeed = window_position;
    if (window_position > 1000) {
        scrollSpeed = 1000;
    }

    $('body').animate({
        scrollTop: 0
    }, scrollSpeed);

}

/******************************************************************************
* 
******************************************************************************/  
function new_post() {

    var title       = $('#title').val();
    var link        = $('#link').val();
    var type        = $('#type option:selected').text();
    var description = $('#description').val();

    if (title == '' || link == '' || type == '--') {
        alert("Please fill in all required fields");
        return;
    }

    $.ajax({
    
        url:    config.AJAX_PATH,
        cache:  false,
        method: 'POST',
        data:   {
                    use_case:    'insert_post',
                    title:       title,
                    link:        link,
                    type:        type,
                    description: description

                },
        success: function(msg){

            location.reload(); 
            
        }
    });

}


function js_post_edit(post_id) {

     $('body,html').animate({
        scrollTop: 0
    }, 1000);

    $.ajax({
    
        url:    config.AJAX_PATH,
        cache:  false,
        method: 'POST',
        data:   {
                    use_case:    'select_post',
                    post_id: post_id
                },
        dataType: 'json',
        success: function(msg){

            var type = msg[0].type;
            var type = type.toLowerCase().trim();

            $('#title').val(msg[0].title);
            $('#link').val(msg[0].link);
            $('#type').val(type);
            $('#description').val(msg[0].description);

            $('#btnpost').val("Submit Changes");
            $("#btnpost").attr("onclick","js_post_update('"+msg[0].post_id+"')");
            $("#btndelete").attr("onclick","js_post_delete('"+msg[0].post_id+"')");

            $('#btndeletewrapper').show();

        }
    });
}

function js_post_update(post_id) {

    var title       = $('#title').val();
    var link        = $('#link').val();
    var type        = $('#type option:selected').text();
    var description = $('#description').val();

    if (title == '' || link == '' || type == '--') {
        alert("Please fill in all required fields");
        return;
    }

    $.ajax({
    
        url:    config.AJAX_PATH,
        cache:  false,
        method: 'POST',
        data:   {
                    use_case:    'update_post',
                    title:       title,
                    link:        link,
                    type:        type,
                    description: description,
                    post_id:     post_id

                },
        success: function(msg){
   
            location.reload();
            
        }
    });

}


function js_post_delete(post_id) {

     if (confirm("Are you sure you want to delete this post?") == true) {
        $.ajax({
    
            url:    config.AJAX_PATH,
            cache:  false,
            method: 'POST',
            data:   {
                        use_case: 'delete_post',
                        post_id:  post_id
                    },
            success: function(msg){
       
                location.reload();
                
            }
        });
     } 
}