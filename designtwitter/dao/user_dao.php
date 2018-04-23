<?php 
include_once dirname(__FILE__).'\..\conn\pdoconn.php';
include_once dirname(__FILE__).'\..\dto\user.php';

function getUser($id) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    // open connection
    $pdo=PDOConnection::getInstance($dbConf);
    $sql=sprintf("SELECT * from account where id='%s'", $id);
    $rs=$pdo->query($sql);
    $data=$rs->fetchAll();
    if (count($data) == 0) {
        return null;
    } else {
        $user_obj = $data[0];
        $user = new User($user_obj['id'], $user_obj['update_time']);
        return $user;
    }
}

function validateUser($id, $pwd) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    // open connection
    $pdo=PDOConnection::getInstance($dbConf);
    $sql=sprintf("SELECT * from account where id='%s'", $id);
    $rs=$pdo->query($sql);
    $data=$rs->fetchAll();
    if (count($data) == 0) {
        return 0;
    } else {
        $user_obj = $data[0];
        if ($user_obj['password'] != md5($pwd)) {
            return 1;
        } else {
            $user = new User($user_obj['id'], $user_obj['update_time']);
            return $user;
        }
    }
}

function addUser($id, $pwd) {
    $dbConf=include dirname(__FILE__).'\..\config\dbconfig.php';
    $pdo=PDOConnection::getInstance($dbConf);
    $sql=sprintf("insert into account (id, password, update_time) VALUES ('%s', '%s', now())", $id, md5($pwd));
    $rs=$pdo->query($sql);
}

?>