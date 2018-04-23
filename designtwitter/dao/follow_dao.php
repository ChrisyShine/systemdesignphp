<?php 
include_once dirname(__FILE__).'\..\conn\pdoconn.php';

function addFollow($userId, $targetId) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    // add entry to table FEED
    $sql=sprintf("select * from follower_index where target_id='%s' and follower_id='%s'", $targetId, $userId);
    $rs = $pdo->query($sql);
    $data = $rs->fetchAll();
    if (count($data) == 0) {
        $sql_insert = sprintf("insert into follower_index (target_id, follower_id) values ('%s', '%s')", $targetId, $userId);
        $pdo->query($sql_insert);
        return true;
    } else {
        return false;
    }
}

function getFollowerIds($targetId) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    
    $sql = sprintf("select follower_id from follower_index where target_id='%s'", $targetId);
    $rs = $pdo->query($sql);
    $data = $rs->fetchAll();
    $ids = array();
    foreach($data as $item) {
        array_push($ids, $item['follower_id']);
    }
    return $ids;
}

?>