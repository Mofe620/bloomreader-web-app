<?php
session_start();
?>

<?php
//remove all session variables
session_unset();

//destroy the session
session_destroy();

//redirecting to login page
header("location: login.php");
exit("You are no longer logged in");

?>
