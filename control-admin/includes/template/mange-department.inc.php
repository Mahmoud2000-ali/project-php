<?php

use function eCommerce\admin\includes\functions\getDepartment;
// Select Tha All Department 
$department = getDepartment('*','departments', $GLOBALS['sort']);
?>

<div class="container">
    <h2 class="text-center member" style=" font-weight: 800;color: #565656;padding-top:30px; font-family: 'Roboto', sans-serif;padding-bottom: 30px;">
        Mange Department</h2>
    <div class="links float-right" style="margin-bottom:5px">
        <a class="<?php if ($_GET['link'] == 'ASC') {
                        echo 'active';
                    } ?>" href="?namePage=mange&link=ASC">ASC </a> |
        <a class="<?php if ($_GET['link'] == 'DESC') {
                        echo 'active';
                    } ?>" href="?namePage=mange&link=DESC">DESC</a>
    </div>
    <table class="table table-bordered text-center" style="box-shadow: 0 3px 10px #a0a0a0;">
        <thead class="thead-dark">
            <tr class="text-center">
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Allow Comment</th>
                <th scope="col">Allow Ads</th>
                <th scope="col">Visibility</th>
                <th scope="col">Reg.date</th>
                <th scope="col">Mange</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($department as $dep) {
                echo '<tr>';

                echo '<td>' . $dep['name'] . '</td>';

                echo '<td>' . $dep['description'] . '</td>';

                echo '<td>';
                if ($dep['allow_comment'] == 0)
                    echo 'NO';
                else
                    echo 'YES';

                echo '</td>';

                echo '<td>';
                if ($dep['allow_ads'] == 0)
                    echo 'NO';
                else
                    echo 'YES';
                echo '</td>';

                echo '<td>';
                if ($dep['visibiltiy'] == 0)
                    echo 'NO';
                else
                    echo 'YES';
                echo '</td>';

                echo '<td>' . $dep['date'] . '</td>';

                echo '<td>';
                echo '<a href = "?namePage=edit&id=' . $dep['department_id']. ' "class="btn btn-primary btn-sm margin-btn" style = "color:#fff; margin-right:5px"><i class="far fa-edit fa-fw"></i>EDIT</a>';
                echo '<a data-toggle="modal" data-target="#' .  $dep['department_id'] . "  " . '"class="btn btn-danger btn-sm" style="color:#fff"><i class="far fa-trash-alt fa-fw"></i>Delete</a>'; // Delete;
                echo '
                      <div class="modal fade" id="' .  $dep['department_id'] . "  " . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Delete Department</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              Are You Sour To Remove ' . $dep['name'] . ' ?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                              <a href = "?namePage=delete&id=' . $dep['department_id'] . '" class="btn btn-primary btn-sm" style = "color:#fff">Save Change</a>
                            </div>
                          </div>
                        </div>
                      </div>';
                echo '</td>';

                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <!-- Show buttons -->
    <a href="?namePage=add" class="btn btn-primary btn-lg" role="button" aria-disabled="true"><i class="far fa-paper-plane fa-fw"></i> Add New Department</a>

</div>