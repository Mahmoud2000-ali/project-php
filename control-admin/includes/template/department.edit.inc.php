<?php

use function eCommerce\admin\includes\functions\gdfATo;
// Call Function To Get The Department
$row = gdfATo('*', 'departments', 'department_id', $GLOBALS['department_id']);
?>
<?php foreach ($row as $inf) { } ?>
<div class='container custom-form'>
    <form method='POST' action='department.php?namePage=update&id=<?php echo $GLOBALS['department_id']; ?>'>
        <h2 class='h1 text-center'> Update Department </h2>

        <div class="form-group row">
            <label for="inputUsername" class="col-sm-2 col-form-label">Department</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-pen-alt fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="Department Name" name='name' required title="Enter Department Name" value=<?php echo $row['name']; ?> />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-audio-description fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="description" name='des' required title="Enter Description" value=<?php echo $row['description']; ?> />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Ordering</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1 custom-icon'> <i class="fas fa-sort-numeric-up fa-fw"></i></div>
                    <select class="custom-select" style="height: calc(2.25rem + 12px); padding-left: 70px" name="order">
                        <?php
                        echo '<option selected>';
                        echo $row['custom_ordering'];
                        echo '</option>';
                        for ($i = 1; $i <= 150; $i++) {
                            echo '<option value = ' . $i . '>' . $i  . '</option>';
                        }
                        ?>
                    </select>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Select The Ordering Of This Department
                    </small>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" style="margin-right:30px">Allow Visibility</label>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="visibility" name="visibility" class="custom-control-input" value="1" <?php if ($row['visibiltiy'] == 1) echo 'checked'; ?> />
                <label class="custom-control-label badge badge-info text-center" for="visibility">Make This Department Visibility &numsp; &numsp;</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="customRadioInline2" name="visibility" class="custom-control-input" value="0" <?php if ($row['visibiltiy'] == 0) echo 'checked'; ?> />
                <label class="custom-control-label badge badge-danger" for="customRadioInline2">Make This Department Not Visibility</label>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" style="margin-right:30px">Allow Comment</label>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="comments1" name="comment" class="custom-control-input" value="1" <?php if ($row['allow_comment'] == 1) echo 'checked'; ?>>
                <label class="custom-control-label badge badge-info" for="comments1">Make This Department Comments &numsp;</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="comments" name="comment" class="custom-control-input" value="0" <?php if ($row['allow_comment'] == 0) echo 'checked'; ?>>
                <label class="custom-control-label badge badge-danger" for="comments">Make This Department Not Allowed Comment</label>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" style="margin-right:30px">Allow Ads</label>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="ads1" name="ads" class="custom-control-input" value="1" <?php if ($row['allow_ads'] == 1) echo 'checked'; ?>>
                <label class="custom-control-label badge badge-info" for="ads1">Make This Department Allowed Ads</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="ads" name="ads" class="custom-control-input" value="0" <?php if ($row['allow_ads'] == 0) echo 'checked'; ?>>
                <label class="custom-control-label badge badge-danger" for="ads">Make This Department Not Allowed Ads</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-bottom:10px" value='Insert'><i class="far fa-check-square"></i> Add Department </button>
    </form>
</div>