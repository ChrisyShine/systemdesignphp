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

?>

</body> 
</html>