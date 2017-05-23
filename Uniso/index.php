<?php
include('./classes/access.php');
include('./classes/userLogin.php');
include('./classes/userPost.php');
include('./classes/userComment.php');

$showTimeline = False;


if (userLogin::userLoggedIn()) {
        $userid = userLogin::userLoggedIn();
        $showTimeline = True;

        if (isset($_GET['postid'])) {
            userPost::userPostLike($_GET['postid'], $userid);
        }

        if (isset($_POST['comment'])) {
            userComment::userCommentCreate($_POST['commentbody'], $_GET['postid'], $userid);
        }

        $followingposts = access::create_query('SELECT posts.id, posts.body, posts.likes, users.`username` FROM users, posts, followers
        WHERE posts.user_id = followers.user_id
        AND users.id = posts.user_id
        AND follower_id = :userid
        ORDER BY posts.likes DESC;', array(':userid'=>$userid));

        foreach($followingposts as $post) {

        echo $post['body']." ~ ".$post['username'];
        echo "<body style='background: #2BC0E4;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
' >";
        echo "<form action='index.php?postid=".$post['id']."' method='post'>";
                
        if (!access::create_query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$post['id'], ':userid'=>$userid))) {

                 echo "<input class='form-control' type='submit' name='like' value='Like'>";
        } else {
                echo "<input class='form-control' type='submit' name='unlike' value='Unlike'>";
        }
        echo "<span>".$post['likes']." likes</span>
        </form>
            <form action='index.php?postid=".$post['id']."' method='post'>
            <textarea name='commentbody' style='width:300px; height:100px;' rows='3' cols='50'></textarea>
            <input class='form-control'  type='submit' name='comment' value='Comment'> 
        </form> ";
        userComment::userCommentShow($post['id']);
        echo " <hr /></br />";
            echo "</body>";

        }






} else {
        echo 'Not logged in';
}






?>
