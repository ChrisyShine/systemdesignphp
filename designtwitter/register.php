<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Twitter PHP</title>
</head>
 
<?php 
$name = $pwd = $pwd1 = '';
$nameErr = $pwdErr = $pwd1Err = $registerErr = '';
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
    if (empty($_POST['pwd1'])) {
        $pwd1Err = 'Repeat Password is required.';
        $validation_success = false;
    } else {
        $pwd1 = escape_input($_POST['pwd1']);
        if ($pwd != '' && $pwd != $pwd1) {
            $pwd1Err = 'Password should be the same';
            $validation_success = false;
        }
    }
}

if ($validation_success) {
    include dirname(__FILE__).'\dao\user_dao.php';
    $user = getUser($name);
    if ($user == null) {
        addUser($name, $pwd);
    } else {
        $validation_success = false;
        $registerErr = 'UserId already exists, please use other UserId.';
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
    		<div><span><?php echo $registerErr;?></span></div>
    		<div>
    			<span>User ID:</span>
    			<input type="text" name="name" value=<?php echo $name;?>><span>* <?php echo $nameErr;?></span><br/>
    		</div>
    		<div>
    			<span>Password:</span>
    			<input type="password" name="pwd"><span>* <?php echo $pwdErr;?></span><br/>
    		</div>
    		<div>
    			<span>Repeat Password:</span>
    			<input type="password" name="pwd1"><span>* <?php echo $pwd1Err;?></span><br/>
    		</div>
    		<div>
    			<input type="submit" value="REGISTER"></input>
    		</div>
    	</div>
	</form>


<?php 
if ($validation_success) {
?>
<p>What your input is:</p>
<div>Name is <?php echo $name;?></div>
<div>Password is <?php echo $pwd;?></div>
<div>Repeat Password is <?php echo $pwd1;?></div>
<?php
}
?>


</body>
 
</html>
