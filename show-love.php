<?php

namespace eCommerce\shop\showItem;

use function eCommerce\shop\includes\functions\getLoveItem;
use function eCommerce\shop\includes\functions\select;
use function eCommerce\shop\includes\functions\updateLove;

// Open Buffer
ob_start();

// start Session
session_start();

// Check If There SESSION OR Not
if (isset($_SESSION['normal-id'])) {
    // Set Value Of Navbar To Show If I Will Showing It OR Not
    $navbar = TRUE;
    // make var to show if The Lang Is Arabic OR  eng
    $lan = 'eng';
    // make the title of the page
    $pageTitle = 'Show Loves Item';
    // Call connect File
    include_once 'control-admin/includes/functions/connect.admin.php';
    // Call init File
    include_once 'init.php';
    // Check If The Item Exist In Data OR Not
    $check = getLoveItem($_SESSION['normal-id']);
    $item_save = select('*', 'items_bay');
    if (!empty($check)) { // Good This Item Is Exist In Data
        // Make This Save
        updateLove(1, $_SESSION['normal-id']);
        ?>
        <section style="margin-top: 50px">
            <div class="container department control-items">
                <div class="card custom-card">
                    <div class="card-header text-white bg-danger">
                        My Save Item
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                                    foreach ($check as $item) {
                                        echo "<div class = 'col-lg-4 col-sm-12 col-md-6'>";
                                        echo "<div class = 'card custom-card' style='width: 18rem; position: relative'>";
                                        if ($item['item_image']) {
                                            echo "<img src = 'data/uploads/image-item/" . $item['item_image'] . "' class='card-img-top img-thumbnail img-fluid' alt='Item Img'>";
                                        } else {
                                            echo "<img src = 'layout/images/defult.png' class='card-img-top img-thumbnail img-fluid' alt='Item Img'>";
                                        }
                                        # Start Love Icons
                                            foreach ($item_save as $save) {
                                                    echo "<a class = 'click-remove' href = 'mange-item.php?namePage=removeSave&save=" . $item['iteam_id'] . "'><span class = 'item-favorites'><div class = 'hart-icon red' style = 'left:15px'><i class='fas fa-heart'></i></div></span></a>";
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
                                        echo "<div class = 'card-body'>";
                                        echo "<a class = 'card-title' href = 'show-item.php?id=" . $item['iteam_id'] . "&name=" . $item['item_name'] . "'> <h5>" .  $item['item_name'] . "</h5> </a>";
                                        echo "<p class = 'card-text' >" .  $item['item_description'] . "</p>";
                                        echo "<span class = 'price' > " . "$ " . $item['price'] .  "</span>";
                                        echo "<span class = 'item-date' > " . $item['item_date'] . " </span>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }

                                    ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php
    } else { // There Is No Items
        echo "<div class = 'container' Style = 'margin-top: 50px'>";
        echo '<div class="alert alert-info" role="alert">
        <h4 class="alert-heading">Sorry!</h4>
        <p>There Is No Item Save For You</p>
        <hr>
        <p class="mb-0">To Save item Just Click In Item <a href = "index.php">Go Home</a></p>
        </div>';
        echo "</div>";
    }
    include_once $tml . 'footer.inc.php';
} else { // There Is No SESSION
    header('location: login-page.php');
    exit();
}
// End Buffer
ob_end_flush();
