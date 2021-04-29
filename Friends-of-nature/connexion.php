<?php
    //create the connexion with database
    $link=mysqli_connect("localhost","root","","friends_of_nature");
    if($link == false)
        die("Connexion ERROR! :".mysqli_connect_error());
 ?>
