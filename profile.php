<?php

namespace eCommerce\shop\profile;

use function eCommerce\shop\includes\functions\getAds;
use function eCommerce\shop\includes\functions\getInformation;

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
    $pageTitle = 'Profile';

    // Call connect File
    include_once 'control-admin/includes/functions/connect.admin.php';
    // Call init File
    include_once 'init.php';
    // Call Function To Get The Information For The Username
    $information = getInformation('*', 'users', 'user_id', $_SESSION['normal-id']);
    // Call Function To Get The Ads For The Username
    $allAds = getAds($_SESSION['normal-id']);

    // Call Function To Git The Comment
    $comments = getInformation('*', 'comments', 'user_id', $_SESSION['normal-id']);
    ?>

<h2 class="text-center heading-title profile-heading">My Profile</h2>

<section class="information">
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-info">
                My Information
            </div>
            <div class="card-body">
                <p class="card-text"> <?php echo "<span> <i class='fas fa-user fa-fw' style = 'color: #17a2b8;font-size: 18px' ></i> Username : </span>";
                                            echo $information[0]['username']; ?></p>
                <p class="card-text"> <?php echo "<span> <i class='fas fa-envelope fa-fw' style = 'color: #17a2b8;font-size: 18px' ></i> Email : </span>";
                                            echo $information[0]['email']; ?></p>
                <p class="card-text"> <?php echo "<span> <i class='fas fa-lock fa-fw' style = 'color: #17a2b8;font-size: 18px' ></i> Password : </span>";
                                            echo $information[0]['password']; ?></p>
                <p class="card-text"> <?php echo "<span> <i class='fas fa-user-tie fa-fw' style = 'color: #17a2b8;font-size: 18px' ></i> Full Name : </span>";
                                            echo $information[0]['full_name']; ?></p>
                <p class="card-text"> <?php echo "<span> <i class='fas fa-clock fa-fw' style = 'color: #17a2b8;font-size: 18px' ></i> Reg Date : </span>";
                                            echo $information[0]['date']; ?></p>
            </div>
        </div>
    </div>
</section>

<section class="ads" id="item-show">
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-dark">
                My Item
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                        if (!empty($allAds)) {
                            foreach ($allAds as $item) {
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
                                echo "<span class = 'price' > " . "$ " . $item['price'] .  "</span>";
                                echo "<a class = 'btn btn-success btn-sm cart-text' href = 'mange-item.php?namePage=edit&id=" . $item['iteam_id'] . "' ><i class='far fa-edit fa-fw'></i>Edit</a>";
                                echo '<a data-toggle="modal" data-target="#' .  $item['iteam_id'] . "  " . '"class="btn btn-danger btn-sm" style="color:#fff; margin-left: 5px"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
                                // Show Message To Confirm Delete Admin
                                echo '
                <div class="modal fade" id="' .  $item['iteam_id'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Items</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are You Source To Remove ' . $item['item_name'] . ' ? <br> That Will Remove This Items
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <a href = "mange-item.php?namePage=delete&id=' . $item['iteam_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                      </div>
                    </div>
                  </div>
                </div>';
                                if ($item['item_approve'] == 1) {
                                    echo "<span class = 'success-approve' > Success Approve</span>";
                                } else {
                                    echo "<span class = 'not-approve' > Not Approve</span>";
                                }
                                echo "<span class = 'item-date' > " . $item['item_date'] . " </span>";
                                echo "</div>";                                
                                echo "</div>";
                                echo "</div>";
                                
                            }
                        } else {
                            echo "<p class = 'card-text' style = 'margin-left: 15px' >There Is No Item <a href='mange-item.php'>Add Item</a></p>";
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="comment">
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-success ">
                My Comment
            </div>
            <div class="card-body">
                <?php
                    if (!empty($comments)) {
                        echo "<ul class = 'list-unstyled'>";
                        foreach ($comments as $comment) {
                            echo "<li>" . $comment['comment'] . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p class = 'card-text'>There Is No Comments For You</p>";
                    }
                    ?>
            </div>
        </div>
    </div>
</section>

<?php
} else {
    header("location: login-page.php");
    exit();
}


include_once $tml . 'footer.inc.php';
// Exit Open Buffer
ob_end_flush();
