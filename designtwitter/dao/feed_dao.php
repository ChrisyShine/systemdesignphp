<?php 
include_once dirname(__FILE__).'\..\conn\pdoconn.php';
include_once dirname(__FILE__).'\..\dto\feed.php';

function postFeed($userId, $message) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    // add entry to table FEED
    $sql=sprintf("insert into feed (user_id, message, post_time) VALUES ('%s', '%s', now())", $userId, $message);
    $pdo->query($sql);
    // get id for the last insert entry
    $sql_id = "select LAST_INSERT_ID()";
    $rs=$pdo->query($sql_id);
    $data=$rs->fetchAll();
    $last_id = $data[0][0];
    
    // get last inserted feed
    $new_feed = getFeed($last_id);
    return $new_feed;
}

function insertMyOwnFeedIndex($userId, $timestamp, $feedId) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    // insert index for MY_OWN_FEED_INDEX
    $sql_my_own_feed = sprintf("insert into my_own_feed_index (user_id, post_time, feed_id) VALUES ('%s', '%s', '%s')", $userId, $timestamp,$feedId);
    $pdo->query($sql_my_own_feed);
}

function getFeed($id) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    $sql_feed = sprintf("select * from feed where id='%s'", $id);
    $rs=$pdo->query($sql_feed);
    $data=$rs->fetchAll();
    $feed_obj = $data[0];
    $feed = new Feed($feed_obj['id'], $feed_obj['user_id'], $feed_obj['message'], $feed_obj['post_time']);
    return $feed;
}

function getFeedIndicesByUserId($userId) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    $sql = sprintf("select * from my_own_feed_index where user_id='%s'", $userId);
    $rs=$pdo->query($sql);
    $data=$rs->fetchAll();
    return $data;
}

function insertNewsFeedIndicesByUserIds($feed, $userIds) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    $sql = "insert into my_news_feed_index (user_id, post_time, feed_id) VALUES ";
    $firstLoop = true;
    foreach($userIds as $userId) {
        if ($firstLoop) {
            $firstLoop = false;
        } else {
            $sql = $sql . ",";
        }
        $sql = $sql . sprintf("('%s', '%s', '%s')", $userId, $feed->getPostTime(), $feed->getId());
    }
    $pdo->query($sql);
}

function insertNewsFeedIndicesByFeeds($userId, $feeds) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    $sql = "insert into my_news_feed_index (user_id, post_time, feed_id) VALUES ";
    $firstLoop = true;
    foreach($feeds as $feed) {
        if ($firstLoop) {
            $firstLoop = false;
        } else {
            $sql = $sql . ",";
        }
        $sql = $sql . sprintf("('%s', '%s', '%s')", $userId, $feed['post_time'], $feed['feed_id']);
    }
    $pdo->query($sql);
}

function getNewsFeedByUserId($userId) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    
    $sql_index = sprintf("select feed_id from my_news_feed_index where user_id='%s' order by post_time desc", $userId);
    $rs = $pdo->query($sql_index);
    $data = $rs->fetchAll();
    $indexStr = '';
    $firstLoop = true;
    foreach ($data as $item) {
        if ($firstLoop) {
            $firstLoop = false;
        } else {
            $indexStr = $indexStr . ',';
        }
        $indexStr = $indexStr . $item['feed_id'];
    }
    
    $sql = sprintf("select * from feed where id in (%s) ORDER BY find_in_set(id,'%s')", $indexStr, $indexStr);
    $rs = $pdo->query($sql);
    $data = $rs->fetchAll();
    $feeds = array();
    foreach ($data as $feed_obj) {
        array_push($feeds, new Feed($feed_obj['id'], $feed_obj['user_id'], $feed_obj['message'], $feed_obj['post_time']));
    }
    return $feeds;
}


?>