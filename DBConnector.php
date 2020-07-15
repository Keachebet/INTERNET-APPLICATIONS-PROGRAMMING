<?php
//define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS','');
//define('DB_NAME','btc3205');

class DBConnector{
    public $conn;

    function __construct(){
     global $conn;
    $dbserver = 'localhost';
    $dbname = 'btc3205';
        try{
        $this->conn = new PDO("mysql:host=$dbserver;dbname=$dbname", DB_USER, DB_PASS);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            echo"Error Occured: "+$e->getMessage();
        }
        
    }

    public function closeDatabase(){
        $this->conn=null;
    }
}


?>