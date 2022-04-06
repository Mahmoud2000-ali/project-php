<?php

namespace eCommerce\shop\showItem;

use function eCommerce\shop\includes\functions\checkElement;
use function eCommerce\shop\includes\functions\getAdsForItems;
use function eCommerce\shop\includes\functions\getComment;
use function eCommerce\shop\includes\functions\getInformation;
use function eCommerce\shop\includes\functions\insertComment;

// Open Buffer
ob_start();

// start Session
session_start();

// Check If There Is Id Sent OR Not
if (isset($_GET['id']) && !empty($_GET['id']) && !empty($_GET['name'])) {
    // Set Value Of Navbar To Show If I Will Showing It OR Not
    $navbar = TRUE;
    // make var to show if The Lang Is Arabic OR  eng
    $lan = 'eng';
    // make the title of the page
    $pageTitle = $_GET['name'];
    // Call connect File
    include_once 'control-admin/includes/functions/connect.admin.php';
    // Call init File
    include_once 'init.php';
    // Check If The Item Exist In Data OR Not
    $check = getInformation('id', 'items_user', 'items_id', filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
    // Get Ads
    $items = getAdsForItems(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
    // Function To Check If This Item Is Approve OR Not
    $checkApprove = checkElement('item_name', 'items', 'iteam_id', filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT), 'item_approve', '1');
    if (!empty($check) && !empty($checkApprove)) { // Good This Item Is Exist In Data
        // Function To Get The Name Department For This Item
        $department = getInformation('name', 'departments', 'department_id', $items['department_id']);
        // Layout The Information
        // Function To Get The Comment
        $comments = getComment($_GET['id'], 1);
        ?>
<section class="show-item">
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-info">
                <h5 class="text-center"> <?php echo $_GET['name']; ?> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Start Image Item -->
                    <div class="col-md-4 col-sm-12">
                        <?php 
                        if($items['item_image']){
                            echo "<img src = 'data/uploads/image-item/". $items['item_image']."' class='img-fluid card-img-top img-thumbnail control-img' alt='Item Img'>";
                        }else{
                            echo "<img src='layout/images/defult.png' class='img-fluid card-img-top img-thumbnail control-img' alt='Item Img'>";  
                        }
                        ?>
                    </div>
                    <!-- End Image Item -->
                    <!-- Start Information -->
                    <div class="col-md-8 col-sm-12">
                        <section class="item-show-info">
                            <h4 class="card-text"><?php echo $items['item_name']; ?></h4>
                            <p class="card-text"><?php echo $items['item_description']; ?></p>
                            <ul class="list-unstyled">
                                <li><span><span class="des"><i class="fas fa-globe-europe fa-fw" style='color: #fff;font-size: 19px'></i> Made In :</span><span class="span-control"><?php echo $items['country']; ?></span></span></li>
                                <li><span><span class="des"><i class="fas fa-star-half-alt fa-fw" style='color: #17a2b8;font-size: 19px'></i> Status :</span><span class="span-control"><?php echo $items['item_status']; ?></span></span></li>
                                <li><span><span class="des"><i class="fas fa-money-check-alt fa-fw" style='color: #fff;font-size: 19px'></i> Price :</span><span class="span-control"><?php echo $items['price']; ?></span></span></li>
                                <li><span><span class="des"><i class="fas fa-clock fa-fw" style='color: #17a2b8;font-size: 19px'></i> Date :</span><span class="span-control"><?php echo $items['item_date']; ?></span></span></li>
                                <li><span><span class="des"><i class="fas fa-user-tie fa-fw" style='color: #fff;font-size: 19px'></i> Person :</span><span class="span-control"><?php echo $items['full_name']; ?></span></li>
                                <li><span><span class="des"><i class="fas fa-pen-alt fa-fw" style='color: #17a2b8;font-size: 19px'></i> Department :</span><span class="span-control"><?php echo $department[0]['name']; ?></span></span></li>
                                <li>
                                    <span><span class="des"><i class="fas fa-tags fa-fw" style='color: #fff;font-size: 19px'></i> Tags :</span><?php
                                        if($items['item_tags']){
                                            $tags = explode(',',$items['item_tags']);
                                            echo '<span class="span-control">';
                                            foreach($tags as $tag){                                              
                                               ?>
                                               <a class = "control-tags" href="show-tags.php?name=<?php echo $tag?>"> <?php echo $tag?></a>
                                         <?php   } echo '</span>';
                                        }else 
                                            echo "No Tags For This Item";?>
                                    </span>
                                </li>
                            </ul>
                        </section>
                    </div>
                    <!-- End Information -->
                </div>
                <!-- Start Comments -->
                <!-- Start text Area Form -->
                <?php if (isset($_SESSION['normal-id'])) { ?>
                <form class="comment-form" actions="?id=<?PHP echo $_GET['id']; ?>&name=<?php echo $_GET['name']; ?>" method="POST">
                    <textarea class="form-control" title="Set Comment For This Items" placeholder="Enter Your Comment For This Item..." name='comment' required></textarea>
                    <button type="submit" class="btn btn-success btn-block"><i class="far fa-paper-plane fa-fw"></i> Sent Comments</button>
                    <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    // Check And Format The Comment
                                    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                                    // Insert The Comment
                                    insertComment($comment, $_GET['id'], $_SESSION['normal-id']);
                                    // Function To Get The Comment
                                    $comments = getComment($_GET['id'], 1);
                                    header('location: show-item.php?id='.$_GET['id'].'&'.'name='.$_GET['name'].'#comments');
                                }
                                ?>
                </form>
                <?php } else {
                            echo "<p class = 'alert alert-info fade in alert-dismissible show text-center' style = 'margin: auto; margin-top:30px'> <strong> NOTE ! </strong>  To Enable Post Comment You Must <a href='login-page.php'> Login </a> OR <a href='login-page.php'> SignUp </a> </p>";
                        }
                        foreach ($comments as $comment) {
                                ?>
                <div class="comment-box" id="comments" style="padding-top:20px">
                    <div class="row">
                        <div class="col-sm-3">
                            <figure class="img-comment">
                                <img class="img-thumbnail" src="<?php if($comment['user_image']) echo 'data/uploads/image-users/' . $comment['user_image']; else echo 'layout/images/robot02_90810.png'; ?>" alt="Person Image">
                            </figure>
                            <span class="username"><?php if($comment['comment_status'] == 0 ) echo 'Username'; else echo $comment['username'];?></span>
                        </div>
                        <div class="col-sm-9">
                            <section class="comment-text">
                                <p><?php if($comment['comment_status'] == 0) echo 'This Comment Delete'; else echo $comment['comment'];?></p>
                               <?php
                               if(isset($_SESSION['normal-id'])){
                                    if($comment['user_id'] == $_SESSION['normal-id']){?>
                                     <div class="comment-mange">
                                    <a class="btn btn-sm btn-success" href="#"><i class="far fa-edit fa-fw"></i>Edit </a>
                                    <a class="btn btn-sm btn-danger" href="mange-item.php?namePage=deleteComment&id=<?php echo $comment['comment_id']; ?>&di=<?php echo $_GET['id'];?>&dn=<?php echo $_GET['name'];?>"><i class="far fa-trash-alt fa-fw"></i>Delete </a>
                                </div>
                                    <?php  } }?>
                                <span class="date"><?php echo $comment['comment_date']; ?></span>
                            </section>
                        </div>
                    </div>
                </div>
                <hr>
                <?php }
                        ?>

                <!-- End Comments -->
            </div>
        </div>
    </div>
</section>
<?php
    } else { // Bad, This Item Not Exist In Data
        header('location: index.php');
        exit();
    }
    include_once $tml . 'footer.inc.php';
} else { // There Is No Department Id Sent
    header('location: index.php');
    exit();
}
// End Buffer
ob_end_flush();
