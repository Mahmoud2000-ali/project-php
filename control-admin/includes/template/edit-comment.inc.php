<?php

/*
    ========================================================
    ==========  Edit Comment
    ========================================================
 */

use function eCommerce\admin\includes\functions\gdfATo;

$comment = gdfATo('comment', 'comments', 'comment_id', $_GET['id']);

?>
<div class='container custom-form custom-item'>
    <form method='POST' action='?namePage=update&id=<?php echo $_GET['id']; ?>'>
        <h2 class='h1 text-center'> Edit Comment </h2>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Comment</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-lg" name='comment' required title="Edit Comment" style="height: 150px; font-size:17px"> <?php echo $comment['comment']; ?> </textarea>
            </div>
        </div>

        <button type="submit" style="margin-bottom:80px" class="btn btn-primary btn-lg btn-block"><i class="far fa-check-square"></i> Edit Comment </button>
    </form>
</div>