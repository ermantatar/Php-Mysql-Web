<?php
include('classes/access.php');

if (isset($_POST['login'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!access::create_query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
                echo 'User not registered!';
               
        } else {
                 
                if (!password_verify($password, access::create_query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                        
                                 echo 'Incorrect Password!';
                } else {
                       

                        echo 'Logged in!';
                        $cstrong = True;
                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                        $user_id = access::create_query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
                        access::create_query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
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
                        <h1 style="font-weight:800;">Login to your account</h1>
<form action="login.php" method="post">
<input class="form-control"type="text" name="username" value="" style="width:200px;"placeholder="Username ..."><p />
<input class="form-control"type="password" name="password" style="width:200px;"value="" placeholder="Password ..."><p /><br>
<input type="submit" class="btn" name="login" style="width:200px;background-color:lightblue;"value="Login">
</form>
                    </div>
             </div>
        </div>

    </body>
</html>