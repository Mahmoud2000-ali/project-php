<?php

/*

====================================================
== This Page To Edit The Information 
= Mange | Add | Edit | Delete
====================================================

====================================================
== If There Is No Customers To Insert Member Then I Will Insert New Customer
= When I Insert New Member In Chose One Of Customer To Be Member Then No Problem

[1] => the new customer not found in data then i will insert it withe user_group is 1
[2] => yhe new customer font in data but he is already member
[3] => the new customer  font in data And He not member then Change The user_group
====================================================

*/

namespace eCommerce\admin\customers;
// Call ob To Go Awy From Errors
ob_start('ob_gzhandler');

session_start();

use function eCommerce\admin\includes\functions\cheackCustomer;
use function eCommerce\admin\includes\functions\UpdateInformation;
use function eCommerce\admin\includes\functions\CheackCustomerToInsert;
use function eCommerce\admin\includes\functions\InsertCustomerInData;
use function eCommerce\admin\includes\functions\makeModify;
use function eCommerce\admin\includes\functions\deleteFromData;
use function eCommerce\admin\includes\functions\printInTable;
use function eCommerce\admin\includes\functions\cheackItems;

$namePage = '';

if (isset($_COOKIE['cookie-admin']) && !empty($_COOKIE['cookie-admin'])) {
    // make var to show if there is navigation on this page or not
    $navbar = TRUE;

    // make the title of the page
    $pageTitle = 'Edit';

    // make the language of the page
    $lan = 'eng';

    // inclued the connect db and nav and header and the language file
    include_once 'init.admin.php';

    isset($_GET['namePage']) ? $namePage = $_GET['namePage'] : $namePage = 'mange';

    if ($namePage == 'mange') { //Mange Page
        // Make Session To Pending Table
        $pending = 'false';
        if (isset($_GET['isPending']) && $_GET['isPending'] == 'yes') {
            $GLOBALS['pending'] = 'yes';
            // Check If Is Empty
            if ($_GET['isEmpty'] == 'yes') {
                echo "<p class = 'alert alert-info fade in alert-dismissible show text-center' style = 'margin-top:40px'> <strong> NOTE ! </strong>  THERE IS NO CUSTOMER WAIT PENDING  <a href='dash.admin.php'>  GO BACK</a></p>";
                exit();
            }
            $row = printInTable('*', 'users', 'NOT', 1, 1, 0, 0);
        } else {
            $GLOBALS['pending'] = 'false';
        }
        // Include table 
        include_once $tml . 'table.admin.inc.php';
    } elseif ($namePage == 'add') { // Add New Customer
        // Include Add File
        include_once $tml . 'add.admin.inc.php';
    } elseif ($namePage == 'insert') { // Insert New Customer
        // Valid The Text That Come From Insert
        $usernameInsert = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
        $emailInsert = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $passwordInsert = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $fullNameInsert = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
        // Valid The Upload Files
        $image          = $_FILES['image'];
        $imageName      = $image['name'];
        $imageType      = $image['type'];
        $imageTem        = $image['tmp_name'];
        $imageError     = $image['error'];
        $imageSize      = $image['size'];
        // Allow Images
        $typeImage  = array('png', 'jpg', 'gif', 'jpeg');
        $extImage = explode('/', $imageType);
        // Create Errors Message
        $errorArray = array();
        // Cheack And Insure That The username Must Big That 3 Char
        if (strlen($usernameInsert) <= 3)
            $errorArray[] =  "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Username Must Big That 3 Char </p>";
        // Cheack If The password Less The 3 Char
        if (strlen($passwordInsert) <= 3)
            $errorArray[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Password Must Big That 3 Char </p>";
        // Cheack If Full Name Less Than 3 Char
        if (strlen($fullNameInsert) <= 3)
            $errorArray[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Full Name Must Big That 3 Char </p>";
        // If The File Not Allow Image
        if(!empty($imageName) && !in_array(end($extImage), $typeImage))
        $errorArray[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry You Must Enter Image Like png, jpg etc.. </p>";
        // If The File Size Is Big
        if(!empty($imageSize) && $imageSize > 4194304)
        $errorArray[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Image Has Big Size </p>";
        // Before Connect Databases I Will Cheack If There Is No Error
        if (!empty($errorArray)) { // There Is Error So I Will Connect Databases
            echo '<div class = "container" style="margin-top:60px">';
            foreach ($errorArray as $error) {
                echo $error;
            }
            echo '</div>';
        }
        else { // There Is No Error So I Will Connect Databases
            // Move Uploaded File
            $imageUser = '';
            empty($imageName) ? $imageUser = '' :  $imageUser = rand(0,1000000) . '_' .$imageName;
            move_uploaded_file($imageTem, '../data/uploads/image-users/' . $imageUser);
            // Call Method To Show If The Customer Is Exist In Data OR Not Before Insert It
            $resultInsert = CheackCustomerToInsert($usernameInsert, $emailInsert);
            // If The Result 0 That Mean The User Is Already Exist And I Will Not To Insert It
            if ($resultInsert == 0) { // That Mean There Is Exist
                // Error Message That User Is Already Exist
                echo "<p class = 'container alert alert-danger fade in alert-dismissible show' style = 'margin-top:60px'> <strong> WRONG ! </strong>  The Username OR Email Is Already Exist Try Add User Not Exist </p>";
            } else { // The User Not Exist And Call Function To Add It In Databases 
                InsertCustomerInData($usernameInsert, $emailInsert, $passwordInsert, $fullNameInsert, $imageUser ,1);
            }
        }
    } elseif ($namePage == 'edit') { // Edit Information
        if (isset($_GET['namePage']) && is_string($_GET['namePage'])) {
            $statement = $conn->prepare('SELECT * FROM  `users` WHERE `user_id` = ?');
            @$_SESSION['test_id'] = $_GET['id'];
            @$statement->execute(array($_GET['id']));
            $GLOBALS['row'] = $statement->fetch();
            $count = $statement->rowCount();
            // Check If The User Is Exist In Data OR Not 
            if ($statement->rowCount() > 0) {
                // include edit file  
                include_once 'includes/template/edit.inc.admin.php';
            } else {
                echo "<p class = 'alert alert-danger fade in alert-dismissible show'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true' style='font-size:20px'>×</span> </button> Sorry THE USERNAME OR PASSWORD IS <strong> WRONG ! </strong>  </p>";
            }
        } else {
            die('There No Page ');
        }
    } elseif ($namePage == 'update') { // Update The Information
        // Check if the data come from form ?
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get The Request
            $usernameEdit = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $passwordEdit = $_POST['password'];
            $fullNameEdit = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
            $emailEdit = $_POST['email'];
            // Valid The Upload Files
            $image          = $_FILES['image'];
            $imageName      = $image['name'];
            $imageType      = $image['type'];
            $imageTem        = $image['tmp_name'];
            $imageError     = $image['error'];
            $imageSize      = $image['size'];
            // Make Array Of Errors
            $errorArray = array();
            // Allow Images
            $typeImage  = array('png', 'jpg', 'gif', 'jpeg');
            $extImage = explode('/', $imageType);
            // If The File Not Allow Image
            if(!empty($imageName) && !in_array(end($extImage), $typeImage))
            $errorArray[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry You Must Enter Image Like png, jpg etc.. </p>";
            // If The File Size Is Big
            if(!empty($imageSize) && $imageSize > 4194304)
            $errorArray[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Image Has Big Size </p>";
            // Check If There Is NO Errors
            // Before Connect Databases I Will Cheack If There Is No Error
            if (!empty($errorArray)) { // There Is Error So I Will Connect Databases
                echo '<div class = "container" style="margin-top:60px">';
                foreach ($errorArray as $error) {
                    echo $error;
                }
            echo '</div>';
            }else{ // There Is No Errors, So Update The Info
            // Check If The Username OR Password Is EXist OR Not
            $result = cheackCustomer($usernameEdit, $emailEdit, $_GET['id']);
            // if The The Result big 1 Then Show Errors Message
            if ($result >= 1) {
                // The Username or email is exist
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                Sorry The Username OR email Is Exist Try With New email OR username
                </p>";
            } else { // Up Date The Information
                $imageIcon = '';
                empty($imageName) ? $imageIcon = '' : $imageIcon  = rand(0,1000000) . '_' . $imageName;
                move_uploaded_file($imageTem, '../data/uploads/image-users/' . $imageIcon);                
                UpdateInformation($usernameEdit, $emailEdit, $passwordEdit, $fullNameEdit, $imageIcon ,$_GET['id']);
            }
        }
    }
    } elseif ($namePage == 'insertAdmin') { // To Insert New Member
        // Method To Insert New Member
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Check Customer if is exist or not
            $resultCheck = cheackItems('user_id', 'users', $_GET['id']);
            if ($resultCheck == 1) { // Call Method To Make Him Member
                // Check If This Customer Want To Remove Activity
                if (isset($_GET['removeActivity']) && $_GET['removeActivity'] == 'yes') {
                    // Modify If Come From Pending Page, Remove Activity
                    makeModify('users', 'reg_state', 0, 'user_id', $_GET['id']);
                    makeModify('comments', 'comment_status', 0, 'user_id', $_GET['id']);
                    if (isset($_GET['dash']) && $_GET['dash'] == 'yes') {
                        header('location: dash.admin.php');
                        exit();
                    }
                    header('location: customers.php');
                    exit();
                }
                // Check If The Customer Come From Activity
                if (isset($_GET['activity']) && $_GET['activity'] == 'yes') {
                    // Modify If Come From Pending Page
                    makeModify('users', 'reg_state', 1, 'user_id', $_GET['id']);
                    makeModify('comments', 'comment_status', 1, 'user_id', $_GET['id']);
                    if (isset($_GET['dash']) && $_GET['dash'] == 'yes') {
                        header('location: dash.admin.php');
                        exit();
                    }
                    header('location: customers.php');
                    exit();
                }
                // Check If I Want To Insert Him Admin
                if (isset($_GET['isCus']) && $_GET['isCus'] == 'customer') {
                    makeModify('users', 'group_id', 1, 'user_id', $_GET['id']);
                    // Change All Admin As reg State
                    makeModify('users', 'reg_state', 1, 'user_id', $_GET['id']);
                    header('location: customers.php');
                    exit();
                }
            } else { // The Id Is Wrong
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                    Sorry There Is No Sent Username
                    </p>";
            }
        } else { // Not Can Insert Without id
            echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
        Sorry There Is No Sent Username
        </p>";
        }
    } elseif ($namePage == 'delete') { // To Delete Customer OR Admin
        // Check If There id set
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Call Method To Check Is id Is Already Exist OR Not
            $resultCheck = cheackItems('user_id', 'users', $_GET['id']);
            if ($resultCheck == 1) { // Call Method To Delete
                deleteFromData('users', 'user_id', $_GET['id']);
                if (isset($_GET['isCus']) && $_GET['isCus'] == 'customer') {
                    header('location: customers.php');
                    exit();
                } else {
                    header('location: customers.php?namePage=showAdmin');
                    exit();
                }
            } else { // The Id Is Wrong
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                Sorry There Is No Sent Username
                </p>";
            }
        } else { // Not Can Insert Without id
            echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            Sorry There Is No Sent Username
            </p>";
        }
    } elseif ($namePage == 'showAdmin') { // Show Admin
        // include table admin
        include_once $tml . 'admin.table.inc.php';
    } else {
        echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                There Is No Page That Have This Name
                </p>";
    }
    // Footer page
    include_once $tml . 'footer.inc.php';
} else {

    header('location: index.php');
    exit();
}

// End The Customer Pages

// End Open Buffer
ob_end_flush();
