<?php

namespace eCommerce\admin\home;

// Start Output Buffer
ob_start();

// start session
session_start();

$navbar = TRUE;
$lan = 'eng';
$pageTitle = 'Dash Border';

if (isset($_COOKIE['cookie-admin']) && !empty($_COOKIE['cookie-admin'])) {
    // include init file
    include_once 'init.admin.php';

    // include File Contain Body
    include_once $tml . 'dash.inc.php';

    // include the footer
    include_once $tml . 'footer.inc.php';
} else {
    // If he enter without login
    header('location: index.php');
    exit();
}
// Close Output buffer
ob_end_flush();
