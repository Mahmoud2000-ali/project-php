<?php
// Select All Data But Not group_id = 1
use function eCommerce\admin\includes\functions\printInTable;

// Select All Data That group_id = 1
if ($GLOBALS['pending'] == 'false') {
  $row = printInTable('*','users', 'NOT', 1);
}
?>
<div class="container">
  <h2 class="text-center member" style=" font-weight: 800;color: #565656;padding-top:30px; font-family: 'Roboto', sans-serif;padding-bottom: 30px;">
    Mange Customer</h2>
  <table class="table table-bordered table-responsive text-center" style="box-shadow: 0 3px 10px #a0a0a0;">
    <thead class="thead-dark">
      <tr class="text-center">
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
        echo '<a href = "?namePage=edit&id=' . $info['user_id'] . " " . ' " class="btn btn-primary btn-sm btn-block" style = "color:#fff"><i class="far fa-edit fa-fw"></i>Edit</a>'; // Edit                
        echo ' <a data-toggle="modal" data-target="#' .  $info['username'] . "  " . '"class="btn btn-danger btn-sm btn-block" style="color:#fff"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete
        // Show Message To Confirm Delete Admin
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
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <a href = "?namePage=delete&isCus=customer&id=' . $info['user_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                      </div>
                    </div>
                  </div>
                </div>';

        if (isset($_SESSION['public_admin']) && $_SESSION['public_admin'] == 1) { // Can Add Admin
          echo '<a  data-toggle="modal" data-target="#' .  $info['user_id'] . "  " . '"class="btn btn-info btn-sm btn-block" style="color:#fff; margin: 5px 0"><i class="far fa-plus-square fa-fw"></i>Add Member</a>';
          // Show Message To Confirm The Add Admin 
          echo '
                    <div class="modal fade" id="' .  $info['user_id'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Insert Admin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are You Source To Make ' . $info['full_name'] . ' Admin ? <br> That Will Alow This Customer To Log As Admin And Modify The Mange Customer
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <a href = "?namePage=insertAdmin&isCus=customer&id=' . $info['user_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                          </div>
                        </div>
                      </div>
                    </div>';
        } else { // Cant Insert Admin
          echo '<a href = "?namePage=insertAdmin&id=' . $info['user_id'] . '" class="btn btn-primary btn-sm disabled btn-block" style = "color:#fff; margin: 5px 0"><i class="far fa-plus-square fa-fw"></i> Add Member </a>';
        }
        // Check If Its Not Reg State
        if ($info['reg_state'] == 0) {
          echo '<a data-toggle="modal" data-target="#' .  $info['email'] . "  " . '"class="btn btn-dark btn-sm act btn-block" style="color:#fff; margin: 0"><i class="fas fa-spinner fa-fw"></i> Activity </a>';
          // Show Message To Confirm The Add Admin 
          echo '
                    <div class="modal fade" id="' .  $info['email'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Activity Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are You Source To Make ' . $info['full_name'] . ' Active ? <br> That Will Alow This Customer To Log In App
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <a href = "?namePage=insertAdmin&activity=yes&id=' . $info['user_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                          </div>
                        </div>
                      </div>
                    </div>';           
        }else{
          echo '<a data-toggle="modal" data-target="#' .  $info['email'] . "  " . '"class="btn btn-success btn-sm act btn-block" style="color:#fff; margin: 0"><i class="far fa-check-square fa-fw"></i>Activated</a>';
          // Show Message To Confirm The Add Admin 
          echo '
                    <div class="modal fade" id="' .  $info['email'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Remove Activated Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Are You Source To Make ' . $info['full_name'] . ' Un Active ? <br> That Will Not Alow This Customer To Log In App
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <a href = "?namePage=insertAdmin&removeActivity=yes&id=' . $info['user_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                          </div>
                        </div>
                      </div>
                    </div>';                
        }
        echo '</td>';
      }
      ?>
    </tbody>
  </table>
  <!-- Show buttons -->
  <div style="margin-top:30px; margin-bottom:30px">
    <a href="?namePage=add" class="btn btn-primary btn-lg"  style="margin-bottom:7px" role="button" aria-disabled="true"><i class="far fa-paper-plane fa-fw"></i> Insert New Customer</a>
    <a href="?namePage=showAdmin" class="btn btn-success btn-lg" style="margin-bottom:5px" role="button" aria-disabled="true"><i class="far fa-eye fa-fw"></i> Show Members</a>
  </div>
</div>