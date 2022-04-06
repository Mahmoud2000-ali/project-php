<?php

use function eCommerce\admin\includes\functions\gdfATo;
use function eCommerce\admin\includes\functions\getDepartment;

/*
    ========================================================
    ==========  Edit Items
    ========================================================
 */

// Call Method To Get The Items
$items = gdfATo('*', 'items', 'iteam_id', $_GET['id']);
$department = getDepartment('name, department_id, allow_ads', 'departments');
?>
<div class='container custom-form custom-item'>
    <form method='POST' action='?namePage=update&id=<?php echo $_GET['id']; ?>' enctype="multipart/form-data">
        <h2 class='h1 text-center'> Edit Items </h2>

        <div class="form-group row">
            <label for="inputUsername" class="col-sm-2 col-form-label">Item</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-voicemail fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="Item Name" value='<?php echo $items['item_name']; ?>' name='name' required title="Enter Item Name" />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-money-check-alt fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="Price" value='<?php echo $items['price']; ?>' name='price' required title="Enter Price">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Country</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-globe-europe fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="Country" value='<?php echo $items['country']; ?>' name='country' required title="Enter Country">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1 custom-icon'> <i class="fas fa-star-half-alt fa-fw"></i></div>
                    <select class="custom-select" style="height: calc(2.25rem + 12px); padding-left: 70px" name="status">
                        <option <?php if ($items['item_status'] == 'New') echo 'selected'; ?> Value='New'> New </option>
                        <option <?php if ($items['item_status'] == 'Like New') echo 'selected'; ?> Value='Like New'> Like New </option>
                        <option <?php if ($items['item_status'] == 'Good') echo 'selected'; ?> Value='Good'> Good </option>
                        <option <?php if ($items['item_status'] == 'Old') echo 'selected'; ?> Value='Old'> Old </option>

                    </select>
                    <small class="form-text text-muted">
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
                                echo '<option value = ' .$row['department_id'] . '>' . $row['name'] . '</option>';
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
                    <input type="number" class="form-control form-control-lg" name='amount' value='<?php echo $items['amount']; ?>' required title="Enter Amount Of Item" max='1000' min='1'>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tag</label>
            <div class="col-sm-10">
            <input type="text" class="form-control control-tage" id = "tags"  value="<?php echo $items['item_tags']?>" name='tags'/>
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
                <textarea class="form-control form-control-lg" placeholder="description" name='des' required title="Enter Description" style="height: 150px; font-size:17px"> <?php echo $items['item_description']; ?> </textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <div class='input-con'>
                    <input type="text" class="form-control form-control-lg"  value='<?php echo $items['user_name']; ?>' name='username' hidden>
                </div>
            </div>
        </div>

        <button type="submit" style="margin-bottom:80px" class="btn btn-primary btn-lg btn-block"><i class="far fa-check-square"></i> Add Item </button>
    </form>
</div>