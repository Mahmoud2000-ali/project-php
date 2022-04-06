<?php

/*

    This File Use To Destroy The session and Logout The dashBorder

*/

session_start();

session_unset();

session_destroy();

// remove The Cookie
unset($_COOKIE['cookie-admin']);
setcookie('cookie-admin', '', time() - 3600, '/');
unset($_COOKIE['public_admin']);
setcookie('public_admin', '', time() - 3600, '/');
unset($_COOKIE['id']);
setcookie('id', '', time() - 3600, '/');
header('location: index.php');
exit();
