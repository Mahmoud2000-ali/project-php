<?php

use function eCommerce\admin\includes\functions\printInTable;

// Select All Data That group_id = 1
$row = printInTable('*','users', '', 1);

?>
<div class="container">
  <h2 class="text-center member" style=" font-weight: 800;color: #565656;padding-top:30px; font-family: 'Roboto', sans-serif;padding-bottom: 30px;">
    Mange Members</h2>
  <table class="table table-bordered table-responsive text-center" style="box-shadow: 0 3px 10px #a0a0a0;">
    <thead class="thead-dark">
      <tr>
        <th scope="col"> <span class="table-h">User Name</span> </th>
        <th scope="col"> <span class="table-h">Images</span> </th>
        <th scope="col"> <span class="table-h">Password</span> </th>
        <th scope="col"> <span class="table-h">Email</span> </th>
        <th scope="col"> <span class="table-h">Full Name</span> </th>
        <th scope="col"> <span class="table-h">Reg.Date</span> </th>
        <th scope="col"> <span class="table-h">Mange</span> </th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($row as $info) {
        echo '<tr>';
        echo '<td>'. '<span class = "table-d">' . $info['username'] . ' </span>' .'</td>';
        if($info['user_image']){ // Good Theres Image For This Customer
          echo '<td class = "user-mage"> <img class = "img-fluid" src = "../data/uploads/image-users/'.$info['user_image'].'" alter = "User Image"> </img> </td>';
        }else{ // No Image For This Customer
          echo '<td class = "user-mage"> <img class = "img-fluid" src = "../layout/images/robot02_90810.png" alter = "User Image"> </img> </td>';
        }
        echo '<td>'. '<span class = "table-d">' . $info['password'] . ' </span>' .'</td>';
        echo '<td>'. '<span class = "table-d">' . $info['email'] . ' </span>' .'</td>';
        echo '<td>'. '<span class = "table-d">' . $info['full_name'] . ' </span>' .'</td>';
        echo '<td>'. '<span class = "table-d">' . $info['date'] . ' </span>' .'</td>';
        echo '<td>';
        // Show Message To Confirm Delete Admin                
        if (isset($_SESSION['public_admin']) && $_SESSION['public_admin'] == 1) { // Can Add Admin
          echo '<a href = "?namePage=edit&id=' . $info['user_id'] . " " . ' " class="btn btn-primary btn-sm btn-block" style = "color:#fff;margin-top: 20px"> <i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit  
          echo '<a data-toggle="modal" data-target="#' .  $info['username'] . "  " . '"class="btn btn-danger btn-sm btn-block" style="color:#fff"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete;
          echo '
                <div class="modal fade" id="' .  $info['username'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are You Source To Remove ' . $info['username'] . ' ? <br> That Will Alow This Customer Cant Shop Agin And Lost His Information
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href = "?namePage=delete&id=' . $info['user_id'] . '" class="btn btn-primary" style = "color:#fff">Save Change</a>
                      </div>
                    </div>
                  </div>
                </div>';
        } else { // Cant Insert Admin
          echo '<a data-toggle="modal" data-target="#' .  $info['username'] . "  " . '"class="btn btn-danger btn-sm btn-block disabled" style="color:#fff; margin-top: 20px"><i class="far fa-trash-alt fa-fw"></i>Delete</a>';
          echo '<a href = "?namePage=edit&id=' . $info['user_id'] . " " . ' " class="btn btn-primary btn-sm btn-block disabled" style = "color:#fff;margin-left: 9px"><i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit         
        }
        echo '</td>';
      }
      ?>
    </tbody>
  </table>
  <!-- Show buttons -->
  <div style="margin-top:30px; margin-bottom:30px">
    <a href="?namePage=add" class="btn btn-primary btn-lg" role="button" style="margin-bottom:7px" aria-disabled="true"><i class="far fa-paper-plane fa-fw"></i> Insert New Customer</a>
    <a href="?namePage=mange" class="btn btn-success btn-lg" role="button" style="margin-bottom:5px" aria-disabled="true"><i class="far fa-eye"></i> Show Customers</a>
  </div>
</div>