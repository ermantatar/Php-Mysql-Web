<?php
include('./classes/access.php');

if (!(isset($_POST['passwordreset']))) {

        echo "please enter valid information..<br>";
        
}else{
        if (isset($_POST['email'])){

                $email = $_POST['email'];
                $cstrong = True;
                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        
                $user_id = access::create_query('SELECT id FROM users WHERE email=:email', array(':email'=>$email))[0]['id'];
                access::create_query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                echo 'Email sent!';
                echo '<br />';
                echo $token;
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
                        <h1 style="font-weight:800;">Forgot Password</h1>


<form action="forgot-password.php" method="post">
        <input type="text" name="email" value="" style="width:200px;" placeholder="Email ..."><p />
        <input type="submit" name="passwordreset" value="Reset Password" style="width:200px;">
</form>

                   </div>
                  
            </div>
        </div>
        
        
        
        

    
    </body>
</html>
