<?php

/*

    @anas omar

    THIS ENG FILE

*/

namespace eCommerce\admin\includes\language;

function lang($word)
{

    static $array = array(
        // Navbar page
        'Db'        =>  'DashBorder',
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
