<?php

use function eCommerce\admin\includes\functions\getCount;
use function eCommerce\admin\includes\functions\getReg;
use function eCommerce\admin\includes\functions\getLastToPrint;

// Call Function To get Count Of Customer 
$countMember = getCount('user_id', 'users');

// Call Function To get Count Of Pending
$contPending = getReg('reg_state', 'users');

// Call Function To get Count Of The Items
$countItems = getCount('item_name', 'items');

// Call Function To Get Information About Users And Print It In Last Register Panel
$row = getLastToPrint('*', 'users', 'date', 'DESC');

// Call Function To Get The Information About Items And Print It In Last Register Panel
$items = getLastToPrint('*', 'items', 'item_date', 'DESC', 4);

// Call Function To Get The Count Of Comments
$commentCount = getCount('comment', 'comments');
?>

<!-- Dashboard Section -->
<section class='dashboard'>
    <div class='container'>
        <div class="icon-dash"><i class="fas fa-laptop"></i></div>
        <h2> Dashboard </h2>
        <!-- Start Breadcrumb -->
        <nav aria-label="breadcrumb brand">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dash.admin.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <!-- End Breadcrumb -->
        <!-- Start Sta -->
        <section class="stat">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="info text-center" style="margin-bottom:12px">
                        <h4><a href="customers.php">Total Members</a></h4>
                        <div class='icon-custom inline-blok'><a href="customers.php"><i class="fas fa-user-friends fa-fw"></i></a></div>
                        <p class="inline-blok"><?php echo $countMember ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12" style="margin-bottom:12px">
                    <div class="info text-center box-2">
                        <h4><a href="customers.php?namePage=mange&isPending=yes">Pending Member</a></h4>
                        <div class='icon-custom inline-blok'><a href="customers.php?namePage=mange&isPending=yes&isEmpty=<?php if ($contPending == 0) {
                                                                                                                                echo 'yes';
                                                                                                                            } else {
                                                                                                                                echo 'no';
                                                                                                                            } ?>">
                                <i class="far fa-address-card fa-fw"></i></a></div>
                        <p class="inline-blok"><?php echo $contPending; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12" style="margin-bottom:12px">
                    <div class="info text-center box-3">
                        <h4><a href="item.php?fromHome">Total Item</a></h4>
                        <div class='icon-custom inline-blok'><a href="item.php?fromHome"><i class="fas fa-sitemap fa-fw"></i></a></div>
                        <p class="inline-blok"><?php echo $countItems; ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="info text-center box-4">
                        <h4><a href="comment.php">Total comments</a></h4>
                        <div class='icon-custom inline-blok'><a href="comment.php"><i class="far fa-comments fa-fw"></i></a></div>
                        <p class="inline-blok"><?php echo $commentCount; ?></p>
                    </div>
                </div>
            </div>
            <!-- Start Crd-->
            <section class="cart">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card cart-custom">
                            <div class="card-header">
                                <h5>Last Register Customer</h5>
                            </div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                    <ul class="list-unstyled ul-cart">
                                        <?php
                                        foreach ($row as $info) {
                                            if ($info['public_admin'] != 1) { // Not Select Public Admin
                                                if ($info['group_id'] != 1) { //  Not Select Admin
                                                    echo '<li>';
                                                        echo $info['username'];
                                                        echo '<a href = "customers.php?namePage=edit&id=' . $info['user_id'] . '" style = "color:#fff; margin-left:6px" class="btn btn-primary btn-sm float-right"> <i class="far fa-edit fa-fw"></i> Edit </a>';
                                                        if ($info['reg_state'] == 1) { // This Person Is Activated 
                                                            echo  '<a href = "customers.php?namePage=insertAdmin&removeActivity=yes&dash=yes&id=' . $info['user_id'] . '" style = "color:#fff"class="btn btn-success btn-sm float-right"> <i class="far fa-check-square fa-fw"></i> Activated </a>';
                                                        } else { // This Person Not Activity
                                                            echo  '<a href = "customers.php?namePage=insertAdmin&activity=yes&dash=yes&id=' . $info['user_id'] . '" style = "color:#fff"class="btn btn-dark btn-sm float-right"> <i class="fas fa-spinner fa-fw"></i> Activity </a>';
                                                        }
                                                    echo '</li>';
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card cart-custom">
                            <div class="card-header">
                                <h5>Last Items</h5>
                            </div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                    <ul class="list-unstyled ul-cart">
                                        <?php
                                        foreach ($items as $info) {
                                                echo '<li>';
                                                echo $info["item_name"];
                                                echo '<a href = "item.php?namePage=edit&id=' . $info['iteam_id'] . '" style = "color:#fff; margin-left:6px" class="btn btn-primary btn-sm float-right"> <i class="far fa-edit fa-fw"></i> Edit </a>';
                                                echo ' <a data-toggle="modal" data-target="#' .  $info['iteam_id'] . "  " . '"class="btn btn-danger btn-sm float-right" style="color:#fff"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
                                                // Show Message To Confirm Delete Admin
                                                echo '
                                                    <div class="modal fade" id="' .  $info['iteam_id'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Items</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                            </button>
                                                          </div>
                                                          <div class="modal-body">
                                                            Are You Source To Remove ' . $info['item_name'] . ' ? <br> That Will Delete The Items From Data
                                                          </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                            <a href = "item.php?namePage=delete&id=' . $info['iteam_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>';

                                                echo '</li>';
                                            }
                                        ?>
                                    </ul>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End -->
            </section>
            <!-- End Sta -->
        </section>
    </div>
</section>