<?php
namespace eCommerce\shop\includes\functions;

// Function get Title
function getTitle()
{
    if (isset($GLOBALS['pageTitle'])) {
        echo $GLOBALS['pageTitle'];
    } else {
        echo 'Default';
    }
}

// Function To get Data
function getDepartment($type, $table, $condition, $value ,$order, $typeOrder = 'ASC'){

    $sta = $GLOBALS['conn']->prepare("SELECT $type FROM $table WHERE $condition = ? ORDER BY $order $typeOrder");
    $sta->execute(array($value));
    return $sta->fetchAll();
}

// Function To Check If The Element Exist In Database OR Not
function checkElement($type, $table, $condition1, $value1, $condition2, $value2){
    $sta = $GLOBALS['conn']->prepare("SELECT COUNT($type) FROM $table WHERE $condition1 = ? && $condition2 = ?");
    $sta->execute(array($value1, $value2));
    return $sta->fetchColumn();
}

// Function To Get The Items With Select
function getItems($id, $approve, $sql = NULL){
    $sta = $GLOBALS['conn']->prepare("SELECT items.*, departments.name AS 'nameDepartment' FROM items INNER JOIN departments ON departments.department_id = items.department_id WHERE items.department_id = ? && items.item_approve = ? $sql");
    $sta->execute(array($id, $approve));
    return $sta->fetchAll();
}
// Function To Check
function check($type, $table, $condition1, $equal  ,$value1, $condition2, $value2, $typeCondition = '&&'){
    $sta = $GLOBALS['conn']->prepare("SELECT $type FROM $table WHERE $condition1 $equal ? $typeCondition $condition2 = ?");
    $sta->execute(array($value1, $value2));
    return $sta->fetchAll();
}
// Function To Select
function select($type, $table){  
    $sta = $GLOBALS['conn']->prepare("SELECT $type FROM $table");
    $sta->execute(array());
    return $sta->fetchAll();
}
// Function To Get The User
function getInformation($type, $table, $condition, $value, $query = NULL){

    $sta = $GLOBALS['conn']->prepare("SELECT $type FROM $table WHERE $condition = ? $query");
    $sta->execute(array($value));
    return $sta->fetchAll();
}

// Function To Get The User
function getSearch($type, $table, $condition, $value, $condition2 ,$value2){

    $sta = $GLOBALS['conn']->prepare("SELECT $type FROM $table WHERE $condition = ? && $condition2  LIKE '%$value2%' ORDER BY iteam_id DESC");
    $sta->execute(array($value));
    return $sta->fetchAll();
}

