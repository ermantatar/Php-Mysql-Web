<?php
include('./classes/access.php');
include('./classes/userLogin.php');

if (!userLogin::userLoggedIn()) {
        echo "<body style='background: #2BC0E4;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


'></body>";
        die("Not logged in.");
}

if (isset($_POST['confirm'])) {

        if (isset($_POST['alldevices'])) {

                access::create_query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>userLogin::userLoggedIn()));

        } else {
                if (isset($_COOKIE['SNID'])) {
                        access::create_query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
                }
                setcookie('SNID', '1', time()-3600);
                setcookie('SNID_', '1', time()-3600);
        }

}

?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     <!-- CSS -->

        <link rel="stylesheet" href="css/main.css">
<body style="background: #2BC0E4;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #EAECC6, #2BC0E4);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #EAECC6, #2BC0E4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


">
<h1 style="font-weight:800;">Logout of your Account?</h1>
<p>Are you sure you'd like to logout?</p>
<form action="logout.php" method="post">
        <input class="form-control" type="checkbox" name="alldevices" value="alldevices"> Logout of all devices?<br />
        <input class="form-control" type="submit" name="confirm" value="Confirm">
</form>
</body>