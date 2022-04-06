<?php

/*
====================================================
== This Comment Page
= Mange Edit | Delete | Approve
====================================================
*/

namespace eCommerce\admin\comment;

use function eCommerce\admin\includes\functions\cheackItems;
use function eCommerce\admin\includes\functions\deleteFromData;
use function eCommerce\admin\includes\functions\getCount;
use function eCommerce\admin\includes\functions\updateComment;
use function eCommerce\admin\includes\functions\makeModify;

// Start Out Buffer Open
ob_start();

session_start();

$namePage = '';

if (isset($_COOKIE['cookie-admin']) && !empty($_COOKIE['cookie-admin'])) {
    // make var to show if there is navigation on this page or not
    $navbar = TRUE;

    // make the title of the page
    $pageTitle = 'comment';

    // make the language of the page
    $lan = 'eng';

    // Include init File
    include_once 'init.admin.php';

    // Check If There Is Not Comment

    $count = getCount('comment_id', 'comments');
    if ($count != 0) { // Good, There Is Comment

        isset($_GET['namePage']) ? $namePage = $_GET['namePage'] : $namePage = 'mange';

        if ($namePage == 'mange') { // Mange Home
            // Call File That Have The Table
            include_once $tml . 'comment-table.inc.php';
        } elseif ($namePage == 'edit') { // Edit Page
            // Check If The Id Is Set OR Not
            if (isset($_GET['id']) && !empty($_GET['id'])) { // The Id Is Sent
                // Check If The Id Exist In Data OR Not
                $result = cheackItems('comment_id', 'comments', $_GET['id']);
                if ($result == 1) { // The Comment Is Exist
                    // Call File To Edit The Comment
                    include_once $tml . 'edit-comment.inc.php';
                } else { // The Comment Dos Not Exist
                    echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                    <strong>Sorry</strong> There Is No Id In Data !
                    </p>";
                }
            } else { // There Is No Id Sent
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                <strong>Sorry</strong> There Is No Id Sent !
                </p>";
            }
        } elseif ($namePage == 'update') { // Update Page
            // Check If The Id Is Set OR Not
            if (isset($_GET['id']) && !empty($_GET['id'])) { // The Id Is Sent
                // Check If The Id Exist In Data OR Not
                $result = cheackItems('comment_id', 'comments', $_GET['id']);
                if ($result == 1) { // The Comment Is Exist
                    // Assign The Variables
                    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                    // Call Function To Update The Comment
                    updateComment($comment, $_GET['id']);
                    header('location: comment.php');
                } else { // The Comment Dos Not Exist
                    echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
        <strong>Sorry</strong> There Is No Id In Data !
        </p>";
                }
            } else { // There Is No Id Sent
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            <strong>Sorry</strong> There Is No Id Sent !
            </p>";
            }
        } elseif ($namePage == 'delete') { // Delete Page
            // Check If There Is Id Sent
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                // Check If The Id Exist In Data OR Not
                $result = cheackItems('comment_id', 'comments', $_GET['id']);
                if ($result == 1) { // The Comment Is Exist
                    // Call Function To Delete The Comment
                    deleteFromData('comments', 'comment_id', $_GET['id']);
                    header('location: comment.php');
                } else { // The Comment Dos Not Exist
                    echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
                <strong>Sorry</strong> There Is No Id In Data !
                </p>";
                }
            } else { // The Id Dos Not Sent
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            <strong>Sorry</strong> There Is No Id Sent !
            </p>";
            }
        } elseif ($namePage == 'approve') { // Approve Page
            // Check If There Is Id Sent OR Not
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                // Check If The Id Is Exist In Data OR Not
                $check = cheackItems('comment_id', 'comments', $_GET['id']);
                if ($check == 1) { // The Id Is Exist, Then Do Work
                    if (isset($_GET['removeApprove']) && $_GET['removeApprove'] == 'yes') { // Remove Approve
                        makeModify('comments', 'comment_status', 0, 'comment_id', $_GET['id']);
                    } else { // Make Approve
                        makeModify('comments', 'comment_status', 1, 'comment_id', $_GET['id']);
                    }
                    header('location: comment.php');
                } else { // The Id Not Exist In Data
                    echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
        The Id Dos Not Exist In Data
        </p>";
                }
            } else { // The Id Not Sent
                echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
    There Is No Id Sent
    </p>";
            }
        } else { // There Is No Page That Have This Name
            echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
            Sorry There Is No Page, <a href = 'dash.admin.php'>Go Home Page</a>
            </p>";
        }
    } else { // No Comment, Then See Message To Tell Him There Is No Comment
        echo  "<p style = 'margin-top: 30px' class = 'alert alert-danger fade in alert-dismissible show text-center'> 
        Sorry There Is No Comment, <a href = 'dash.admin.php'>Go Home Page</a>
        </p>";
    }

    // Footer page
    include_once $tml . 'footer.inc.php';
}

// End Out Buffer
ob_end_flush();
