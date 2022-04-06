<?php

namespace eCommerce\shop\login;

use function eCommerce\shop\includes\functions\check;
use function eCommerce\shop\includes\functions\InsertCustomerInData;

// Open Buffer
ob_start();

// start session to allow from user to enter to dashBorder
session_start();

// Check If There Is Session OR Not
if (isset($_SESSION['normal-user']) && !empty($_SESSION['normal-user'])) {
    header('location: index.php');
    exit();
}

// make var to show if there is navigation on this page or not
$navbar = TRUE;
// make var to show if The Lang Is Arabic OR  eng
$lan = 'eng';
// make the title of the page
$pageTitle = 'login';

// Call connect File
include_once 'control-admin/includes/functions/connect.admin.php';

// Call init File
include_once 'init.php';
// Check If The http Come From Post OR Not
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Assign The Request In Variable
        $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
        $password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
        // Make Array Of Error
        $errors = array();
        if (strlen($username) <= 3) {
            $errors[] =  "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Username Must Big That 3 Char </p>";
        }
        if (strlen($password) <= 3) {
            $errors[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The PASSWORD Must Big That 3 Char </p>";
        }
        // Check Of Errors Before Connect Databases
        if (!empty($errors)) { // There Is Errors, Print The Error And No Connect Databases
            echo '<div class = "container text-center" style="margin-top:60px">';
            foreach ($errors as $error) {
                echo $error;
            }
            echo '</div>';
        } else { // Good, There Is No Errors, Connect Databases
            $users = check('*', 'users', 'username', '=',$username, 'password', $password);
            // Check If There Is User OR Not
            if (!empty($users)) { // Good, There Is User
                $_SESSION['normal-user'] = $username;
                $_SESSION['normal-id']   = $users[0]['user_id'];
                $_SESSION['normal-group_id'] = $users[0]['group_id'];
                $_SESSION['normal_user_image'] = $users[0]['user_image'];
                header("location: index.php");
                exit();
            } else { // The Username OR Password False
                echo "<div class = 'container' style = 'margin-top: 40px'>";
                echo "<p class = 'text-center alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Username OR Password Wrong, Try Agin </p>";
                echo "</div>";
            }
        }
    } else { // Signup Page
        // Assign The Value In Variable
        $username       = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
        $email          = $_POST['email'];
        $password       = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
        $confirmPass    = trim(filter_var($_POST['password2'], FILTER_SANITIZE_STRING));
        //Crete Array Of Errors
        $errors = array();
        if (strlen($username) <= 3) {
            $errors[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Username Must Big That 3 Char </p>";
        }
        if (strlen($password) <= 3 || strlen($confirmPass) <= 3) {
            $errors[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Password Must Big That 3 Char </p>";
        }
        if ($password != $confirmPass) {
            $errors[] = "<p class = 'alert alert-danger fade in alert-dismissible show'> <strong> WRONG ! </strong>  Sorry The Password Not Match </p>";
        }
        // Check If There Is No Errors Before Connect Databases
        if (empty($errors)) { // Good, There Is No Errors
            // Check If The Email OR username Exist OR Not
            $result = check('username', 'users', 'username', '=', $username, 'email', $email, 'OR');
            if(empty($result)){ // Good, There Is No Customer With This username OR email
                // Insert New Users
                InsertCustomerInData($username, $email, $password);
                $_SESSION['signup_name'] = $username;
                $_SESSION['signup_password'] = $password;
                echo "<div class = 'container' style = 'margin-top: 40px'>";
                echo "<p class = 'text-center alert alert-success fade in alert-dismissible show'> <strong> Good! </strong>  Login By Use username And Password</p>";
                echo "</div>";
            }else{ // The username OR Email Is Already Exist
                echo "<div class = 'container' style = 'margin-top: 40px'>";
                echo "<p class = 'text-center alert alert-info fade in alert-dismissible show'> <strong> Note! </strong> The Username OR Email Is Exist </p>";
                echo "</div>";
            }
        } else { // There Is Errors
            echo '<div class = "container text-center" style="margin-top:60px">';
            foreach ($errors as $error) {
                echo $error;
            }
            echo '</div>';
        }
    }
}
?>
<div class="container">
    <section class="title text-center">
        <h3>
            <span class="select" data-select="login"> Login </span> |
            <span data-select="signup"> signup </span>
        </h3>
    </section>
</div>
<!-- Start Login Page -->
<section class="login">
    <div class='container log-page'>
        <div class='row'>
            <div class='col-lg-5 col-sm-12 form-cont'>
                <form method='POST' class="custom-form" action="login-page.php">
                    <div class="form-group">
                        <div class='input-con'>
                            <div class='i1'> <i class="fas fa-user fa-fw"></i></div>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username" name='username'  value = "<?php if(isset($_SESSION['signup_name'])){echo $_SESSION['signup_name'];} ?>" required>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your Username with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <div class='input-con'>
                            <div class='i1'><i class="fas fa-lock fa-fw i"></i></div>
                            <div class='pass'> <i class="fas fa-eye fa-fw"></i></div>
                            <input type="password" class="form-control custom-password" id="exampleInputPassword1" placeholder="Password" name='password' value = "<?php if(isset($_SESSION['signup_password'])){echo $_SESSION['signup_password'];} ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block submit" value='login' name="login"> Login </button>
                    <span class='forget'> If Forget Email OR password ? <a href='https://gaza-gifted-youth.000webhostapp.com/' target="_blank" style="color:#007bff"> Connect Us</a> </span>
                </form>
            </div>
            <div class='col-lg-7 col-sm-12'>
                <figure class='images'>
                    <img src='layout/images/undraw_Login_v483.png' alt='No Internet' class='img-fluid' />
                </figure>
            </div>
        </div>
    </div>
</section>
<!-- End Login Page -->

<!-- Start signup Page -->
<section class="signup">
    <div class='container log-page'>
        <div class='row'>
            <div class='col-lg-6 col-sm-12 form-cont'>
                <figure class='images2'>
                    <img src='layout/images/undraw_steps_ngvm.png' alt='No Internet' class='img-fluid' />
                </figure>
            </div>
            <div class='col-lg-6 col-sm-12 form-cont'>
                <form method='POST'>
                    <div class="form-group">
                        <div class='input-con'>
                            <div class='i1'> <i class="fas fa-user fa-fw"></i></div>
                            <input type="text" class="form-control" placeholder="Username" name='username' pattern=".{4,8}"  title="The Username Between 4 & 8 Char And From A To Z" required>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your Username with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <div class='input-con'>
                            <div class='i1'> <i class="fas fa-envelope fa-fw"></i></div>
                            <input type="email" class="form-control" id="inputEmail" placeholder="Email" name='email' required title="Enter Your Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='input-con'>
                            <div class='i1'><i class="fas fa-lock fa-fw i"></i></div>
                            <div class='pass'> <i class="fas fa-eye fa-fw"></i></div>
                            <input type="password" class="form-control custom-password" id="exampleInputPassword1" placeholder="Password" name='password' pattern=".{4,12}"  title="The Password Between 4 & 12 Char " required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='input-con'>
                            <div class='i1'><i class="fas fa-lock fa-fw i"></i></div>
                            <input type="password" class="form-control custom-password" id="exampleInputPassword1" placeholder="Confirm Password" name='password2' required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block submit" value='login'>Signup</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Signup Page -->
<?php
include_once $tml . 'footer-login.php';
// Exit Open Buffer
ob_end_flush();
