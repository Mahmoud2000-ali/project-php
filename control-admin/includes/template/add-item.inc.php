<?php

use function eCommerce\admin\includes\functions\getDepartment;

/*
    ========================================================
    ========== Call The Department To Put In Select Box 
    == The Value Of Option Will Be The Id Of Department
    ========================================================
 */
// Call Method
$department = getDepartment('name, department_id, allow_ads', 'departments');
// Check If There Is No Department To Add Items
$noDepartment = array();
$result = '';
foreach ($department as $ads) {
    $noDepartment[] = $ads['allow_ads'];
}
if (in_array(1, $noDepartment)) { // Good There Is Department Allow To Insert
    $result = 'true';
} else { // No Department
    $result = 'false';
}
?>

<?php
if ($result == 'true') {
    ?>

<div class='container custom-form custom-item'>
    <form method='POST' action='?namePage=insert' enctype="multipart/form-data">
        <h2 class='h1 text-center'> Add New Item </h2>

        <div class="form-group row">
            <label for="inputUsername" class="col-sm-2 col-form-label">Item</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-voicemail fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="Item Name" name='name' required title="Enter Item Name" />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-money-check-alt fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="Price" name='price' required title="Enter Price">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Country</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-globe-europe fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="Country" name='country' required title="Enter Country">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1 custom-icon'> <i class="fas fa-star-half-alt fa-fw"></i></div>
                    <select class="custom-select" style="height: calc(2.25rem + 12px); padding-left: 70px" name="status">
                        <option value='New'> New </option>
                        <option value='Like New'> Like New </option>
                        <option value='Good'> Good </option>
                        <option value='Old'> Old </option>
                    </select>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Select The Status Of This Items
                    </small>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Department</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1 custom-icon'> <i class="fas fa-pen-alt fa-fw"></i></div>
                    <select class="custom-select" style="height: calc(2.25rem + 12px); padding-left: 70px" name="department">
                        <?php
                            foreach ($department as $row) {
                                if ($row['allow_ads'] == 1) {
                                    echo '<option value = ' . $row['department_id'] . '>' . $row['name'] . '</option>';
                                }
                            }
                            ?>
                    </select>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Select The Name Of Department For This Items
                    </small>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Amount</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-list-ol fa-fw"></i></div>
                    <input type="number" class="form-control form-control-lg" name='amount' required title="Enter Amount Of Item" max='1000' min='1'>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tage</label>
            <div class="col-sm-10">
                <input type="text" class="form-control control-tage" id="tags" name='tags' />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputFullName" class="col-sm-2 col-form-label">Choice Image</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <input type="file" class="custom-file-input" id="validatedCustomFile" name= "image"/>
                    <label class="custom-file-label form-control" for="validatedCustomFile">Choose Image...</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-lg" placeholder="description" name='des' required title="Enter Description" style="height: 150px; font-size:17px"></textarea>
            </div>
        </div>

        <button type="submit" style="margin-bottom:80px" class="btn btn-primary btn-lg btn-block"><i class="far fa-check-square"></i> Add Item </button>
    </form>
</div>

<?php } else {
    echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                        There Is No Department To Insert Items
                        </p>";
} ?>