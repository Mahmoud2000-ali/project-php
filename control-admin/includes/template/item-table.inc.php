<?php

use function eCommerce\admin\includes\functions\printItems;
use function eCommerce\admin\includes\functions\gdfATo;
use function eCommerce\admin\includes\functions\printCustomItems;
/*
    
  ===== If The public admin == 0, Then Show All Data
  ===== If The public admin != 0, Then Show Just Item That Belong This Person
$_COOKIE['cookie-id']
 */

// Get The Function, To Get The Items From Items User
$array = printItems();
// Check If The User Want To Show The Items All OR NOT
if(isset($_GET['own']) && $_GET['own'] == 'yes'){
    $array = printCustomItems($_COOKIE['cookie-id']);
}else{
    $array = printItems();
}
?>
<div class="container-fluid">
    <h2 class="text-center member" style=" font-weight: 800;color: #565656;padding-top:30px; font-family: 'Roboto', sans-serif;padding-bottom: 30px;">
        Mange Items</h2>
    <table class="table table-bordered text-center item" style="box-shadow: 0 3px 10px #a0a0a0;">
        <thead class="thead-dark">
            <tr class="text-center">

                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Reg.Date</th>
                <th scope="col">Price</th>
                <th scope="col">Amount</th>
                <th scope="col">Country</th>
                <th scope="col">Status</th>
                <th scope="col">Department</th>
                <th scope="col">User</th>
                <th scope="col">Mange</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($array as $row){
                $department = gdfATo('name', 'departments', 'department_id', $row['department_id']);
                echo '<tr class = "custom-button">';
                    echo '<td>' . $row['item_name'] . '</td>';
                    if($row['item_image']){
                      echo '<td><img src = "../data/uploads/image-item/'. $row['item_image'] .'" class = "img-fluid" alter = "Item Image"> </td>';
                    }else{
                      echo '<td><img src = "../layout/images/defult.png" class = "img-fluid" alter = "Item Image"> </td>';
                    }
                    echo '<td>' . $row['item_date'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    echo '<td>' . $row['amount'] . '</td>';
                    echo '<td>' . $row['country'] . '</td>';
                    echo '<td>' . $row['item_status'] . '</td>';
                    echo '<td>' .  $department[0] . '</td>';
                    echo '<td>' . $row['full_name'] . '</td>';
                    if($_COOKIE['public_admin'] == 1){ // The Public Admin Can Mange All Items
                        echo '<td class = "not-vertical">';
                            echo '<a href = "?namePage=edit&id=' . $row['iteam_id'] . " " . ' " class="btn btn-primary btn-sm btn-block" style = "color:#fff"><i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit                
                            echo ' <a data-toggle="modal" data-target="#' .  $row['username'] . "  " . '"class="btn btn-danger btn-sm btn-block" style="color:#fff; margin-bottom: 5px"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
                            // Show Message To Confirm Delete Admin
                            echo '
                                    <div class="modal fade" id="' .  $row['username'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Items</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            Are You Source To Remove ' . $row['item_name'] . ' ? <br> That Will Delete The Items From Data
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                            <a href = "?namePage=delete&id=' . $row['iteam_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>';
                            if($row['item_approve'] == 0){ // Not Approve
                                echo '<a href = "?namePage=approve&id=' . $row['iteam_id'] . " " . ' " class="btn btn-dark btn-sm btn-block" style = "color:#fff"><i class="fas fa-spinner fa-fw"></i> Approved</a>'; // Not approve                
                            }else{ // This Icon Is Approve
                                echo '<a href = "?namePage=approve&removeApprove=yes&id=' . $row['iteam_id'] . " " . ' " class="btn btn-success btn-sm btn-block" style = "color:#fff"><i class="far fa-check-square fa-fw"></i> Approve</a>'; // approve                
                            }
                    }else{ // The Person Can Mange His Items
                        if($_COOKIE['cookie-admin'] == $row['username'] || $row['group_id'] == 2 || $row['group_id'] == 0){ // Just The admin Can Mange His Items
                            echo '<td>';
                            echo '<a href = "?namePage=edit&id=' . $row['iteam_id'] . " " . ' " class="btn btn-primary btn-sm" style = "color:#fff"><i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit                
                            echo ' <a data-toggle="modal" data-target="#' .  $row['username'] . "  " . '"class="btn btn-danger btn-sm" style="color:#fff; margin-bottom: 5px"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
                            // Show Message To Confirm Delete Admin
                            echo '
                                    <div class="modal fade" id="' .  $row['username'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Items</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            Are You Source To Remove ' . $row['item_name'] . ' ? <br> That Will Delete The Items From Data
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                            <a href = "?namePage=delete&id=' . $row['iteam_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>';
                            if($row['item_approve'] == 0){ // Not Approve
                                echo '<a href = "?namePage=approve&id=' . $row['iteam_id'] . " " . ' " class="btn btn-dark btn-sm" style = "color:#fff"><i class="fas fa-spinner fa-fw"></i> Approved</a>'; // Not approve                
                            }else{ // This Icon Is Approve
                                echo '<a href = "?namePage=approve&removeApprove=yes&id=' . $row['iteam_id'] . " " . ' " class="btn btn-success btn-sm" style = "color:#fff"><i class="far fa-check-square fa-fw"></i> Approve</a>'; // approve                
                            }
                            echo '</td>';
                        }else{ // Hide The Button From Another Person
                            echo '<td>';
                            echo '<a href = "?namePage=edit&id=' . $row['iteam_id'] . " " . ' " class="btn btn-primary disabled btn-sm" style = "color:#fff"><i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit                
                            echo ' <a data-toggle="modal" data-target="#' .  $row['username'] . "  " . '"class="btn btn-danger btn-sm disabled" style="color:#fff; margin-bottom: 5px"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
                            // Show Message To Confirm Delete Admin
                            echo '
                                    <div class="modal fade" id="' .  $row['username'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Items</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            Are You Source To Remove ' . $row['item_name'] . ' ? <br> That Will Delete The Items From Data
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                            <a href = "?namePage=delete&id=' . $row['iteam_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>';
                            if($row['item_approve'] == 0){ // Not Approve
                                echo '<a href = "?namePage=approve&id=' . $row['iteam_id'] . " " . ' " class="btn btn-dark btn-sm disabled" style = "color:#fff"><i class="fas fa-spinner fa-fw"></i>Approved</a>'; // Not approve                
                            }else{ // This Icon Is Approve
                                echo '<a href = "?namePage=approve&id=' . $row['iteam_id'] . " " . ' " class="btn btn-success btn-sm disabled" style = "color:#fff"><i class="far fa-check-square fa-fw"></i>Approve</a>'; // approve                
                            }
                            echo '</td>';
                        }
                    }
                echo '</tr>';
            }

            ?>
        </tbody>
    </table>
    <!-- Show buttons -->
    <div style="margin-top:30px; margin-bottom:30px">
        <a href="?namePage=add" class="btn btn-primary btn-lg" role="button" aria-disabled="true"><i class="far fa-paper-plane fa-fw"></i> Add New Items</a>
        <?php 
            // Check To Toggle The Button
            if(isset($_GET['own']) && $_GET['own'] == 'yes'){
                echo '<a href="?namePage=mange" class="btn btn-info btn-lg" style = "margin-bottom: 5px" role="button" aria-disabled="true"><i class="fas fa-eye fa-fw"></i> See All Items</a>';     
            }else{ // Show Button To See Own Items
                echo '<a href="?namePage=mange&own=yes" class="btn btn-info btn-lg" style = "margin-bottom: 5px" role="button" aria-disabled="true"><i class="fas fa-eye fa-fw"></i> Show Your Items</a>';     
            }
        ?>
    </div>
</div>