<?php

namespace eCommerce\shop\mange_item;

use function eCommerce\shop\includes\functions\insertItemUser;
use function eCommerce\shop\includes\functions\getInformation;
use function eCommerce\shop\includes\functions\checkItemsUser;
use function eCommerce\shop\includes\functions\insertItems;
use function eCommerce\shop\includes\functions\check;
use function eCommerce\shop\includes\functions\checkAds;
use function eCommerce\shop\includes\functions\checkElement;
use function eCommerce\shop\includes\functions\deleteFromData;
use function eCommerce\shop\includes\functions\getAds;
use function eCommerce\shop\includes\functions\saveItem;
use function eCommerce\shop\includes\functions\updateItems;

// Open Buffer
ob_start();
// start session to allow from user to enter to dashBorder
session_start();
// Check If There Is Session OR Not
if (isset($_SESSION['normal-user']) && !empty($_SESSION['normal-id'])) {
    // make var to show if there is navigation on this page or not
    $navbar = TRUE;
    // make var to show if The Lang Is Arabic OR  eng
    $lan = 'eng';
    // make the title of the page
    $pageTitle = 'Add Item';
    // Call connect File
    include_once 'control-admin/includes/functions/connect.admin.php';
    // Call init File
    include_once 'init.php';
    // Call Function To Get The Department
    $departments = getInformation('name, department_id', 'departments', 'allow_ads', 1);
} else {
    header('location: login-page.php');
    exit();
}

