<!DOCTYPE html> 
<html> 
<head>
	<script type="text/babel" src="js/feed.js"></script>
</head>

<body> 

<?php 
    include dirname(__FILE__).'\templates\header.html';
?>

<h1>Welcome</h1>
<div id="example"></div>

<div>
	<form action="" method="post">
		<textarea id="feedarea" name="message" rows="5" cols="40"></textarea>
		<input type="submit" value="POST"></input>
	</form>
</div>

<div id="feeds"></div>
<br/>
<br/>
<br/>

<?php 
session_start();
if(!isset($_SESSION['userId'])){
    header("Location:login.php");
    exit();
}

$userId = $_SESSION['userId'];

include dirname(__FILE__).'\service\feed_service.php';

$message = '';
$messageErr = '';
$validation_success = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validation_success = true;
    if (empty($_POST['message'])) {
        $messageErr = 'Message is required.';
        $validation_success = false;
    } else {
        $message = escape_input($_POST['message']);
    }
    if ($validation_success) {
        postNewFeed($userId, $message);
    }
}


function escape_input($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$feeds = getNewsFeed($userId);

?>

<div>
<?php
foreach ($feeds as $feed) {
?>
<div>
	<div><span><?php echo $feed->getUserId();?></span></div>
	<div><?php echo $feed->getPostTime();?></div>
	<div><?php echo $feed->getMessage();?></div>
</div>
<?php
}
?>
</div>

</body> 
</html>