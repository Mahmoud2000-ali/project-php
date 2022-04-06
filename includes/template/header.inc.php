<?php
    use function eCommerce\shop\includes\functions\getTitle;
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title> <?php getTitle($pageTitle) ?> </title>
            <link rel = 'stylesheet' href ='<?php echo $css . "all.min.css"; ?>' />
            <link rel = 'stylesheet' href =<?php  echo $lib . 'jquery.tagsinput.css' ; ?> />
            <link rel = 'stylesheet' href =<?php  echo $css . 'bootstrap.min.css' ; ?> />
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway&display=swap">
            <link rel = 'stylesheet' href=<?php  echo $css . 'custom.css';?> />
        </head>
        <body>
 