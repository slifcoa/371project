<?php

session_start();

// Get all constants from config file.
include_once 'res/config.php';

// Authenticate that the user came from BlackBoard.
require_once($path_auth);

function create_new_post($row) {

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
                        <button id="btnedit{$post_id}" 
                                onClick="js_post_edit({$post_id})" 
                                class="w3-button w3-padding-large w3-white w3-border">
                            <b>
                                EDIT
                            </b>
                        </button>
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

    ?>