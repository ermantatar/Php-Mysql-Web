<?php

class userPost {
        // user post class to handle post process of logged in users. 
        //
        // user will create their post with click to submit button so we will put it in database. 

        public static function userPostCreate($postbody, $loggedInUserId, $profileUserId) {

                if (strlen($postbody) > 160 || strlen($postbody) < 1) {
                        die('Incorrect length!');
                }
                // topicleri burda aldik, daha sonra lecturelar icin ayri classlar ac sadece demo icin. 
                // hastag sistemi burda kullandik. 

                $topics = self::userGetTopics($postbody);

                if ($loggedInUserId == $profileUserId) {
                        // if and only if user is active then send post. 
                        // someone else cannot send post with other people account. 
                        // check it in here.
                        access::create_query('INSERT INTO posts VALUES (\'\', :postbody, NOW(), :userid, 0, \'\', :topics)', array(':postbody'=>$postbody, ':userid'=>$profileUserId, ':topics'=>$topics));

                } else {
                        die('Incorrect user!');
                }
        }
        // resim postlamak icin.
        // 
        // nobody can post under 160 character like twitter rule. 

        public static function userImgPost($postbody, $loggedInUserId, $profileUserId) {

                if (strlen($postbody) > 160) {
                        die('Incorrect length!');
                }
                // spesific topic icin aldik yine burdada .

                $topics = self::userGetTopics($postbody);
                // yine kontrol et active mi ?
                //
                if ($loggedInUserId == $profileUserId) {

                        access::create_query('INSERT INTO posts VALUES (\'\', :postbody, NOW(), :userid, 0, \'\', \'\')', array(':postbody'=>$postbody, ':userid'=>$profileUserId, ':topics'=>$topics));
                        $postid = access::create_query('SELECT id FROM posts WHERE user_id=:userid ORDER BY ID DESC LIMIT 1;', array(':userid'=>$loggedInUserId))[0]['id'];
                        return $postid;
                } else {
                        die('Incorrect user!');
                }
        }
        //users might like each other posts. 
        //this function will create post likes to add database table. 
        // 
        public static function userPostLike($postId, $likerId) {

                //firstly we are gonna check to see userid match for spesific id and insert for post_likes table.
                if (!access::create_query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId))) {
                        access::create_query('UPDATE posts SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postId));
                        access::create_query('INSERT INTO post_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$postId, ':userid'=>$likerId));
                } else {
                        access::create_query('UPDATE posts SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postId));
                        access::create_query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId));
                }

        }
        // it is for class talk feature like hastag. 
        // daha sonra lecture class a al burayi kaldir demodan sonra 
        public static function userGetTopics($text) {

                $text = explode(" ", $text);

                $topics = "";
                // her bir word icin yap 
                //dene sona koymayi sonra
                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "#") {
                                $topics .= substr($word, 1).",";
                        }
                }

                return $topics;
        }
        // sinif konusmalari icin ekleme. 
        // all users will be come into the same topic if they put #classname when they post.

        public static function userAddLink($text) {

                $text = explode(" ", $text);
                $newstring = "";

                foreach ($text as $word) {
                        if (substr($word, 0, 1) == "@") {
                                $newstring .= "<a href='profile.php?username=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else if (substr($word, 0, 1) == "#") {
                                $newstring .= "<a href='topics.php?topic=".substr($word, 1)."'>".htmlspecialchars($word)."</a> ";
                        } else {
                                $newstring .= htmlspecialchars($word)." ";
                        }
                }

                return $newstring;
        }

        public static function userPostShow($userid, $username, $loggedInUserId) {
                $dbposts = access::create_query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $posts = "";

                foreach($dbposts as $p) {

                        if (!access::create_query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$p['id'], ':userid'=>$loggedInUserId))) {

                                $posts .= "<img src='".$p['postimg']."'>".self::userAddLink($p['body'])."
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                        <input type='submit' name='like' value='Like'>
                                        <span>".$p['likes']." likes</span>
                                ";
                                if ($userid == $loggedInUserId) {
                                        $posts .= "<input type='submit' name='deletepost' value='x' />";
                                }
                                $posts .= "
                                </form><hr /></br />
                                ";

                        } else {
                                $posts .= "<img src='".$p['postimg']."'>".self::userAddLink($p['body'])."
                                <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                <input type='submit' name='unlike' value='Unlike'>
                                <span>".$p['likes']." likes</span>
                                ";
                                if ($userid == $loggedInUserId) {
                                        $posts .= "<input type='submit' name='deletepost' value='x' />";
                                }
                                $posts .= "
                                </form><hr /></br />
                                ";
                        }
                }

                return $posts;
        }

}
?>
