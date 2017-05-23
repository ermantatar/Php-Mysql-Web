<?php
class userComment {

        // comment class created for post comments part of project. 

        //user comment show function to show when user made comments to their friends.
        public static function userCommentShow($postId) {
                //this query written to get spesific user who made comment to this spesific post. 
                // contidion is to where post_id = postid and comments.user_id = user.id

                $comments = access::create_query('SELECT comments.comment, users.username FROM comments, users WHERE post_id = :postid AND comments.user_id = users.id', array(':postid'=>$postId));

                // now I want to show every user and user_comment pair. 
                foreach($comments as $comment) {
                        echo $comment['comment']." <--> ".$comment['username']."<hr />";
                }
        }



        // this function is to write comment when user click submit button
        // to create comment, first I am getting this spesific post from posts table 
        public static function userCommentCreate($commentBody, $postId, $userId) {
                // if database has this spesific comment, then I am creating comment correspound to this post. 
                // otherwise, else statement will say, there is no post like you mention! means invalid post!! 
                
                if (access::create_query('SELECT id FROM posts WHERE id=:postid', array(':postid'=>$postId))) {
                        access::create_query('INSERT INTO comments VALUES (\'\', :comment, :userid, NOW(), :postid)', array(':comment'=>$commentBody, ':userid'=>$userId, ':postid'=>$postId));
                } else {
                        echo 'Invalid post ID';
                }

        }

        
}
?>