// Function To Get Item The User
function getAds($userId, $itemId = 'no', $item = 0){
    $query = '';
    if($itemId == 'yes'){
        $query = "&& items_user.items_id = $item";
    }
    $sta = $GLOBALS['conn']->prepare("SELECT items.* , users.* FROM items_user 
    INNER JOIN items ON items.iteam_id = items_user.items_id
    INNER JOIN users ON users.user_id = items_user.user_id Where items_user.user_id = ? $query ORDER BY item_date DESC");
    $sta->execute(array($userId));
    return $sta->fetchAll();
}

// Function To Insert The Customer In Data
function InsertCustomerInData(string $usernameInsert, string $emailInsert, $passwordInsert, $reg_sta = 1, $group_id = 2){
    $sta = $GLOBALS['conn']->prepare('INSERT INTO `users` (`username`, `password`, `email`, `date`, `reg_state`, `group_id`) Values(?,?,?, now(), ?, ?)');
    $sta->execute(array(
        $usernameInsert,
        $passwordInsert,
        $emailInsert,
        $reg_sta,
        $group_id
    ));
}

// Function To Check If The Item Is Exist For This Customer, Before Insert In Data
function checkItemsUser($type, $id, $name){
    $sta = $GLOBALS['conn']->prepare("SELECT $type FROM items_user
    INNER JOIN items ON items.iteam_id = items_user.items_id
    WHERE items_user.user_id = ? && items.item_name = ?");
    $sta->execute(array($id, $name));
    return $sta->fetchAll();
}

// Function To Insert In Items Table
function insertItems($name, $des, $price, $amount, $country, $status, $id, $nameUser, $tagItem , $item_approve = 0)
{
    $sta = $GLOBALS['conn']->prepare('INSERT INTO `items` (`item_name`, `item_description`, `item_date`, `price`, `amount`, `country`, `item_status`, `department_id`, `user_name`, `item_tags` , `item_approve` ) VALUES(:name, :des, now(), :price, :amount, :country, :status, :department_id, :userName, :item_tags , :item_approve)');
    $sta->execute(array(
        'name'          => $name,
        'des'           => $des,
        'price'         => $price,
        'amount'        => $amount,
        'country'       => $country,
        'status'        => $status,
        'department_id' => $id,
        'userName'      => $nameUser,
        'item_tags'     => $tagItem,
        'item_approve'  => $item_approve
    ));
}

// Function To Put The User ID And Items ID Into Table Items Table In DataBases
function insertItemUser($item_id)
{
    $sta = $GLOBALS['conn']->prepare('INSERT INTO `items_user` (`user_id`, `items_id`) VALUES(?,?)');
    $sta->execute(array($_SESSION['normal-id'], $item_id));
}

// Function To Check If This Item Is Exist For User Before Update It
function checkAds($userId, $itemId, $itemName){
    $sta = $GLOBALS['conn']->prepare("SELECT items.item_name , users.username FROM items_user 
    INNER JOIN items ON items.iteam_id = items_user.items_id
    INNER JOIN users ON users.user_id = items_user.user_id Where items_user.user_id = ? && items_user.items_id != ? && items.item_name = ?");
    $sta->execute(array($userId, $itemId, $itemName));
    return $sta->fetchAll();
}

// Update The Items
function updateItems($item_des, $price, $amount, $item_status, $department_id, $item_name, $tagsItem , $item_id){
    $sta = $GLOBALS['conn']->prepare("UPDATE items SET `item_description` = :item_des, `price` = :price, `amount` = :amount, `item_status` = :item_status, `department_id` = :department_id, `item_name` = :item_name, `item_tags` = :item_tags WHERE iteam_id = :item_id");
    $sta->execute(array(
        'item_des'      => $item_des,
        'price'         => $price,
        'amount'        => $amount,
        'item_status'   => $item_status,
        'department_id' => $department_id,
        'item_name'     => $item_name,
        'item_tags'     =>$tagsItem,    
        'item_id'       =>$item_id
    ));
}

// Function To Delete From Databases
function deleteFromData($table, $colum, int $value, $query = NULL)
{
    $sta = $GLOBALS['conn']->prepare("DELETE FROM $table WHERE $colum = ? $query");
    $sta->execute(array($value));
}

// Function To Get Item The User 
function getAdsForItems($itemId){
    $sta = $GLOBALS['conn']->prepare("SELECT items.* , users.* FROM items_user 
    INNER JOIN items ON items.iteam_id = items_user.items_id
    INNER JOIN users ON users.user_id = items_user.user_id Where items_user.items_id = ?");
    $sta->execute(array($itemId));
    return $sta->fetch();
}

// Function To Insert The Comment
function insertComment($comment, $itemId, $userId){
    $sta = $GLOBALS['conn']->prepare("INSERT INTO comments (`comment`, `comment_date`,`iteam_id`, `user_id`, `comment_status`) VALUES(:comment, now(), :itemId, :userId, 1)");
    $sta->execute(array(
        'comment'   => $comment,
        'itemId'   => $itemId,
        'userId'   => $userId
    ));
}

// Function To Gte The Comment
function getComment($itemId, $approve){
    $sta = $GLOBALS['conn']->prepare("SELECT users.full_name, users.user_image ,users.username ,users.reg_state ,items.*, comments.* FROM comments
    INNER JOIN users ON users.user_id = comments.user_id
    INNER JOIN items ON items.iteam_id = comments.iteam_id
    WHERE items.iteam_id = ? && items.item_approve = ? ORDER BY `comment_id` DESC");
    $sta->execute(array($itemId, $approve));
    return $sta->fetchAll();
}

// Function To Get The Tags
function getTags($name){
    $sta = $GLOBALS['conn']->prepare("SELECT * FROM items WHERE item_tags LIKE '%$name%'");
    $sta->execute(array());
    return $sta->fetchAll();
}

// Function To Insert Save Item
function saveItem($userId, $itemId){
    $sta = $GLOBALS['conn']->prepare("INSERT INTO items_bay (`user_id`,`item_id`,`item-bay_date`) VALUES (:userId, :itemId, now())");
    $sta->execute(array(
        'userId'    => $userId,
        'itemId'    => $itemId
    ));
}

// Function To Get The Item Love
function getLoveItem($userId){
    $sta = $GLOBALS['conn']->prepare("SELECT items.* FROM items_bay
    INNER JOIN items ON items.iteam_id = items_bay.item_id
    WHERE items_bay.user_id = ?");
    $sta->execute(array($userId));
    return $sta->fetchAll();
}

// Function To Update The Love Item
function updateLove($itemStatus = 1, $userId){
    $sta = $GLOBALS['conn']->prepare("UPDATE `items_bay` SET `item-bay_see` = :itemStatus WHERE `user_id` = :userId");
    $sta->execute(array(
        'itemStatus'    => $itemStatus,
        'userId'        => $userId
    ));
}