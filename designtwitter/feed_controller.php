<?php
session_start();
if(!isset($_SESSION['userId'])){
    header("Location:login.php");
    exit();
}

$userId = $_SESSION['userId'];

include dirname(__FILE__).'\service\feed_service.php';

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $feeds = getNewsFeed($userId);
    $result = array();
    foreach ($feeds as $feed) {
        $item = array('id'=>$feed->getId(), 'user'=>$feed->getUserId(),'time'=>$feed->getPostTime(), 'message'=>$feed->getMessage());
        array_push($result, $item);
    }
    $response = json_encode($result);
    header("Content-Type:application/json");
    echo $response;
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validation_success = true;
    $message = '';
    $postData = file_get_contents("php://input");
    $postData = json_decode($postData, TRUE);
    if (empty($postData['message'])) {
        $validation_success = false;
    } else {
        $message = escape_input($postData['message']);
    }
    header("Content-Type:application/json");
    if ($validation_success) {
        $feed = postNewFeed($userId, $message);
        $result = array('id'=>$feed->getId(), 'user'=>$feed->getUserId(),'time'=>$feed->getPostTime(), 'message'=>$feed->getMessage());
        $response = json_encode($result);
        echo $response;
    } else {
        echo false;
    }
}

function escape_input($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>