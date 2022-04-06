<?php

/*

    [1] => function To Print Title

*/

namespace eCommerce\admin\includes\functions;

// Function get Title
function getTitle()
{
    if (isset($GLOBALS['pageTitle'])) {
        echo $GLOBALS['pageTitle'];
    } else {
        echo 'Default';
    }
}

// Function Check If The Username And Password Is Exist OR Not
function cheackCustomer(string $usernameEdit, string $emailEdit, int $id): int
{
    // Connect Databases And Show If The Information Is Exist OR Not 
    $sta = $GLOBALS['conn']->prepare("SELECT * FROM `users` WHERE Not `user_id` = ? && (`username` = ? || `email` = ?)");
    $sta->execute(array(
        $id,
        $usernameEdit,
        $emailEdit
    ));
    $rowCount = $sta->rowCount();
    if ($rowCount >= 1)
        return 1;
    return 0;
}

// Function To Update Information
function UpdateInformation(string $usernameEdit, string $emailEdit, $passwordEdit, string $fullNameEdit, $image, int $id)
{

    $sta = $GLOBALS['conn']->prepare('UPDATE `users` SET `username` = ?, `email` = ?, `password` = ?, `full_name` = ?, `user_image` = ? WHERE `user_id` = ?');
    $sta->execute(array($usernameEdit, $emailEdit, $passwordEdit, $fullNameEdit, $image, $id));
    // Show Welcome Message
    echo '<h2 class = "text-center" style = "color: #505050; font-weight: 900; margin-bottom: 30px; font-family: Raleway, sans-serif; padding-top: 40px; font-size: 40px"> Update Information </h2>';
    // show message will done and show new information                
    $well =  '<div class="alert alert-success container" role="alert" style = "margin-top:30px">
    <span class="alert-heading h4">Well done!</span> ' . $fullNameEdit .  "<br><br>" . '
    <span> 1) Remember That The Username To Login Is </span> ' . $usernameEdit . '
    <span> <br> 2)  The Password To Login Is </span>' . $passwordEdit . '
    <hr>
    <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy. <strong><a href="customers.php">GO Mange Customer</a></strong></p>
    </div>';
    echo $well;

    // Change Session user If Come From edit nav
    if (isset($_SESSION['test_id']) && $_SESSION['test_id'] == $_SESSION['id']) {
        $_SESSION['user'] = $usernameEdit;
        $_COOKIE['cookie-admin'] = $usernameEdit;
    }
}

// Function To Cheack If The Customer Is Exist Before I Insert It
function CheackCustomerToInsert(string $usernameInsert, string $emailInsert): int
{
    // Connect To Databases And If The Username Is Exist Then I Will Not Insert It
    $sta = $GLOBALS['conn']->prepare('SELECT `username` FROM `users` WHERE `username` = ?  || `email` = ? LIMIT 1');
    $sta->execute(array($usernameInsert, $emailInsert));
    $count = $sta->rowCount();
    if ($count >= 1)
        return 0;
    return 1;
}

// Function To Insert The Customer In Data
function InsertCustomerInData(string $usernameInsert, string $emailInsert, $passwordInsert, string $fullNameInsert, $image, $reg_sta = 0)
{
    $sta = $GLOBALS['conn']->prepare('INSERT INTO `users` (`username`, `password`, `email`, `full_name`, `date`, `user_image` ,`reg_state`) Values(?,?,?,?, now(), ? ,?)');
    $sta->execute(array(
        $usernameInsert,
        $passwordInsert,
        $emailInsert,
        $fullNameInsert,
        $image,
        $reg_sta
    ));
    // Go To Customers Window
    header('location: customers.php');
}

// Function To Cheack Customer Before Make Him Admin
function cheackItems(string $colum, string $table, $value): int
{
    $sta = $GLOBALS['conn']->prepare("SELECT $colum FROM $table WHERE $colum = ?");
    $sta->execute(array($value));
    $count = $sta->rowCount();
    // Return 1 If The User Is Exist
    if ($count == 1)
        return 1;
    return 0;
}

// Function To Modify Any Thing
function makeModify(string $table, string $colum, int $modify, $cond, int $value)
{
    $sta = $GLOBALS['conn']->prepare("UPDATE $table SET $colum = ? WHERE $cond = ?");
    $sta->execute(array($modify, $value));
}

