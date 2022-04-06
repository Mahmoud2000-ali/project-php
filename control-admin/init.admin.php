<?php

/*

    @ anas omar
    
    This page contains all Routs

*/

namespace eCommerce\admin\init;

$tml = 'includes/template/';
$func = 'includes/functions/';
$langs = 'includes/languages/';
$lib = '../includes/libraares/';

$js = './layout/js/';
$css = './layout/css/';


// include file
include_once $func . 'connect.admin.php';

// Check If The Page Is Eng OR Aeb

if (isset($lan)  && $lan === 'eng') {
    include_once $langs . 'eng.inc.php';
} elseif (isset($lan)  && $lan === 'ara') {
    include_once $langs . 'arabic.inc.php';
}

include_once $func . 'functions.php';

include_once $tml . 'header.inc.php';

// Check If The Page Have nav
if ($navbar == TRUE) {
    include_once $tml . 'nav.admin.php';
}