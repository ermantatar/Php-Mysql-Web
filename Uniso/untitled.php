<?php
include('classes/access.php');

if (isset($_POST['createUniversity'])) {
        $name = $_POST['username'];
        $address = $_POST['address'];
        $rank = $_POST['rank'];
        $phone = $_POST['phone'];
        $mail_extension = $_POST['mail_extension'];

        if (!access::create_query('SELECT name FROM universities WHERE name=:name', array(':name'=>$name))) {

                if (strlen($name) >= 3 && strlen($name) <= 32) {

                        if (preg_match('/[a-zA-Z0-9_]+/', $name)) {

                                if (strlen($password) >= 6 && strlen($password) <= 60) {

                                if (filter_var($mail_extension, FILTER_VALIDATE_EMAIL)) {

                                if (!access::create_query('SELECT mail_extension FROM universities WHERE mail_extension=:mail_extension', array(':mail_extension'=>$mail_extension))) {

                                        access::create_query('INSERT INTO universities VALUES (\'\', :name, :address, :rank, :phone,  :mail_extension)', array(':name'=>$name, ':address'=>$address, ':rank'=>$rank, ':phone'=>$phone, ':mail_extension'=>$mail_extension));
                                        echo "Success!";
                                } else {
                                        echo 'Email in use!';
                                }
                        } else {
                                        echo 'Invalid email!';
                                }
                        } else {
                                echo 'Invalid address!';
                        }
                        } else {
                                echo 'Invalid name';
                        }
                } else {
                        echo 'Invalid name';
                }

        } else {
                echo 'University already exists!';
        }
}
?>

<h1>Register</h1>
<form action="create-account.php" method="post">
<input type="name" name="name" value="" placeholder="University Name ..."><p />
<input type="address" name="address" value="" placeholder="Adress ..."><p />
<input type="rank" name="rank" value="" placeholder="Rank ..."><p />
<input type="phone" name="phone" value="" placeholder="Phone ..."><p />
<input type="email" name="mail_extension" value="" placeholder="@school.edu"><p />
<input type="submit" name="createUniversity" value="Register University">
</form>
