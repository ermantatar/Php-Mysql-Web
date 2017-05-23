<?php
include('./classes/access.php');
include('./classes/userLogin.php');


if (!userLogin::userLoggedIn()) {
        die('Not logged in');
} else {
        

        $userid = userLogin::userLoggedIn();

        if (isset($_POST['send'])) {
                
                if (!access::create_query('SELECT id FROM users WHERE id=:receiver', array(':receiver'=>$_GET['receiver']))) {
                        
                         die('Invalid ID!');
                      
                } else {
                        access::create_query("INSERT INTO messages VALUES ('', :body, :sender, :receiver, 0)", array(':body'=>$_POST['body'], ':sender'=>$userid, ':receiver'=>htmlspecialchars($_GET['receiver'])));
                        echo "Message Sent!";
                }
        }

}

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     <!-- CSS -->

        <link rel="stylesheet" href="css/main.css">
<h1 style="font-weight:800;">Send a Message</h1>
<form action="send-message.php?receiver=<?php echo htmlspecialchars($_GET['receiver']); ?>" method="post">
        <textarea name="body" rows="8" cols="80"></textarea>
        <input class="form-control" type="submit" name="send" value="Send Message">
</form>

