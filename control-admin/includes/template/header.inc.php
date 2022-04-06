
<!DOCTYPE html>
    <html lang='<?php if(isset($lan) && $lan === 'ara'){echo "ar";}else{echo "en";} ?>'>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title><?php if(isset($pageTitle)){echo eCommerce\admin\includes\functions\getTitle();} ?></title>
            <link rel = 'stylesheet' href ='./layout/font/css/all.min.css' />
            <link rel = 'stylesheet' href =<?php  echo $lib . 'jquery.tagsinput.css' ; ?> />
            <link rel = 'stylesheet' href =<?php  echo $css . 'bootstrap.min.css' ; ?> />
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway&display=swap">
            <link rel = 'stylesheet' href=<?php  echo $css . 'customers.admin.css';?> />
           <!-- <link rel = "stylesheet" href= <?php // if(isset($lan) && $lan === 'ara'){echo $css . 'bootstrap.rtl.min.css';}?>/> -->
        </head>
        <body>
 