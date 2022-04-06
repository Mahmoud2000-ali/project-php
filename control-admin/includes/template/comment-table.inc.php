<?php
// Function To Get The Comment
use function eCommerce\admin\includes\functions\getComment;

$row = getComment();
?>
<div class= "container">
    <h2 class="text-center member" style=" font-weight: 800;color: #565656;padding-top:30px; font-family: 'Roboto', sans-serif;padding-bottom: 30px;">
        Mange comments</h2>
    <table class="table table-bordered text-center table-responsive comment-table" style="box-shadow: 0 3px 10px #a0a0a0;">
        <thead class="thead-dark">
            <tr class="text-center">
                <th scope="col">#ID</th>
                <th scope="col">Comment</th>
                <th scope="col">Date</th>
                <th scope="col">Items</th>
                <th scope="col">User Name</th>
                <th scope="col">Mange</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($row as $comments) {
                if ($_COOKIE['public_admin'] == 1) { // If The Public Admin Do Code ,,,,
                    echo '<tr class="custom-button"> ';
                    echo '<td> <span class = "control-span">' . $comments['comment_id'] . '</span> </td>';
                    echo '<td> <p> '. $comments['comment'] .'</p> </td>';
                    echo '<td> <span class = "control-span">'. $comments['comment_date'] . '</span> </td>';
                    echo '<td> <span class = "control-span">' . $comments['name_item'] . '</span> </td>';
                    echo '<td> <span class = "control-span">' . $comments['full_name'] . '</span> </td>';
                    echo '<td>';
                    echo '<a href = "?namePage=edit&id=' . $comments['comment_id'] . " " . ' " class="btn btn-primary btn-sm my-button" style = "color:#fff; margin-right: 5px"><i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit                
                    echo '<a data-toggle="modal" data-target="#' .  $comments['comment_id'] . "  " . '"class="btn btn-danger btn-sm my-button" style="color:#fff"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
                    // Show Message To Confirm Delete Admin
                    echo '
                                <div class="modal fade" id="' .  $comments['comment_id'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Comments</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        Are You Source To Remove This Comment ? 
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href = "?namePage=delete&id=' . $comments['comment_id'] . '" class="btn btn-primary" style = "color:#fff">Save Change</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>';
                    if ($comments['comment_status'] == 0) { // This Comment Not Approve
                        echo '<a href = "?namePage=approve&id=' . $comments['comment_id'] . " " . ' " class="btn btn-dark btn-sm my-button" style = "color:#fff"><i class="fas fa-spinner fa-fw"></i> Approved </a>';
                    } else { // This Icon Is Approve
                        echo '<a href = "?namePage=approve&removeApprove=yes&id=' . $comments['comment_id'] . " " . ' " class="btn btn-success btn-sm my-button" style = "color:#fff"><i class="far fa-check-square fa-fw"></i> Approve</a>';
                    }
                    echo '</td>';
                    echo '</tr>';
                } else { // The Admin Control Just His Comment And The Users Comment
                    if ($comments['public_admin'] != 1) {
                        echo '<tr class="custom-button"> ';
                        echo '<td>' . $comments['comment_id'] . '</td>';
                        echo '<td>' . $comments['comment'] . '</td>';
                        echo '<td>' . $comments['comment_date'] . '</td>';
                        echo '<td>' . $comments['name_item'] . '</td>';
                        echo '<td>' . $comments['full_name'] . '</td>';
                        echo '<td>';
                        echo '<a href = "?namePage=edit&id=' . $comments['comment_id'] . " " . ' " class="btn btn-primary btn-sm my-button" style = "color:#fff; margin-right: 5px"><i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit                
                        echo '<a data-toggle="modal" data-target="#' .  $comments['comment_id'] . "  " . '"class="btn btn-danger btn-sm my-button" style="color:#fff"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
                        // Show Message To Confirm Delete Admin
                        echo '
                                <div class="modal fade" id="' .  $comments['comment_id'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Comments</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        Are You Source To Remove This Comment ? 
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href = "?namePage=delete&id=' . $comments['comment_id'] . '" class="btn btn-primary" style = "color:#fff">Save Change</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>';
                        if ($comments['comment_status'] == 0) { // This Comment Not Approve
                            echo '<a href = "?namePage=approve&id=' . $comments['comment_id'] . " " . ' " class="btn btn-dark btn-sm my-button" style = "color:#fff"><i class="fas fa-spinner fa-fw"></i> Approved </a>';
                        } else { // This Icon Is Approve
                            echo '<a href = "?namePage=approve&removeApprove=yes&id=' . $comments['comment_id'] . " " . ' " class="btn btn-success btn-sm my-button" style = "color:#fff"><i class="far fa-check-square fa-fw"></i> Approve</a>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    } else { // Hide The Buttons
                        echo '<tr class="custom-button"> ';
                        echo '<td>' . $comments['comment_id'] . '</td>';
                        echo '<td>' . $comments['comment'] . '</td>';
                        echo '<td>' . $comments['comment_date'] . '</td>';
                        echo '<td>' . $comments['name_item'] . '</td>';
                        echo '<td>' . $comments['username'] . '</td>';
                        echo '<td>';
                        echo '<a href = "?namePage=edit&id=' . $comments['comment_id'] . " " . ' " class="btn btn-primary btn-sm disabled" style = "color:#fff; margin-right: 5px"><i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit                
                        echo '<a data-toggle="modal" data-target="#' .  $comments['comment_id'] . "  " . '"class="btn btn-danger btn-sm disabled" style="color:#fff"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
                        // Show Message To Confirm Delete Admin
                        echo '
                                <div class="modal fade" id="' .  $comments['comment_id'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Comments</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        Are You Source To Remove This Comment ? 
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href = "?namePage=delete&id=' . $comments['comment_id'] . '" class="btn btn-primary" style = "color:#fff">Save Change</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>';;
                        if ($comments['comment_status'] == 0) { // This Comment Not Approve
                            echo '<a href = "?namePage=approve&id=' . $comments['comment_id'] . " " . ' " class="btn btn-dark btn-sm disabled" style = "color:#fff"><i class="fas fa-spinner fa-fw"></i> Approved </a>';
                        } else { // This Icon Is Approve
                            echo '<a href = "?namePage=approve&removeApprove=yes&id=' . $comments['comment_id'] . " " . ' " class="btn btn-success btn-sm disabled" style = "color:#fff"><i class="far fa-check-square fa-fw"></i> Approve</a>';
                        }
                        echo '</td>';                        
                        echo '</tr>';
                    }
                }
            }
            ?>
        </tbody>
    </table>
    <!-- Show buttons -->