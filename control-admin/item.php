<?php
/*
    ===================================================
    ==== Items Page 
    ==
    ===================================================

*/

namespace eCommerce\admin\items;

use function eCommerce\admin\includes\functions\insertItems;
use function eCommerce\admin\includes\functions\cheackItemsForUser;
use function eCommerce\admin\includes\functions\insertItemUser;
use function eCommerce\admin\includes\functions\cheackItems;
use function eCommerce\admin\includes\functions\gdfATo;
use function eCommerce\admin\includes\functions\checkItemsAfterEdit;
use function eCommerce\admin\includes\functions\deleteFromData;
use function eCommerce\admin\includes\functions\makeModify;
use function eCommerce\admin\includes\functions\updateItems;

// Open out put Buffer
ob_start();
// Name Page
$namePage = '';
// Check If There Is Cookie
if (isset($_COOKIE['cookie-admin']) && !empty($_COOKIE['cookie-admin'])) {
    $_SESSION['user'] = $_COOKIE['cookie-admin'];
    // make var to show if there is navigation on this page or not
    $navbar = TRUE;
    // make the title of the page
    $pageTitle = 'Items';
    // make the language of the page
    $lan = 'eng';
    // inclued the connect db and nav and header and the language file
    include_once 'init.admin.php';
    isset($_GET['namePage']) ? $namePage = $_GET['namePage'] : $namePage = 'mange';
    // Check What The Customer Want From This Page

    if ($namePage == 'mange') { // Mange Page
        // Include The Mange Items
        include_once $tml . 'item-table.inc.php';
    } elseif ($namePage == 'add') { // Add Page
        // Include Add Item
        include_once $tml . 'add-item.inc.php';
    } elseif ($namePage == 'insert') { // Insert Item Page
        // Check If The Data Come From Post OR Not
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Do Work
            // Assign The Value In Variables
            $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $price      = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
            $country    = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
            $status     = $_POST['status'];
            $department = $_POST['department'];
            $amount     = $_POST['amount'];
            $tags       = $_POST['tags'];
            $des        = $_POST['des'];
            // Valid The Upload Files
            $image          = $_FILES['image'];
            $imageName      = $image['name'];
            $imageType      = $image['type'];
            $imageTem        = $image['tmp_name'];
            $imageError     = $image['error'];
            $imageSize      = $image['size'];
            // Make Array Of Errors
            $errorArray = array();
            // Make Allow Image
            $allowImage = array('png', 'jpg', 'gif', 'jpeg', 'tiff');
            $imageExt = explode('.', $imageName);
            // Check If This Not Image
            if (!empty($imageName) && !in_array(end($imageExt), $allowImage)) {
                $errorArray[] = '<p style = "margin-top: 30px" class = "alert alert-danger fade in alert-dismissible show text-center"><strong>Error</strong> This Not Allow Please Chose Image </p>';
            }
            // Check The Size
            if (!empty($imageName) && $imageSize > 4000000) {
                $errorArray[] = '<p style = "margin-top: 30px" class = "alert alert-danger fade in alert-dismissible show text-center"><strong>Error</strong> Big Image ? Not Allow </p>';
            }
            // Check If There Is Errors Before Connect Data OR Not
            if (!empty($errorArray)) { // There Is Errors, Not Connect
                echo "<div class = 'container'>";
                foreach ($errorArray as $error) {
                    echo $error;
                }
                echo "</div>";
            } else { // Good There Is Errors
                // Check If The Item Is Already In Data, Note Check According Users
                $itemIcon = '';
                empty($imageName) ? $itemIcon = '' : $itemIcon = rand(0, 10000) . '_' . $imageName;
                move_uploaded_file($imageTem, '../data/uploads/image-item/' . $itemIcon);
                $array = cheackItemsForUser('item_name', 'items', 'item_name', $name, 'user_name', $_COOKIE['cookie-admin']);
                if (count($array) == 0) { // There Is No Item In Data That Have This Name, So Do Work
                    insertItems($name, $des, $tags, $price, $amount, $country, $status, $department, $itemIcon, $_COOKIE['cookie-admin']);
                    // Insert Into User Item
                    $item_id = cheackItemsForUser('iteam_id', 'items', 'item_name', $name, 'user_name', $_COOKIE['cookie-admin']);
                    // Insert In Table Items Users 
                    insertItemUser($item_id[0]['iteam_id']);
                    header('location: ?namePage=mange');
                } else { // This Name Is Already Exist, Try With New Name
                    echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                This Item Is Already Exist, <a href='item.php?namePage=add'>Try With New Item</a>
                </p>";
                }
            }
        } else { // Not allow To Inter This Page Without Post 
            echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            Not Allowed To Be Here
            </p>";
        }
    } elseif ($namePage == 'edit') { // Edit The Departments
        // Check If The Id If Sent OR Not
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Check If The Id Exist In Databases OR Not
            $check = cheackItems('iteam_id', 'items', $_GET['id']);
            if ($check == 1) {
                // Include The edit File
                include_once $tml . 'edit-item.inc.php';
            } else { // The Id Dos Not Exist
                echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                The ID Dos Not Exist In Data
                </p>";
            }
        } else { // The Id Not Sent
            echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            There Is No Id Sent
            </p>";
        }
    } elseif ($namePage == 'update') { // Update The Items
        // Check If The Page Come From POst OR Not
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check If There Sent Id OR Not
            if (isset($_GET['id']) && !empty($_GET['id'])) { // The Id Is Send
                // Check If The Id Is Exist In Data OR Not
                $check = gdfATo('item_name', 'items', 'iteam_id', $_GET['id']);
                if (!empty($check)) { // The Id Is Exist In Data
                    // Assign The Data In Variable
                    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                    $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
                    $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
                    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
                    $department = filter_var($_POST['department'], FILTER_SANITIZE_STRING);
                    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);
                    $tags = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
                    $des = filter_var($_POST['des'], FILTER_SANITIZE_STRING);
                    $username = $_POST['username'];
                    // Valid The Upload Files
                    $image          = $_FILES['image'];
                    $imageName      = $image['name'];
                    $imageType      = $image['type'];
                    $imageTem        = $image['tmp_name'];
                    $imageError     = $image['error'];
                    $imageSize      = $image['size'];
                    // Make Array Of Errors
                    $errorArray = array();
                    // Make Allow Image
                    $allowImage = array('png', 'jpg', 'gif', 'jpeg', 'tiff');
                    $imageExt = explode('.', $imageName);
                    // Check If This Not Image
                    if (!empty($imageName) && !in_array(end($imageExt), $allowImage)) {
                        $errorArray[] = '<p style = "margin-top: 30px" class = "alert alert-danger fade in alert-dismissible show text-center"><strong>Error</strong> This Not Allow Please Chose Image </p>';
                    }
                    // Check The Size
                    if (!empty($imageName) && $imageSize > 4000000) {
                        $errorArray[] = '<p style = "margin-top: 30px" class = "alert alert-danger fade in alert-dismissible show text-center"><strong>Error</strong> Big Image ? Not Allow </p>';
                    }
                    if (!empty($errorArray)) { // There Is Errors, Not Connect
                        echo "<div class = 'container'>";
                        foreach ($errorArray as $error) {
                            echo $error;
                        }
                        echo "</div>";
                    } else {
                        // Check If The New Name Is Exist OR Not
                        $checkItems = checkItemsAfterEdit('item_name', 'items', 'user_name', $username, 'iteam_id', $_GET['id'], 'item_name', $name);
                        if ($checkItems == 0) { // There Is No Items Have This Name, Then Do Work
                            // Call The Function To Update The Data
                            $itemIcon = '';
                            empty($imageName) ? $itemIcon = '' : $itemIcon = rand(0, 10000) . '_' . $imageName;
                            move_uploaded_file($imageTem, '../data/uploads/image-item/' . $itemIcon);
                            updateItems($des, $price, $amount, $country, $status, $department, $name, $tags, $itemIcon ,$_GET['id']);
                            header('location: item.php');
                           echo $itemIcon;
                        } else { // There Is Items Have The Same Name For His Users
                            echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                    This Items Is Already Exist, Please Try With New Items 
                    </p>";
                        }
                    }
                } else { // The Id Not Exist In Data
                    echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                The Id Not Exist In Data
                </p>";
                }
            } else { // The Id Not Sent
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            There Is No Id Send
            </p>";
            }
        } else { // The Personal Come Without The Post 
            echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            Not Allow To Come
            </p>";
        }
    } elseif ($namePage == 'delete') { // Delete Page
        // Check If The Id Is Sent OR Not
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Check If The Id Is Exist In Data OR Not
            $check = cheackItems('iteam_id', 'items', $_GET['id']);
            if ($check == 1) { // The Id Is Exist, Then Do Work
                deleteFromData('items', 'iteam_id', $_GET['id']);
                header('location: item.php');
            } else { // The Id Not Exist In Data
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                The Id Dos Not Exist In Data
                </p>";
            }
        } else { // The Id Not Sent
            echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            There Is No Id Sent
            </p>";
        }
    } elseif ($namePage == 'approve') { // approve Page
        // Check If There Is Id Sent OR Not
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Check If The Id Is Exist In Data OR Not
            $check = cheackItems('iteam_id', 'items', $_GET['id']);
            if ($check == 1) { // The Id Is Exist, Then Do Work
                if (isset($_GET['removeApprove']) && $_GET['removeApprove'] == 'yes') { // Remove Approve
                    makeModify('items', 'item_approve', 0, 'iteam_id', $_GET['id']);
                } else { // Make Approve
                    makeModify('items', 'item_approve', 1, 'iteam_id', $_GET['id']);
                }
                header('location: item.php');
            } else { // The Id Not Exist In Data
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                The Id Dos Not Exist In Data
                </p>";
            }
        } else { // The Id Not Sent
            echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            There Is No Id Sent
            </p>";
        }
    } else { // namePage Dos Not Exist
        echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                There Is No Page That Have This Name
                </p>";
    }
    // Footer page
    include_once $tml . 'footer.inc.php';
} else { // The Person Not Allow To Enter This Page
    header('location: index.php');
    exit();
}

ob_end_flush();
