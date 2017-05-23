<?php
include('./classes/access.php');
include('./classes/userLogin.php');
include('./classes/userImageContent.php');



if (userLogin::userLoggedIn()) {
        $userid = userLogin::userLoggedIn();
} else {
         echo "<body style='background: #2BC0E4;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


'></body>";
        die('Not logged in!');
}

if (isset($_POST['uploadprofileimg'])) {

        userImageContent::userInstallImage('profileimg', "UPDATE users SET profileimg = :profileimg WHERE id=:userid", array(':userid'=>$userid));

}
?>

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
                        <h1 style="font-weight:800;">My Account</h1>
<form action="my-account.php" method="post" enctype="multipart/form-data">
        Upload a profile image:
        <input class="form-control" type="file" name="profileimg">
        <input class="form-control" type="submit" name="uploadprofileimg" value="Upload Image">
</form>
                    </div>
             </div>
        </div>
        

</body>
                    