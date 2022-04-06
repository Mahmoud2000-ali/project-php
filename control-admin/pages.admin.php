<?php

/*
    *  Categories => [ Mange | Edit | Update | Add | Insert | Delete | Stats]
*/

    $namePage = '';
    
    isset($_GET['namePage']) ? $namePage = $_GET['namePage'] :  $namePage = 'mange';

    // Check The Page To Open It

    if ($namePage == 'edit') {
        echo ' You Are In Edit';

    } elseif ($namePage == 'update') {
        echo 'You Are In Update';

    } elseif ($namePage == 'add') {
        echo ' You Are In Add';

    } elseif ($namePage == 'insert') {
        echo 'You Are In Insert';

    } elseif ($namePage == 'delete') {
        echo 'You Are In Delete';

    } elseif ($namePage == 'mange') {
        echo 'You Are In Mange Page';

    } else {
        echo 'The Page Not Exist';       
    }
