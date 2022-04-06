<?php

namespace eCommerce\admin\index;
// start session to allow from user to enter to dashBorder
session_start();

// Open Buffer
ob_start();

use eCommerce\admin\init;

// make var to show if there is navigation on this page or not
$navbar = FALSE;

// make the title of the page
$pageTitle = 'admin';

include_once 'init.admin.php';

// set the user if exist to dash
if(isset($_COOKIE['cookie-admin']) && !empty($_COOKIE['cookie-admin'])){
    $_SESSION['user'] = $_COOKIE['cookie-admin'];
    $_SESSION['id']   = $_COOKIE['cookie-id'];
    $_SESSION['public_admin'] = $_COOKIE['public_admin'];
    header('location: dash.admin.php');
  exit();
}

// Check If The Data Comes From submit
$checkData = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $row = '';
    $username = $_POST['username'];
    $pass     = $_POST['password'];
    // Create Array Of Error 
    $error = array();
    if (strlen($pass) <= 3)
        $error[] =  "<p class = 'alert alert-danger fade in alert-dismissible show'> 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true' style='font-size:20px'>×</span>
            </button>
            SORRY THE PASSWORD MUST BIG 3 CHAR AND SMALL
            </p>";

    if (strlen($username) <= 3)
        $error[] =  "<p class = 'alert alert-danger fade in alert-dismissible show'> 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true' style='font-size:20px'>×</span>
            </button>
            SORRY THE USERNAME MUST BIG 3 CHAR AND SMALL
            </p>";

    // Outer The Cheack And Print The Error If Exist
    if (isset($error) && !empty($error)) {
        foreach ($error as $er) {
            echo $er;
        }
    } else { // There Is No Errors, Connect db

        // prepare and execute Databases
        $statement =  $conn->prepare("SELECT `user_id`, `password` , `username`, `public_admin` FROM users WHERE `password` = ? AND `username` = ? AND `group_id` = 1 LIMIT 1");
        $statement->execute(array($pass, $username));
        $count = $statement->rowCount();
        // Check If The User Is Admin After Connect To Databases OR NO
        if ($count == 1) {
            $row = $statement->fetch(); // Just One colum Will Show
            //set cookie if true
            setcookie('cookie-admin', $username, (time() + 360 * 30 * 24 * 9), '/');
            setcookie('cookie-id', $row['user_id'], (time() + 360 * 30 * 24 * 9), '/');
            setcookie('public_admin', $row['public_admin'], (time() + 360 * 30 * 24 * 9), '/');
            // set session for user to check it in dashBorder
            $_SESSION['user'] = $username;
            $_SESSION['id']   = $row['user_id'];
            $_SESSION['public_admin'] = $row['public_admin'];
           header('location: dash.admin.php');
          exit();
         }else{
           echo "<p class = 'alert alert-danger fade in alert-dismissible show'> 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true' style='font-size:20px'>×</span>
            </button>
             Sorry THE USERNAME OR PASSWORD IS WRONG, <strong> Try Again ! </strong>
            </p>";
            $checkData = true;
         }
    }
}
include_once $tml . 'form.inc.php';

include_once $tml . 'footer.inc.php';

// Exit Open Buffer
ob_end_flush();