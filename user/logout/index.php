<?php
    require ('../../config.php'); 
    session_start();
    if (isset($_SESSION['isLoggedin'])){
        session_unset();
        session_destroy();
        header("location: ".$config['URL']); 
    } else {
        header("location: ".$config['URL']); 
    }
?>