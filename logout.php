<?php

/*

    This File Use To Destroy The session and Logout The dashBorder

*/

session_start();

if(isset($_SESSION['normal-user']) && !empty($_SESSION['normal-user'])){
    session_unset();

    session_destroy();

    header('location: index.php');
    exit();
    
}else{
    header('location: index.php');
}