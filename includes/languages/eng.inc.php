<?php

/*

    @anas omar

    THIS ENG FILE

*/

namespace eCommerce\includes\language;

function lang($word)
{

    static $array = array(
        // Navbar page
        'Ho'        =>  'Home',
        'De'        =>  'Departments',
        'It'        =>  'Items',
        'Me'        =>  'Members',
        'Co'        =>  'Comment',
        'Lo'        =>  'Loges',
        'Logout'    =>  'Logout',
        'Ed'        =>  'Edit',
        'Me'        =>  'Members'
    );
    return $array[$word];
}
