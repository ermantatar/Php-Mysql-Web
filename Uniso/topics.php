<?php
include('./classes/access.php');
include('./classes/userLogin.php');
include('./classes/userPost.php');
include('./classes/userImageContent.php');

if (isset($_GET['topic'])) {

        if (access::create_query("SELECT topics FROM posts WHERE FIND_IN_SET(:topic, topics)", array(':topic'=>$_GET['topic']))) {

                $posts = access::create_query("SELECT * FROM posts WHERE FIND_IN_SET(:topic, topics)", array(':topic'=>$_GET['topic']));

                foreach($posts as $post) {
                        // echo "<pre>";
                        // print_r($post);
                        // echo "</pre>";
                        echo $post['body']."<br />";
                }

        }

}
?>

<html>
 <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     <!-- CSS -->

        <link rel="stylesheet" href="css/main.css">
      
    </head>
    
    <body style="background: #2BC0E4;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


">
         <div class="container">
	            <div class="row">
	                <div class="col-md-6 col-center">
                        <h1 style="font-weight:800;"> ~ CLASS CHAT & TALK ~ </h1>

                    </div>
             </div>
        </div>

    </body>
</html>