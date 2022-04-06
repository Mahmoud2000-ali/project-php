<?php

/*
    
    @ anas omar  

    connect database eCommerce
    
*/

namespace eCommerce\admin\connectData;

use PDO;
use PDOException;


$dns    = 'mysql:host=localhost;dbname=ecommerce';
$user   = 'root';
$pass   = '';

$options = array(

    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

);
try {

    $conn = new PDO($dns, $user, $pass, $options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}
