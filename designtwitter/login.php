<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Twitter PHP</title>
</head>
 
<?php
session_start();


if(isset($_GET['action']) && $_GET['action'] == 'logout'){
    unset($_SESSION['userId']);
}


if(isset($_SESSION['userId'])){
    header("Location:index.php");
    exit();
}


$name = $pwd = '';
$nameErr = $pwdErr = $loginErr = '';
$validation_success = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validation_success = true;
    if (empty($_POST['name'])) {
        $nameErr = 'Name is required.';
        $validation_success = false;
    } else {
        $name = escape_input($_POST['name']);
    }
    if (empty($_POST['pwd'])) {
        $pwdErr = 'Password is required.';
        $validation_success = false;
    } else {
        $pwd = escape_input($_POST['pwd']);
    }
}

if ($validation_success) {
    include dirname(__FILE__).'\dao\user_dao.php';
    $user = validateUser($name, $pwd);
    if ($user instanceof User) {
        $_SESSION['userId'] = $user->getId();
        header("Location:index.php");
        exit();
    } else if ($user == 0) {
        $validation_success = false;
        $loginErr = 'UserId does not exist.';
    } else if ($user == 1) {
        $validation_success = false;
        $loginErr = 'UserId does not match password.';
    }
}


function escape_input($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

 
 
<body>
	<form action="" method="post">
    	<div>
    		<div><span><?php echo $loginErr;?></span></div>
    		<div>
    			<span>User ID:</span>
    			<input type="text" name="name" value=<?php echo $name;?>><span>* <?php echo $nameErr;?></span><br/>
    		</div>
    		<div>
    			<span>Password:</span>
    			<input type="password" name="pwd"><span>* <?php echo $pwdErr;?></span><br/>
    		</div>
    		<div>
    			<input type="submit" value="LOGIN"></input>
    		</div>
    	</div>
	</form>


<?php 
if ($validation_success) {
?>
<p>What your input is:</p>
<div>Name is <?php echo $name;?></div>
<div>Password is <?php echo $pwd;?></div>
<?php
}
?>


</body>
 
</html>
