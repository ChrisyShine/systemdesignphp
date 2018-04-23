<?php
include_once dirname(__FILE__).'\service\follow_service.php';

if(isset($_GET['target_id']) && isset($_GET['follower_id'])){
    $targetId = $_GET['target_id'];
    $followerId = $_GET['follower_id'];
    $rs = addNewFollow($followerId, $targetId);
    var_dump($rs);
    exit;
}

?>