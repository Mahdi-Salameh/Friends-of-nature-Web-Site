<?php
    //start session
    session_start();
    //delete all session variables
    session_unset();
    //destroy the session
    session_destroy();
    //user will be disconnected and redirect to home page
    header("location:index.php");

?>
