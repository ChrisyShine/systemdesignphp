<?php 
include_once dirname(__FILE__).'\..\dao\feed_dao.php';
include_once dirname(__FILE__).'\..\dao\follow_dao.php';

function postNewFeed($userId, $message) {
    $feed = postFeed($userId, $message);
    insertMyOwnFeedIndex($userId, $feed->getPostTime(), $feed->getId());
    $followerIds = getFollowerIds($userId);
    array_push($followerIds, $userId);
    $followerIds = array_unique($followerIds);
    insertNewsFeedIndicesByUserIds($feed, $followerIds);
    return $feed;
}

function getNewsFeed($userId) {
    return getNewsFeedByUserId($userId);
}

?>