// Function To Delete From Databases
function deleteFromData($table, $colum, int $value)
{
    $sta = $GLOBALS['conn']->prepare("DELETE FROM $table WHERE $colum = ?");
    $sta->execute(array($value));
}


// Function To Get Any Value
function getCount(string $nameColum, string $table): int
{
    $sta = $GLOBALS['conn']->prepare("SELECT COUNT($nameColum) FROM $table");
    $sta->execute(array());
    return $sta->fetchColumn();
}

// Function To Print ALL The Data In Table
function printInTable($nameColum, string $myTable, string $not = 'NOT', $isAdmin = 1, $publicAdmin = 1, $req1 = 1, $req2 = 0): array
{

    $statement = $GLOBALS['conn']->prepare("SELECT $nameColum FROM $myTable WHERE $not `group_id` = ? AND `public_admin` != ? AND `reg_state` IN(?,?) ORDER BY `date` DESC");
    $statement->execute(array($isAdmin, $publicAdmin, $req1, $req2));
    return $statement->fetchAll();
}

// Function To Get req Sate
function getReg(string $colum, string $table): int
{
    $sta = $GLOBALS['conn']->prepare("SELECT COUNT($colum) FROM $table WHERE $colum = ? AND `public_admin` != ?");
    $sta->execute(array(0, 1));
    return $sta->fetchColumn();
}

// Function To Print Last Custom Data In Table, Note No execute In Limit
function getLastToPrint($select, $table, $order, $typeOrder, $limit = 5)
{
    $sta = $GLOBALS['conn']->prepare("SELECT $select FROM $table ORDER BY  $order $typeOrder LIMIT $limit");
    $sta->execute(array());
    return $sta->fetchAll();
}

