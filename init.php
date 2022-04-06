<?php

/*

====================================================
== init File

== Include connect File | Header File | Navbar File |Footer File | 

*/

// Name Space Of init File
namespace eCommerce\shop\init;

// Make Variable To The Path Of Files

$tml    = 'includes/template/';
$func   = 'includes/functions/';
$lang   = 'includes/languages/';
$lib    = 'includes/libraares/';

$js = 'layout/js/';
$css = 'layout/css/';

// Include The File



// Check If The Page Is Eng OR Aeb

if (isset($lan)  && $lan === 'eng') {
    include_once $lang . 'eng.inc.php';
} elseif (isset($lan)  && $lan === 'ara') {
    include_once $lang . 'arabic.inc.php';
}

include_once $func . 'functions.php';

include_once $tml . 'header.inc.php';

// Check If The Page Have nav
if ($navbar == TRUE) {
    include_once $tml . 'nav.php';
}