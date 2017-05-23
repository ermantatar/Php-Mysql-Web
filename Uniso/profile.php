<?php
include('./classes/access.php');
include('./classes/userLogin.php');
include('./classes/userPost.php');
include('./classes/userImageContent.php');

$username = "";
$verified = False;
$isFollowing = False;

if ( isset($_GET['username']) ) {

        

        if (!(access::create_query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username'])))   ) {
                
                die('User not found!');





        } else {
                
                $username = access::create_query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $userid = access::create_query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                $verified = access::create_query('SELECT verified FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['verified'];
                $followerid = userLogin::userLoggedIn();


                if (isset($_POST['post'])) {

                        if (!($_FILES['postimg']['size'] == 0)) {
                               
                                $postid = userPost::userImgPost($_POST['postbody'], userLogin::userLoggedIn(), $userid);
                                userImageContent::userInstallImage('postimg', "UPDATE posts SET postimg=:postimg WHERE id=:postid", array(':postid'=>$postid)); 
                        } else {
                               userPost::userPostCreate($_POST['postbody'], userLogin::userLoggedIn(), $userid);
                        }
                }

                if (!(access::create_query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid)))) {
                        
                        $isFollowing = false;
                }else{

                        $isFollowing = true;
                }

                if (    isset($_POST['deletepost'])) {
                        if (access::create_query('SELECT id FROM posts WHERE id=:postid AND user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid))) {
                                access::create_query('DELETE FROM posts WHERE id=:postid and user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid));
                                access::create_query('DELETE FROM post_likes WHERE post_id=:postid', array(':postid'=>$_GET['postid']));
                                echo 'Post deleted!';
                        }
                }




                if (isset($_POST['follow'])) {

                        if ($userid != $followerid) {

                                if (access::create_query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        echo 'You are already following!';
                                        
                                } else {
                                        

                                        if ($followerid == 6) {
                                                access::create_query('UPDATE users SET verified=1 WHERE id=:userid', array(':userid'=>$userid));
                                        }
                                        access::create_query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));

                                }
                                $isFollowing = True;
                        }
                }


                if (isset($_POST['unfollow'])) {

                        if ($userid != $followerid) {

                                if (!access::create_query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                       
                                }else{
                                        if ($followerid == 6) {
                                                access::create_query('UPDATE users SET verified=0 WHERE id=:userid', array(':userid'=>$userid));
                                        }
                                        access::create_query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid));

                                }
                                $isFollowing = False;
                        }
                }


                if (isset($_GET['postid']) && !isset($_POST['deletepost'])) {
                        userPost::userPostLike($_GET['postid'], $followerid);
                }


                $posts = userPost::userPostShow($userid, $username, $followerid);
                
        }

}

?>

<body style="background: #2BC0E4;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

">

<h1><?php echo $username; ?>'s Profile<?php if ($verified) { echo ' - Verified'; } ?></h1>
<form action="profile.php?username=<?php echo $username; ?>" method="post">
        <?php
        if ($userid != $followerid) {
                if ($isFollowing) {
                        echo '<input type="submit" name="unfollow" value="Unfollow">';
                } else {
                        echo '<input type="submit" name="follow" value="Follow">';
                }
        }
        ?>
</form>

<form action="profile.php?username=<?php echo $username; ?>" method="post" enctype="multipart/form-data">
        <textarea name="postbody" rows="8" style="border-width:5px;border-color:lightblue;"cols="80"></textarea>
        <br />Upload an image:
        <input type="file" name="postimg">
        <input type="submit" name="post" value="Post">
</form>

<div class="posts">
        <?php echo $posts; ?>
</div>
</body>