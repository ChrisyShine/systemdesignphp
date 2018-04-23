<?php 
include_once dirname(__FILE__).'\..\dao\follow_dao.php';
include_once dirname(__FILE__).'\..\dao\feed_dao.php';

function addNewFollow($userId, $targetId) {
    $rs = addFollow($userId, $targetId);
    if (!$rs) {
        return false;
    }
    $feeds = getFeedIndicesByUserId($targetId);
    insertNewsFeedIndicesByFeeds($userId, $feeds);
    return true;
}

?>