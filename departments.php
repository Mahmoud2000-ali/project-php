<?php

namespace eCommerce\shop\departments;

use function eCommerce\shop\includes\functions\checkElement;
use function eCommerce\shop\includes\functions\getItems;
use function eCommerce\shop\includes\functions\select;

// Open Buffer
ob_start();

// start Session
session_start();

// Check If There Is Id Sent OR Not
if (isset($_GET['departmentId']) && !empty($_GET['departmentName'])) {
    // Set Value Of Navbar To Show If I Will Showing It OR Not
    $navbar = TRUE;
    // make var to show if The Lang Is Arabic OR  eng
    $lan = 'eng';
    // make the title of the page
    $pageTitle = str_replace('-', ' ', $_GET['departmentName']);
    // Call connect File
    include_once 'control-admin/includes/functions/connect.admin.php';
    // Call init File
    include_once 'init.php';
    // Check If The Department Exist In Data OR Not
    $count = checkElement('name', 'departments', 'department_id', $_GET['departmentId'], 'name', str_replace('-', ' ', $_GET['departmentName']));
    if ($count == 1) { // Good, The Department Exist In Data
        // Get Method To Get The Items
        $items = getItems($_GET['departmentId'], 1, "ORDER BY item_date DESC");
        $item_save = select('*', 'items_bay');
        if (!empty($items)) {
            ?>
            <!-- Start Box Show -->
            <div class="container department">
                <h2 class="text-center heading-title"> <?php echo str_replace('-', ' ', $_GET['departmentName']); ?> </h2>
                <div class="row">
                    <?php
                                foreach ($items as $item) {
                                    if ($item['item_approve'] == 1) {
                                        echo "<div class = 'col-lg-4 col-sm-12 col-md-6'>";
                                        echo "<div class = 'card custom-card' style='width: 18rem; position: relative'>";
                                        if ($item['item_image']) {
                                            echo "<img src = 'data/uploads/image-item/" . $item['item_image'] . "' class='card-img-top img-thumbnail img-fluid' alt='Item Img'>";
                                        } else {
                                            echo "<img src = 'layout/images/defult.png' class='card-img-top img-thumbnail img-fluid' alt='Item Img'>";
                                        }
                                        echo "<div class = 'card-body'>";
                                        echo "<a class = 'card-title' href = 'show-item.php?id=" . $item['iteam_id'] . "&name=" . $item['item_name'] . "'> <h5>" .  $item['item_name'] . "</h5> </a>";
                                        echo "<p class = 'card-text' >" .  $item['item_description'] . "</p>";
                                        echo "<span class = 'price'> $" . $item['price'] .  "</span>";
                                        echo "<span class = 'item-date'> " . $item['item_date'] . "</span>";
                                        # Start Love Icons
                                        if (isset($_SESSION['normal-id'])) {
                                            #if there is no save for all table I Will To Save It
                                            echo "<a href = 'mange-item.php?namePage=save&save=" . $item['iteam_id'] . "'><span class = 'item-favorites'><div class = 'hart-icon'><i class='fas fa-heart'></i></div></span></a>";
                                            foreach ($item_save as $save) {
                                                if ($save['user_id'] == $_SESSION['normal-id'] && $save['item_id'] == $item['iteam_id']) { // Yes It Exist, And I Will To  Remove It From Save Table
                                                    echo "<a href = 'mange-item.php?namePage=removeSave&save=" . $item['iteam_id'] . "'><span class = 'item-favorites'><div class = 'hart-icon red'><i class='fas fa-heart'></i></div></span></a>";
                                                } else { // There Is No, I Will To Save It
                                                    echo "<a href = 'mange-item.php?namePage=save&save=" . $item['iteam_id'] . "'><span class = 'item-favorites'><div class = 'hart-icon'><i class='fas fa-heart'></i></div></span></a>";
                                                }
                                            }
                                        } else {
                                            echo "<span class = 'item-favorites click-me'><div class = 'hart-icon'><i class='fas fa-heart'></i></div></span>";
                                        }
                                        # End Love Icons
                                        if ($item['item_status'] == 'New') {
                                            echo "<span class = 'item-status btn-success'> " . $item['item_status'] . "</span>";
                                        } elseif ($item['item_status'] == 'Like New') {
                                            echo "<span class = 'item-status btn-info'> " . $item['item_status'] . "</span>";
                                        } elseif ($item['item_status'] == 'Good') {
                                            echo "<span class = 'item-status btn-warning'> " . $item['item_status'] . "</span>";
                                        } else {
                                            echo "<span class = 'item-status btn-danger'> " . $item['item_status'] . "</span>";
                                        }
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                }
                                ?>
                </div>
            </div>

<?php
        } else { // There Is No Items
            echo "<div class = 'container' Style = 'margin-top: 50px'>";
            echo '<div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Sorry!</h4>
            <p>There Is No Item In This Department</p>
            <hr>
            <p class="mb-0">When The Departments Be Exist We Will Tell You</p>
            </div>';
            echo "</div>";
        }
    } else { // The Department No Exist In Data
        header('Location: index.php');
        exit();
    }

    include_once $tml . 'footer.inc.php';
} else { // There Is No Department Id Sent
    header('Location: index.php');
    exit();
}
// End Buffer
ob_end_flush();
