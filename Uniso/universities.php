<?php
include('classes/access.php');

if (isset($_POST['createUniversity'])) {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $rank = $_POST['rank'];
        $phone = $_POST['phone'];
        $mail_extension = $_POST['mail_extension'];

        if (!access::create_query('SELECT name FROM universities WHERE name=:name', array(':name'=>$name))) {

                if (strlen($name) >= 3 && strlen($name) <= 32) {

                        if (preg_match('/[a-zA-Z0-9_]+/', $name)) {

                                if (strlen($address) >= 6 && strlen($address) <= 60) {

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
<body style="background: #2BC0E4;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     <!-- CSS -->

        <link rel="stylesheet" href="css/main.css">

    
    <div class="container">
	            <div class="row">
	                <div class="col-md-6 col-center">
                        <h1 style="font-weight:800; color:blue; font-family:" Sans" ;" >Add University</h1>
<form action="universities.php" method="post">
<input style="width:200px;"type="name" name="name" value="" placeholder="University Name ..."><p />
<input style="width:200px;"type="address" name="address" value="" placeholder="Adress ..."><p />
<input style="width:200px;"type="rank" name="rank" value="" placeholder="Rank ..."><p />
<input style="width:200px;"type="phone" name="phone" value="" placeholder="Phone ..."><p />
<input style="width:200px;"type="email" name="mail_extension" value="" placeholder="@school.edu"><p />
<input style="width:200px;"type="submit" class="btn" name="createUniversity" value="Register University">
</form>
                        
                    </div>
        </div>
    </div>
    
    
    


</body>