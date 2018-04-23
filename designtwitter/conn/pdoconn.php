<?php 
class PDOConnection{
    private static $pdo;
    
    private function __construct(){
        //code
    }
    private function __clone(){
        //code
    }
    /**
     * get PDO instance
     * @return PDO
     */
    public static function getInstance($dbconf){
        if(!(self::$pdo instanceof PDO)){
            $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s;charset=%s", $dbconf['host'], $dbconf['port'], $dbconf['dbname'], $dbconf['charset']);
            try {
                self::$pdo = new PDO($dsn,$dbconf['user'], $dbconf['password'], array(PDO::ATTR_PERSISTENT => true,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); //保持长连接
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            } catch (PDOException $e) {
                print "Error:".$e->getMessage()."<br/>";
                die();
            }
        }
        return self::$pdo;
    }
}
?>