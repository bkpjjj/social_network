<?php

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['loggedin']) == true)
{
    $_SESSION = array();
    session_destroy();
    header('location: /');
}

?>