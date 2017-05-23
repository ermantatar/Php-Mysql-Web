<?php
include('classes/access.php');

if (isset($_POST['createaccount'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $university_id = $_POST['universityID'];

        if (!access::create_query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                if (strlen($username) >= 3 && strlen($username) <= 32) {

                        if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

                                if (strlen($password) >= 6 && strlen($password) <= 60) {

                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                if (!access::create_query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

                                        access::create_query('INSERT INTO users VALUES (\'\', :username, :password, :email, :university_id, \'0\', \'\')', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email, ':university_id'=>$university_id ));
                                        echo "Success!";
                                } else {
                                        echo 'Email in use!';
                                }
                        } else {
                                        echo 'Invalid email!';
                                }
                        } else {
                                echo 'Invalid password!';
                        }
                        } else {
                                echo 'Invalid username';
                        }
                } else {
                        echo 'Invalid username';
                }

        } else {
                echo 'User already exists!';
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
                        <h1 style="font-weight:800;">Register</h1>
<form action="create-account.php" method="post" >
<input class="form-control"type="text" name="username" value="" style="width:200px;" placeholder="Username ..."><p />
<input class="form-control"type="password" name="password" value="" style="width:200px;"placeholder="Password ..."><p />
<input class="form-control"type="email" name="email" style="width:200px;"value="" placeholder="someone@somesite.com"><p />
<input class="form-control"type="universityID" name="universityID" value="" style="width:200px;"placeholder="ID of university"><p /><br>
<input class="btn"  type="submit" name="createaccount" style="width:200px; background-color:lightblue;"value="Create Account">
</form>
                    </div>
                  
            </div>
        </div>
        
        
        
        

    
    </body>
</html>