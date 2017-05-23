<?php
include('./classes/access.php');
include('./classes/userLogin.php');

$tokenIsValid = False;

if (userLogin::userLoggedIn()) {

        if (isset($_POST['changepassword'])) {

                $oldpassword = $_POST['oldpassword'];
                $newpassword = $_POST['newpassword'];
                $newpasswordrepeat = $_POST['newpasswordrepeat'];
                $userid = userLogin::userLoggedIn();

                if (password_verify($oldpassword, access::create_query('SELECT password FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['password'])) {

                        if ($newpassword == $newpasswordrepeat) {

                                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {

                                        access::create_query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                        echo 'Password changed successfully!';
                                }

                        } else {
                                echo 'Passwords don\'t match!';
                        }

                } else {
                        echo 'Incorrect old password!';
                }

        }

} else {
        if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if (access::create_query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))) {
                $userid = access::create_query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $tokenIsValid = True;
                if (isset($_POST['changepassword'])) {

                        $newpassword = $_POST['newpassword'];
                        $newpasswordrepeat = $_POST['newpasswordrepeat'];

                                if ($newpassword == $newpasswordrepeat) {

                                        if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {

                                                access::create_query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                                echo 'Password changed successfully!';
                                                access::create_query('DELETE FROM password_tokens WHERE user_id=:userid', array(':userid'=>$userid));
                                        }

                                } else {
                                        echo 'Passwords don\'t match!';
                                }

                        }


        } else {
                die('Token invalid');
        }
} else {
        die('Not logged in');
        }
}

?>


<head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     <!-- CSS -->

        <link rel="stylesheet" href="css/main.css">
      
    </head>
    
    <body style="background: #2BC0E4;  /* fallback for old browsers */ background: -webkit-linear-gradient(to left, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safa">
         <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-center">
                        <h1 style="font-weight:800;">Change Password</h1>

<form action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } ?>" method="post">
        <?php if (!$tokenIsValid) { echo '<input type="password" name="oldpassword" value="" style="width:200px;" placeholder="Current Password ..."><p />'; } ?>
        <input type="password" name="newpassword" value="" style="width:200px;" placeholder="New Password ..."><p />
        <input type="password" name="newpasswordrepeat" value="" style="width:200px;" placeholder="Repeat Password ..."><p />
        <input type="submit" name="changepassword" value="Change Password" style="width:200px;" >
</form>
                </div>
             </div>
        </div>

