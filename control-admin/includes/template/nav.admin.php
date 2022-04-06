<?php 
$_SESSION['user'] = $_COOKIE['cookie-admin'];
$_SESSION['id'] = $_COOKIE['cookie-id'];
?>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">
      <?php echo eCommerce\admin\includes\language\lang('Db'); ?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto custom-nav">
        <li class="nav-item active">
          <a class="nav-link" href="dash.admin.php"><?php echo eCommerce\admin\includes\language\lang('Ho'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="department.php?link=ASC"><?php echo eCommerce\admin\includes\language\lang('De'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="customers.php"><?php echo eCommerce\admin\includes\language\lang('Me'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="item.php"><?php echo eCommerce\admin\includes\language\lang('It'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comment.php"><?php echo eCommerce\admin\includes\language\lang('Co'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo eCommerce\admin\includes\language\lang('Lo'); ?></a>
        </li>
      </ul>

      <ul class='nav navbar-nav navbar-right'>
        <li class='dropdown'>
          <div class="dropdown custom-dropdown">
            <span class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['user']; ?>
            </span>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="../index.php">Show Shop</a>
              <a class="dropdown-item" href="customers.php?namePage=edit&id=<?php echo $_SESSION['id']; ?>"><?php echo eCommerce\admin\includes\language\lang('Ed'); ?></a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="logout.admin.php"><?php echo eCommerce\admin\includes\language\lang('Logout'); ?></a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>