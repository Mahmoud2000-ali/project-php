<?php

namespace eCommerce\shop\tags;

use function eCommerce\shop\includes\functions\getTags;

// Open Buffer
ob_start();

// start Session
session_start();

// Check If There Is Id Sent OR Not
if (isset($_GET['name']) && !empty($_GET['name'])) {

    // Set Value Of Navbar To Show If I Will Showing It OR Not
    $navbar = TRUE;
    // make var to show if The Lang Is Arabic OR  eng
    $lan = 'eng';
    // make the title of the page
    $pageTitle = filter_var($_GET['name'], FILTER_SANITIZE_STRING);
    // Call connect File
    include_once 'control-admin/includes/functions/connect.admin.php';
    // Call init File
    include_once 'init.php';
    $items = getTags($_GET['name']);
        if (!empty($items)) {
            ?>
<!-- Start Box Show -->
<div class="container department">
    <h2 class="text-center heading-title"> <?php echo str_replace('-', ' ', $_GET['name']); ?> </h2>
    <div class="row">
        <?php
                    foreach ($items as $item) {
                        if ($item['item_approve'] == 1) {
                            echo "<div class = 'col-lg-4 col-sm-12 col-md-6'>";
                            echo "<div class = 'card custom-card' style='width: 18rem; position: relative'>";
                            if($item['item_image']){
                                echo "<img src = 'data/uploads/image-item/". $item['item_image']."' class='card-img-top img-thumbnail img-fluid' alt='Item Img'>";
                            }else{
                                echo "<img src = 'layout/images/defult.png' class='card-img-top img-thumbnail img-fluid' alt='Item Img'>";
                            }
                            echo "<div class = 'card-body'>";
                            echo "<a class = 'card-title' href = 'show-item.php?id=" . $item['iteam_id'] . "&name=" .$item['item_name'] . "'> <h5>" .  $item['item_name'] . "</h5> </a>";
                            echo "<p class = 'card-text' >" .  $item['item_description'] . "</p>";
                            echo "<span class = 'price'> $" . $item['price'] .  "</span>";
                            echo "<span class = 'item-date'> " . $item['item_date'] . "</span>";
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
        } else { // There Is No Tags
            echo "<p class = 'alert alert-info fade in alert-dismissible show text-center' style = 'margin-top:40px'> <strong> NOTE ! </strong>  THERE IS NO Tags  <a href='index.php'>  GO HOME</a></p>";
        }
    include_once $tml . 'footer.inc.php';
} else { // There Is No Department Id Sent
    header('Location: index.php');
    exit();
}
// End Buffer
ob_end_flush();
