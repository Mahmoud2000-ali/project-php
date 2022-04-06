<?php

/*
    @anas omar

    THIS Arabic FILE
*/

    namespace eCommerce\admin\includes\language;

  function lang($word){

    static $array = array(

        // Navbar Page
        'Db'        => 'لوحة التحكم',
        'Ho'        =>  'الرْيسية',    
        'De'        =>  'البضاعات',
        'It'        =>  'العناصر',
        'Me'        =>  'الاعضاء',
        'Co'        =>  'الاحصائبات',
        'Lo'        =>  'تسجبل',
        'Logout'    =>  'تسجيل خروج',
        'Ed'        =>  ' تعديل ',
        'Me'        =>  'الاعضاء'

    );
        return $array[$word];

  }