$namePage = '';
isset($_GET['namePage']) ? $namePage = $_GET['namePage'] : $namePage = 'add';
if ($namePage == 'add') { // Add Page
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check If There Is Post To Add The Item
        // Assign The Variables
        $nameItem = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
        $priceItem = trim(filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT));
        $countryItem = trim(filter_var($_POST['country'], FILTER_SANITIZE_STRING));
        $statusItem = trim(filter_var($_POST['status'], FILTER_SANITIZE_STRING));
        $departmentItem = trim(filter_var($_POST['department'], FILTER_SANITIZE_NUMBER_INT));
        $amountItem = trim(filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT));
        $tagItem = trim(filter_var($_POST['tags'], FILTER_SANITIZE_STRING));
        $desItem = trim(filter_var($_POST['des'], FILTER_SANITIZE_STRING));
        // Make Error Of Array
        $errors = array();
        if (strlen($nameItem) <= 3) {
            $errors[] = "<p class = 'alert alert-danger text-center'> <strong> NOTE ! </strong>  THE NAME MUST BE BIG THAN 3 CHAR</p>";
        }
        if (filter_var($priceItem, FILTER_VALIDATE_INT) == FALSE || empty($priceItem)) {
            $errors[] = "<p class = 'alert alert-danger fade in alert-dismissible show text-center'> <strong> NOTE ! </strong>  THE PRICE MUST BE INTEGER</p>";
        }
        if (strlen($desItem) <= 9) {
            $errors[] = "<p class = 'alert alert-danger fade in alert-dismissible show text-center'> <strong> NOTE ! </strong>  THE Description MUST BE BIG THAN 9 CHAR</p>";
        }

        // Check If There Is Errors
        if (empty($errors)) { // Good, Connect Databases
            // Check If The Item Is Exist In Data For This User
            $checkItem =  checkItemsUser('items.item_name', $_SESSION['normal-id'], $nameItem);
            if (empty($checkItem)) { // Good, There Is No Item With This Name For This User
                insertItems($nameItem, $desItem, $priceItem, $amountItem, $countryItem, $statusItem, $departmentItem, $_SESSION['normal-user'], $tagItem);
                // Put The Items In Table ItemsUsers
                $item_id = check('iteam_id', 'items', 'item_name', '=', $nameItem, 'user_name', $_SESSION['normal-user']);
                insertItemUser($item_id[0]['iteam_id']);
                // Show Will Done Message
                echo "<div class = 'container' Style = 'margin-top: 50px'>";
                echo '<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Good!</h4>
                <p>This Item  [ ' . $nameItem . ' ] Add Success, But Not Approve Yet This Will Take Time For Approve Your Item From Admin</p>
                <hr>
                <p class="mb-0">Mr.' . $_SESSION['normal-user'] . ' When The Item Approved We Will Till You, Thanks For Deal With Us</p>
                </div>';
                echo "</div>";
            } else { // The Item Is Already Exist, Try With New Item
                echo "<div class = 'container' Style = 'margin-top: 50px'>";
                echo '<div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Wrong!</h4>
                <p>This Item  [ ' . $nameItem . ' ] Is Already Exist !, You Cant Add Items With Same Name</p>
                <hr>
                <p class="mb-0">Mr.' . $_SESSION['normal-user'] . ' Please Try With New Items </p>
                </div>';
                echo "</div>";
            }
        } else { // There Is Errors
            echo "<div class = 'container' style = 'margin-top: 40px'>";
            foreach ($errors as $error) {
                echo $error;
            }
            echo "</div>";
        }
    }
    if (!empty($departments)) {
        ?>
<section class="item-add">
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-dark text-center">
                <h5>Add Item</h5>
            </div>
            <div class="card-body">
                <!-- Start Form -->
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class='custom-item'>
                            <form method='POST' action='?namePage=add'>
                                <div class="form-group row">
                                    <label for="inputUsername" class="col-md-12 col-form-label">Item</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1'> <i class="fas fa-voicemail fa-fw"></i></div>
                                            <input type="text" class="form-control live" placeholder="Item Name" name='name' required title="Enter Item Name" data-class=".item-name" pattern=".{4,15}" title="The Item Between 4 & 15 Char" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Price</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1'> <i class="fas fa-money-check-alt fa-fw"></i></div>
                                            <input type="text" class="form-control live" placeholder="Price" name='price' required title="Enter Price" data-class=".item-price">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Country</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1'> <i class="fas fa-globe-europe fa-fw"></i></div>
                                            <input type="text" class="form-control" placeholder="Country" name='country' required title="Enter Country">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Status</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1 custom-icon'> <i class="fas fa-star-half-alt fa-fw"></i></div>
                                            <select class="custom-select" style="padding-left: 70px" name="status">
                                                <option value='New'> New </option>
                                                <option value='Like New'> Like New </option>
                                                <option value='Good'> Good </option>
                                                <option value='Old'> Old </option>
                                            </select>
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                Select The Status Of This Items
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Department</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1 custom-icon'> <i class="fas fa-pen-alt fa-fw"></i></div>
                                            <select class="custom-select" style="padding-left: 70px" name="department">
                                                <?php
                                                        foreach ($departments as $department) {
                                                            echo '<option value = ' . $department['department_id'] . '>' . $department['name'] . '</option>';
                                                        }
                                                        ?>
                                            </select>
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                Select The Name Of Department For This Items
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Amount</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1'> <i class="fas fa-list-ol fa-fw"></i></div>
                                            <input type="number" class="form-control" name='amount' required title="Enter Amount Of Item" max='1000' min='1'>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputUsername" class="col-md-12 col-form-label">Tag</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control control-tage" id="tags" name='tags' />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Description</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control form-control-lg live" placeholder="description" name='des' required title="Enter Description" style="height: 150px; font-size:17px" data-class=".item-des"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary custom-btn"><i class="far fa-check-square"></i> Add Item </button>
                            </form>
                        </div>
                    </div>
                    <!-- End Form -->

                    <!-- Start Item -->
                    <div class="col-md-6 col-sm-12">
                        <div class="department">
                            <div class='card' style='width: 18rem; position: relative'>
                                <img src='layout/images/robot02_90810.png' class='card-img-top img-thumbnail' alt='Item Img'>
                                <div class='card-body'>
                                    <h5 class='card-title item-name'> Title </h5>
                                    <p class='card-text item-des'> Some quick example text to build on the card title and make up the bulk of the card's content. </p>
                                    <span class='price'>$
                                        <span class='item-price'>0</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Item -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    } else { // There Is No Department Allow To Add item
        echo "<div class = 'container' Style = 'margin-top: 50px'>";
        echo '<div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Wrong!</h4>
        <p>There Is No Department To Insert New Item</p>
        <hr>
        <p class="mb-0">Mr.' . $_SESSION['normal-user'] . ' When The Departments Be Exist We Will Tell You</p>
        </div>';
        echo "</div>";
    }
} elseif ($namePage == 'edit') { // Edit Page
    // Check If The Customer Id And Item Is Exist OR Not
    if (isset($_GET['id']) && !empty(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT))) {
        // Check The Item If Exist In Data For This Id
        $check = getAds($_SESSION['normal-id'], 'yes', filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
        if (!empty($check)) { // Good The Item For This User Is Exist
            // Check If There Is Post
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Assign The Variables
                $nameItem = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
                $priceItem = trim(filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT));
                $countryItem = trim(filter_var($_POST['country'], FILTER_SANITIZE_STRING));
                $statusItem = trim(filter_var($_POST['status'], FILTER_SANITIZE_STRING));
                $departmentItem = trim(filter_var($_POST['department'], FILTER_SANITIZE_NUMBER_INT));
                $amountItem = trim(filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT));
                $tagsItem = trim(filter_var($_POST['tags'], FILTER_SANITIZE_STRING));
                $desItem = trim(filter_var($_POST['des'], FILTER_SANITIZE_STRING));
                // Make Error Of Array
                $errors = array();
                if (strlen($nameItem) <= 3) {
                    $errors[] = "<p class = 'alert alert-danger text-center'> <strong> NOTE ! </strong>  THE NAME MUST BE BIG THAN 3 CHAR</p>";
                }
                if (filter_var($priceItem, FILTER_VALIDATE_INT) == FALSE || empty($priceItem)) {
                    $errors[] = "<p class = 'alert alert-danger fade in alert-dismissible show text-center'> <strong> NOTE ! </strong>  THE PRICE MUST BE INTEGER</p>";
                }
                if (strlen($desItem) <= 9) {
                    $errors[] = "<p class = 'alert alert-danger fade in alert-dismissible show text-center'> <strong> NOTE ! </strong>  THE Description MUST BE BIG THAN 9 CHAR</p>";
                }
                // Check If There Is Errors
                if (empty($errors)) { // Good, Connect Databases
                    // Check If The Item Is Exist In Data For This User, But Not Include This Item id For Edit
                    $checkItem =  checkAds($_SESSION['normal-id'], filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT), $nameItem);
                    if (empty($checkItem)) { // Good, There Is No Item With This Name For This User
                        // Update This Item
                        updateItems($desItem, $priceItem, $amountItem, $statusItem, $departmentItem, $nameItem, $tagsItem, filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
                        // Show Will Done Message
                        echo "<p class = 'alert alert-success fade in alert-dismissible text-center show container' style = 'margin-bottom: -25px;'> <strong> Good ! </strong>  The Item Update Successfully </p>";
                    } else { // The Item Is Already Exist, Try With New Item
                        echo "<div class = 'container' Style = 'margin-top: 50px'>";
                        echo '<div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Wrong!</h4>
                    <p>This Item  [ ' . $nameItem . ' ] Is Already Exist !, You Cant Add Items With Same Name</p>
                    <hr>
                    <p class="mb-0">Mr.' . $_SESSION['normal-user'] . ' Please Try With New Items </p>
                    </div>';
                        echo "</div>";
                    }
                } else { // There Is Errors
                    echo "<div class = 'container' style = 'margin-top: 40px'>";
                    foreach ($errors as $error) {
                        echo $error;
                    }
                    echo "</div>";
                }
            }
            // Now Show Box Item
            if (!empty($departments)) {
                ?>
<section class="item-add">
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-dark text-center">
                <h5>Edit Items</h5>
            </div>
            <div class="card-body">
                <!-- Start Form -->
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class='custom-item'>
                            <form method='POST' action='?namePage=edit&id=<?php echo filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); ?>'>
                                <div class="form-group row">
                                    <label for="inputUsername" class="col-md-12 col-form-label">Items Name</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1'> <i class="fas fa-voicemail fa-fw"></i></div>
                                            <input type="text" class="form-control live" placeholder="Item Name" name='name' required title="Enter Item Name" data-class=".item-name" value="<?php echo $check[0]['item_name']; ?>" pattern=".{4,15}" title="The Item Between 4 & 15 Char" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Price</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1'> <i class="fas fa-money-check-alt fa-fw"></i></div>
                                            <input type="text" class="form-control live" placeholder="Price" name='price' required value="<?php echo $check[0]['price']; ?>" title="Enter Price" data-class=".item-price">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Country</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1'> <i class="fas fa-globe-europe fa-fw"></i></div>
                                            <input type="text" class="form-control" placeholder="Country" value="<?php echo $check[0]['country']; ?>" name='country' required title="Enter Country">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Status</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1 custom-icon'> <i class="fas fa-star-half-alt fa-fw"></i></div>
                                            <select class="custom-select" style="padding-left: 70px" name="status">
                                                <option <?php if ($check[0]['item_status'] == 'New') {
                                                                            echo 'selected';
                                                                        } ?> value='New'> New </option>
                                                <option <?php if ($check[0]['item_status'] == 'Like New') {
                                                                            echo 'selected';
                                                                        } ?> value='Like New'> Like New </option>
                                                <option <?php if ($check[0]['item_status'] == 'Good') {
                                                                            echo 'selected';
                                                                        } ?> value='Good'> Good </option>
                                                <option <?php if ($check[0]['item_status'] == 'Old') {
                                                                            echo 'selected';
                                                                        } ?> value='Old'> Old </option>
                                            </select>
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                Select The Status Of This Items
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Department</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1 custom-icon'> <i class="fas fa-pen-alt fa-fw"></i></div>
                                            <select class="custom-select" style="padding-left: 70px" name="department">
                                                <?php
                                                                foreach ($departments as $department) { ?>
                                                <option <?php if ($department['department_id'] == $check[0]['department_id']) {
                                                                                echo 'selected';
                                                                            } ?> value="<?php echo $department['department_id']; ?>"> <?php echo $department['name']; ?> </option>
                                                <?php } ?>
                                            </select> <small id="passwordHelpBlock" class="form-text text-muted">
                                                Select The Name Of Department For This Items
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Amount</label>
                                    <div class="col-sm-12">
                                        <div class='input-con'>
                                            <div class='i1'> <i class="fas fa-list-ol fa-fw"></i></div>
                                            <input type="number" class="form-control" name='amount' value="<?php echo $check[0]['amount']; ?>" required title="Enter Amount Of Item" max='1000' min='1'>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputUsername" class="col-md-12 col-form-label">Tag</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control control-tage" id="tags" name='tags' value="<?php echo $check[0]['item_tags']; ?>" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Description</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control form-control-lg live" placeholder="description" name='des' required title="Enter Description" style="height: 150px; font-size:17px" data-class=".item-des"><?php echo $check[0]['item_description'] ?></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary custom-btn"><i class="far fa-check-square"></i> Add Item </button>
                            </form>
                        </div>
                    </div>
                    <!-- End Form -->

                    <!-- Start Item -->
                    <div class="col-md-6 col-sm-12">
                        <div class="department">
                            <div class='card' style='width: 18rem; position: relative'>
                                <img src='layout/images/robot02_90810.png' class='img-fluid card-img-top img-thumbnail' alt='Item Img'>
                                <div class='card-body'>
                                    <h5 class='card-title item-name'> <?php echo $check[0]['item_name']; ?> </h5>
                                    <p class='card-text item-des'> <?php echo $check[0]['item_description']; ?> </p>
                                    <span class='price'>$
                                        <span class='item-price'><?php echo $check[0]['price']; ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Item -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php
            } else { // There Is No Department Allow To Add item
                echo "<div class = 'container' Style = 'margin-top: 50px'>";
                echo '<div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Wrong!</h4>
                <p>There Is No Department To Insert New Item</p>
                <hr>
                <p class="mb-0">Mr.' . $_SESSION['normal-user'] . ' When The Departments Be Exist We Will Tell You</p>
                </div>';
                echo "</div>";
            }
        } else { // Bad, This Item Not For You, OR Not Found
            header('location: index.php');
            exit();
        }
    } else { // Go Index Because The Id Not Set OR empty
        header('location: index.php');
        exit();
    }
} elseif ($namePage == 'delete') { // Delete Page
    // Check If There Is Id Sent
    if (isset($_GET['id']) && !empty($_GET['id'])) { // Good There Is Id Send
        // Check If This Item For This Customer
        $checkItem = check('items_id', 'items_user', 'items_id', '=', filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT), 'user_id', $_SESSION['normal-id']);
        if (!empty($checkItem)) { // Good, This Items For This Customer
            deleteFromData('items', 'iteam_id', $_GET['id']);
            header('location: profile.php');
            exit();
        } else { // Bad, This Items Not For This Customer
            header('location: index.php');
            exit();
        }
    } else { // Bad, There Is No Id Sent
        header('location: index.php');
        exit();
    }
} elseif ($namePage == 'deleteComment') { // Delete Comment
    // Check If This Comment For This Customer
    // Check If This Item For This Customer
    $checkItem = check('comment_id', 'comments', 'comment_id', '=', filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT), 'user_id', $_SESSION['normal-id']);
    if (!empty($checkItem)) { // Good, Delete This Comment
        // Delete The Comment
        deleteFromData('comments', 'comment_id', filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
        header('location: show-item.php?id=' . $_GET['di'] . '&' . 'name=' . $_GET['dn'] . '#comments');
        exit();
    } else { // Bad, Dont Delete This Comment
        header('location: index.php');
        exit();
    }
} elseif ($namePage == 'save') { // Save Item
    // Check If The Id Sent OR Not
    if (isset($_GET['save']) && !empty(filter_var($_GET['save'], FILTER_VALIDATE_INT))) {
        // Check If The Item Is Exist In Table To Save It
        $check = getInformation('iteam_id', 'items', 'iteam_id', $_GET['save']);
        if (!empty($check)) { // Good There Is Id In Table
            // Check If This User Is Already Have This OR Not
            $checkA = checkElement('user_id', 'items_bay', 'user_id', $_SESSION['normal-id'], 'item_id', $_GET['save']);
            if ($checkA == 0) { // Good This Item Not Fount To Insert Again
                // Insert And Save The Item
                saveItem($_SESSION['normal-id'], $_GET['save']);
                $referer  = $_SERVER['HTTP_REFERER'];
                header('location:' . $referer);
            } else { // This Item Already Exist
                header('location: index.php');
                exit();
            }
        } else {
            header('location: index.php');
            exit();
        }
    } else { // There Is No Is Sent
        header('location: index.php');
        exit();
    }
} elseif ($namePage == 'removeSave') { // Remove Save
    if (isset($_GET['save']) && !empty(filter_var($_GET['save'], FILTER_VALIDATE_INT))) { 
        // Check If This Item Is Exist For This User And Save
        $check = checkElement('item_id', 'items_bay', 'user_id', $_SESSION['normal-id'], 'item_id', $_GET['save']);
        if(!empty($check)){ // Good This Item For This Customer And Its Save
           deleteFromData('items_bay','item_id', $_GET['save'], '&& user_id = '. $_SESSION['normal-id']);
           $referer  = $_SERVER['HTTP_REFERER'];
           header('location:' . $referer);
           exit();          
        }else{ // There Is No Item Save For This Customer
            header('location: index.php');
            exit();
        }
    } else { // There Is No Sent Id
        header('location: index.php');
        exit();
    }
} else { // There Is No Page
    header('location: index.php');
    exit();
}
include_once $tml . 'footer.inc.php';
// Exit Open Buffer
ob_end_flush();
