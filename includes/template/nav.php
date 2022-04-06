<?php

use function eCommerce\shop\includes\functions\checkElement;
use function eCommerce\shop\includes\functions\getDepartment;

$department = getDepartment('*', 'departments', 'visibiltiy', '1', 'custom_ordering');
if (isset($_SESSION['normal-id'])) {
  global $numberSave;
  $countSave = $GLOBALS['conn']->prepare("SELECT COUNT(item_id) FROM items_bay WHERE `user_id` = ? && `item-bay_see` = ?");
  $countSave->execute(array($_SESSION['normal-id'], 0));
  $numberSave =  $countSave->fetchColumn();
}
?>

<section class="bar-upper">
  <div class="container">
    <?php
    if (isset($_SESSION['normal-user']) && !empty($_SESSION['normal-user'])) {
      ?>
      <div class="row">
        <div class="col-md-9 col-sm-12">
          <!-- Start Search -->
          <form class="search" method="POST" action="index.php">
            <div class="form-group row">
              <div class="col-sm-12 col-sm-6">
                <div class="control-icons">
                  <div class="search-icon"><i class="fas fa-search"></i></div>
                  <input type="search" class="form-control " placeholder="Search & Press Enter" name='search' required title="Enter Item Name">
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- End Search -->
        <div class="col-md-3 col-sm-12">
          <section class="box-info">
            <div class="shop">
              <a href="show-love.php">
                <div class="shop-icon"><i class="fas fa-cart-arrow-down fa-fw"></i></div>
                <?php if ($numberSave != 0) echo "<span class = 'view'> " . $numberSave .  " </span>" ?>
              </a>
            </div>
            <div class="btn-group box-info" style="position: relative">
              <button type="button" class="btn  btn-sm dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                <?php echo ($_SESSION['normal-user']); ?>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                <a class="dropdown-item" href="profile.php">Profile</a>
                <a class="dropdown-item" href="profile.php#item-show">Items</a>
                <a class="dropdown-item" href="mange-item.php">Add Items</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Log Out</a>
              </div>
            </div>
            <img src="<?php if ($_SESSION['normal_user_image']) echo 'data/uploads/image-users/' . $_SESSION['normal_user_image'];
                        else echo 'layout/images/robot02_90810.png' ?>" alt="User Imag" class="img-thumbnail">
          <?php
          } else {
            echo "<a href='login-page.php'> Login</a>";
            echo ' | ';
            echo "<a href='login-page.php'>signup</a>";
          }
          ?>
          </section>
        </div>
      </div>
  </div>
</section>

<div class="clear-both"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">HomePage</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <?php
        foreach ($department as $departments) {
          echo '<li class = "nav-item">';
          echo '<a class = "nav-link" href = "departments.php?departmentId=' . $departments['department_id'] .  '&departmentName=' . str_replace(' ', '-', $departments['name']) . '">' . $departments['name'] . '</a>';
          echo '</li>';
        }
        ?>
      </ul>
    </div>
  </div>
</nav>