// Function To Insert New Department In Databases
function insertDepartment($name, $des, $comm, $ord, $ads, $vis)
{
    $sta = $GLOBALS['conn']->prepare("INSERT INTO `departments` (`name`, `description`, `allow_comment`, `custom_ordering`, `allow_ads`, `visibiltiy`,`date`) 
    VALUES(:z_name, :z_description, :z_allow_comment, :z_custom_ordering, :z_allow_ads, :z_visibiltiy, now())");
    $sta->execute(array(
        'z_name'            => $name,
        'z_description'     => $des,
        'z_allow_comment'   => $comm,
        'z_custom_ordering' => $ord,
        'z_allow_ads'       => $ads,
        'z_visibiltiy'      => $vis
    ));
}

// Function To Get The Department
function getDepartment($type, $nameTable, $sort = 'ASC')
{
    $sta = $GLOBALS['conn']->prepare("SELECT $type FROM $nameTable ORDER BY `custom_ordering` $sort");
    $sta->execute(array());
    return $sta->fetchAll();
}

// Function To Get Data From Any Table
function gdfATo($type, $table, $colum, $value)
{
    $sta = $GLOBALS['conn']->prepare("SELECT $type FROM $table WHERE $colum = ?");
    $sta->execute(array($value));
    return $sta->fetch();
}

// Function To Check The Department Before Insert OR Update In Data
function checkDepartment($nameColum, $table, $cond1, $value1, $cond2, $value2)
{
    $sta = $GLOBALS['conn']->prepare("SELECT $nameColum FROM $table WHERE  $cond1 = ? && $cond2 != ?");
    $sta->execute(array($value1, $value2));
    $count = $sta->rowCount();
    // Return 1 If The Department Is Exist
    if ($count == 1)
        return 1;
    return 0;
}

// Function To Update The Departments
function updateDepartment($name, $des, $comment, $ordering, $ads, $vis, $id)
{
    $sta = $GLOBALS['conn']->prepare("UPDATE departments SET `name` = :z_name, `description` = :z_des, `allow_comment` = :z_comment, `custom_ordering` = :z_order, `allow_ads` = :z_ads, `visibiltiy` = :z_vis WHERE `department_id` = :z_id");
    $sta->execute(array(
        'z_name'     => $name,
        'z_des'      => $des,
        ':z_comment' => $comment,
        'z_order'    => $ordering,
        'z_ads'      => $ads,
        'z_vis'      => $vis,
        'z_id'       => $id
    ));
}

// Function To Check If The User Have The Same Items OR Not, In item_user Table
function cheackItemsForUser($select, $table, $cond1, $value1, $cond2, $value2)
{
    $sta = $GLOBALS['conn']->prepare("SELECT $select FROM $table WHERE $cond1 = ? && $cond2 = ?");
    $sta->execute(array($value1, $value2));
    return $sta->fetchALL();
}

// Function To Insert In Items Table
function insertItems($name, $des, $tags, $price, $amount, $country, $status, $id, $image, $nameUser)
{
    $sta = $GLOBALS['conn']->prepare('INSERT INTO `items` (`item_name`, `item_description`, `item_tags` ,`item_date`, `price`, `amount`, `country`, `item_status`, `department_id`, `item_image` ,`user_name` ) VALUES(:name, :des, :item_tags ,now(), :price, :amount, :country, :status, :department_id, :item_image ,:userName)');
    $sta->execute(array(
        'name'          => $name,
        'des'           => $des,
        'item_tags'     => $tags,
        'price'         => $price,
        'amount'        => $amount,
        'country'       => $country,
        'status'        => $status,
        'department_id' => $id,
        'item_image'    => $image,
        'userName'      => $nameUser
    ));
}

// Function To Put The User ID And Items ID Into Table Items Table In DataBases
function insertItemUser($item_id)
{
    $sta = $GLOBALS['conn']->prepare('INSERT INTO `items_user` (`user_id`, `items_id`) VALUES(?,?)');
    $sta->execute(array($_COOKIE['cookie-id'], $item_id));
}

// Function To Select Items
function printItems()
{
    $sta = $GLOBALS['conn']->prepare("SELECT items.*, users.full_name, users.username ,users.group_id FROM items_user
    INNER JOIN items ON items.iteam_id = items_user.items_id 
    INNER JOIN users ON users.user_id = items_user.user_id  ORDER BY iteam_id DESC");
    $sta->execute(array());
    return $sta->fetchAll();
}


// Function To Select Custom Items
function printCustomItems($id)
{
    $sta = $GLOBALS['conn']->prepare("SELECT items.*, users.full_name, users.group_id,  users.username FROM items_user
    INNER JOIN items ON items.iteam_id = items_user.items_id
    INNER JOIN users ON users.user_id = items_user.user_id
    WHERE items_user.user_id = ? ORDER BY iteam_id DESC");
    $sta->execute(array($id));
    return $sta->fetchAll();
}

// Function To Check The Items Is Exist OR NOT After Edit
function checkItemsAfterEdit($nameColum, $table, $cond1, $value1, $cond2, $value2, $cond3, $value3)
{
    $sta = $GLOBALS['conn']->prepare("SELECT $nameColum FROM $table WHERE  $cond1 = ? && $cond2 != ? && $cond3 = ?");
    $sta->execute(array($value1, $value2, $value3));
    $count = $sta->rowCount();
    // Return 1 If The Department Is Exist
    if ($count == 1)
        return 1;
    return 0;
}

// Function To Update The Data From Items
function updateItems($des, $price, $amount, $country, $status, $department, $name, $tags, $image, $id)
{
    $sta = $GLOBALS['conn']->prepare("UPDATE `items` SET `item_description` = :description, `price` = :price, `amount` = :amount, `country` = :country, `item_status` = :status, `department_id` = :department , `item_name` = :name, `item_tags` = :tags, `item_image` = :item_image WHERE `iteam_id` = :id");
    $sta->execute(array(
        'description'   => $des,
        'price'         => $price,
        'amount'        => $amount,
        'country'       => $country,
        'status'        => $status,
        'department'    => $department,
        'name'          => $name,
        'tags'          => $tags,
        'item_image'    => $image,
        'id'            => $id
    ));
}

// function To Get The Comment
function getComment()
{
    $sta = $GLOBALS['conn']->prepare("SELECT users.username, users.public_admin ,users.user_id, users.full_name , comments.* , items.item_name AS 'name_item' FROM comments
    INNER JOIN `users` ON users.user_id = comments.user_id
    INNER JOIN `items` ON items.iteam_id = comments.iteam_id");
    $sta->execute(array());
    return $sta->fetchAll();
}

// Function To update The Comment
function updateComment($comment, $id)
{
    $sta  = $GLOBALS['conn']->prepare("UPDATE `comments` SET `comment` = :comment WHERE `comment_id` = :id");
    $sta->execute(array(
        'comment'   => $comment,
        'id'        => $id
    ));
}
