<?php
/*

    ===========================================================
    ===== Department Page 
    == Department Page Contain [ Mange || Edit || Add || Delete ]
    ===========================================================

*/
// namespace
namespace eCommerce\admin\department;

// Start Out Buffer
ob_start();

// Start Session
session_start();

// Use namespace init
use eCommerce\admin\init;
use function eCommerce\admin\includes\functions\cheackItems;
use function eCommerce\admin\includes\functions\insertDepartment;
use function eCommerce\admin\includes\functions\updateDepartment;
use function eCommerce\admin\includes\functions\checkDepartment;
use function eCommerce\admin\includes\functions\deleteFromData;

$namePage = '';

if (isset($_COOKIE['cookie-admin']) && !empty($_COOKIE['cookie-admin'])) {

    $pageTitle = 'Departments';
    $lan = 'eng';
    $navbar = TRUE;

    // Include init File
    include_once 'init.admin.php';
    // Check If The Customers Want add or delete or edit
    isset($_GET['namePage']) ? $namePage  = $_GET['namePage'] : $namePage = 'mange';

    // Check If namePage Mange
    if ($namePage == 'mange') { // Mange Department
        // Check The Type Of Sort
        $sort = 'ASC';
        $arrayLink = ['ASC', 'DESC'];
        if (isset($_GET['link']) && in_array($_GET['link'], $arrayLink)) {
            $sort = $_GET['link'];
        }
        // include Mange File
        include_once $tml . 'mange-department.inc.php';
    } elseif ($namePage == 'add') { // Add Page

        include_once $tml . 'add-department.inc.php';
    } elseif ($namePage == 'insert') { // Insert Page 
        // Check If These Data Come Form Post Or Not
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Assign This Request Into Variables
            $name       = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
            $des        = filter_var($_POST['des'], FILTER_SANITIZE_STRING);
            $order      = $_POST['order'];
            $vis        = $_POST['visibility'];
            $comment    = $_POST['comment'];
            $ads        = $_POST['ads'];

            // Check The Item If Exist Before Insert In Data, If The Result Return 1 Then The Des Is Exist
            $check = cheackItems('name', 'departments', $name);
            if ($check == 0) { // There Is No Description With That Name
                // Call Function To Insert
                insertDepartment($name, $des, $comment, $order, $ads, $vis);
                header('location: ?namePage=mange&link=ASC');
            } else { // The Description Is Exist
                echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                Sorry This Department Is Exist, Try With <a href = '?namePage=add'>New Department</a>
                </p>";
            }
        } else { // The Person Not Come From Post
            echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            Sorry You Cant Enter This Page  
            </p>";
        }
    } elseif ($namePage == 'edit') { // Edit Page
        // Check If There Is No Id Sent
        if (isset($_GET['id'])) {
            $department_id = $_GET['id'];
            // Check If The Id Is Exist In Data Or Not
            $result = cheackItems('department_id', 'departments', $department_id);
            if ($result == 1) { // The Department Is Exist, Then Do Work
                // Include The File Have Form To Edit The Information
                include_once  $tml . 'department.edit.inc.php';
            } else { // The Departments Is Not Exist ): 
                echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            Sorry The Department Dos Not Exist
            </p>";
            }
        } else { // There Is Not Sent Id
            echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            Sorry There Is No Id Sent
            </p>";
        }
    } elseif ($namePage == 'update') { // Update Page
        // Check If There Is Not Send Id
        if (isset($_GET['id']) && !empty($_GET['id'])) { // The Id Send
            // check If The Id Is Exist OR Not
            $check = cheackItems('department_id', 'departments', $_GET['id']);
            if ($check == 1) { // The Id Is Exist, Then Do Work
                // Assign The Data In Variables
                $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $des        = filter_var($_POST['des'], FILTER_SANITIZE_STRING);
                $order      = $_POST['order'];
                $vis        = $_POST['visibility'];
                $comment    = $_POST['comment'];
                $ads        = $_POST['ads'];
                // Check If The New Name Is Exist In Data OR Not
                $checkName = checkDepartment('name', 'departments', 'name', $name, 'department_id', $_GET['id']);
                if ($checkName == 0) { // The New Name Dep Not Exist In Data, Then Do Work
                    updateDepartment($name, $des, $comment, $order, $ads, $vis, $_GET['id']);
                    header('location: ?namePage=mange');
                } else { // The New Name Exist In Data, The Show Message That Tell Him Do not Allow To Add 2 De Same Name 
                    echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                There Is Already Department That Have This Name, <a href = '?namePage=mange'>Try With New Department</a>
                </p>";
                }
            } else { // The Id Is Sent But Not Fount In Databases
                echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                There is No id In Databases
                </p>";
            }
        } else { // Not Sent Id
            echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            There is No id Sent
            </p>";
        }
    } elseif ($namePage == 'delete') { // Delete Page
        // Check If There Is Id Sent or not
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Check If This Id Exist In Databases Before Delete Him In Databases
            $check = cheackItems('department_id', 'departments', $_GET['id']);
            if ($check == 1) { // The Id Is Exist In Data, Then Do Work
                deleteFromData('departments', 'department_id', $_GET['id']);
                header('location:?namePage=mange&link=ASC');
            } else { // The Department Not Exist In Databases
                echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                The Id Dos Not Exist In Data !!
                </p>";
            }
        } else { // There Is No Id Sent
            echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            There Is No Id Sent
            </p>";
        }
    } else { // There Is Not Name Page That Name Is Un know
        echo "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
        There Is No Page That Have This Name
        </p>";
    }

    include_once $tml . 'footer.inc.php';
} else {
    // If he enter without login
    header('location: index.php');
    exit();
}

// End Out Buffer
ob_end_flush();
