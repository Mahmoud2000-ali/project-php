<div class='container custom-form'>
    <form method='POST' action='department.php?namePage=insert'>
        <h2 class='h1 text-center'> Add New Department </h2>

        <div class="form-group row">
            <label for="inputUsername" class="col-sm-2 col-form-label">Department</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-pen-alt fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="Department Name" name='name' required title="Enter Department Name" />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-audio-description fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" placeholder="description" name='des' required title="Enter Description">
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
            <label class="col-sm-2 col-form-label" style="margin-right:30px" >Allow Visibility</label>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="visibility" name="visibility" class="custom-control-input"  value = "1" checked>
                <label class="custom-control-label badge badge-info text-center" for="visibility">Make This Department Visibility  &numsp;  &numsp;</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="customRadioInline2" name="visibility" class="custom-control-input" value = "0">
                <label class="custom-control-label badge badge-danger text-center" for="customRadioInline2">Make This Department Not Visibility </label>
            </div>
        </div>

        <div class="form-group row">
        <label class="col-sm-2 col-form-label" style="margin-right:30px">Allow Comment</label>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="comments1" name="comment" class="custom-control-input" value = "1" checked>
                <label class="custom-control-label badge badge-info text-center" for="comments1">Make This Department Comments  &numsp;</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="comments" name="comment" class="custom-control-input" value = "0">
                <label class="custom-control-label badge badge-danger text-center" for="comments">Make This Department Not Allowed Comment</label>
            </div>
        </div>

        <div class="form-group row">
        <label class="col-sm-2 col-form-label" style="margin-right:30px">Allow Ads</label>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="ads1" name="ads" class="custom-control-input" value = "1">
                <label class="custom-control-label badge badge-info text-center" for="ads1">Make This Department Allowed Ads</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline custom-label" style="margin-top:10px">
                <input type="radio" id="ads" name="ads" class="custom-control-input" value = "0" checked>
                <label class="custom-control-label badge badge-danger text-center" for="ads">Make This Department Not Allowed Ads</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-bottom:17px" value='Insert'><i class="far fa-check-square"></i> Add Department </button>
    </form>
</div>