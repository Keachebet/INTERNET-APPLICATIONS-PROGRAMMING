<?php
include "Crud.php";
include "authenticate.php";
include_once 'DBConnector.php';
class User implements Crud{
    private $user_id;
    private $first_name;
    private $last_name;
    private $city_name;
    private $utc_timestamp;
    private $offset;
    private $username;
    private $password;
    private $profilePic;



    function __construct($first_name,$last_name,$city_name,$username,
    $password,$profilePic,$utc_timestamp,$offset)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->city_name = $city_name;
        $this->username = $username;
        $this->password = $password;
        $this->profilePic = $profilePic;
        $this->utc_timestamp = $utc_timestamp;
        $this->offset = $offset;
    }


    public static function create(){
        $reflection = new ReflectionClass("User");
        $instance = $reflection->newInstanceWithoutConstructor();
        return $instance;
    }
    public function setUsername($username){
        $this->username = $username;
    }
    public function getUsername(){
        return $this->username;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getPassword(){
        return $this->password;
    }

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function getUserId(){
        return $this->user_id;
    }
    public function setUtc_timestamp($utc_timestamp){
        $this->utc_timestamp = $utc_timestamp;
    }

    public function getUtc_timestamp(){
        return $this->utc_timestamp;
    }
    public function setOffset($offset){
        $this->offset = $offset;
    }

    public function getOffset(){
        return $this->offset;
    }
    public function isUserExist($uname){
        $con = new DBConnector;
        $mysqli = $con->conn;
        $exist = true;
        $stmt = $mysqli->prepare("SELECT * FROM user where username=?");
        $stmt->execute(array($uname));
        if(empty($stmt->fetch())){
            $exist=false;
        }
        
        return $exist;
    }

    public function save(){
        $con = new DBConnector;
        $connection = $con->conn;
        $found = false;

        $fn = $this->first_name;
        $ln = $this->last_name;
        $city = $this->city_name;
        $uname = $this->username;
        $this->hashPassword();
        $pass = $this->password;
        $pic = $this->profilePic;
        $utc = $this->utc_timestamp;
        $offset = $this->offset;
        try{
        $stmt = $connection->prepare("INSERT INTO user(first_name,last_name,
        user_city,username,password,file,utc_stamp,offset)
         VALUES (?,?,?,?,?,?,?,?)");

        $stmt->execute(array($fn,$ln,$city,$uname,$pass,$pic,$utc,$offset));
        $found = true;
        $stmt = null;
        }catch(Exception $e){
            echo"An error occured";
        }
        return $found;
    }
    public static function readAll(){
        $con = new DBConnector;
        $mysqli = $con->conn;
        try{
        $stmt = $mysqli->prepare("SELECT * FROM user");
        $stmt->execute();
        $res = $stmt->fetchAll();
        $stmt=null;
        }catch(Exception $e){
            echo"An error occured: ".$e;
        }
        $con->closeDatabase();
        return $res;
    }
    public function readUnique(){
        return null;
    }public function search(){
        return null;
    }public function update(){
        return null;
    }public function removeOne(){
        return null;
    }public function removeAll(){
        return null;
    }
    public function validateForm(){
        //Return true if the values are not null
        $fn = $this->first_name;
        $ln = $this->last_name;
        $city = $this->city_name;

        if($fn ==""||$ln ==""||$city ==""){
            return false;
        }
        return true;
    }
    public function createFormErrorSessions(){
        session_start();
        $_SESSION['form_errors'] = "All fields are required";
    }
        public function hashPassword(){
            $this->password = password_hash($this->password,PASSWORD_DEFAULT);

        }
        public function isPasswordCorrect(){
            $con = new DBConnector;
            $mysqli = $con->conn;
            $found = false;

            try{
                $stmt = $mysqli->prepare("SELECT password,username FROM user");
                $stmt->execute();
                $result = $stmt->fetchAll();
                 // result/output data of each row
                 foreach($result as $row){ 
                    if(password_verify($this->getPassword(),$row['password']) && $this->getUsername()==$row['username']){
                        $found = true;
                    }
                       }
                $stmt=null;
                }catch(Exception $e){
                    echo"An error occured: ".$e;
                }
                    $con->closeDatabase();
                    return $found;
                }
        public function login(){
            if($this->isPasswordCorrect()){
                header("Location:private_page.php");
            }
        }
        public function createUserSession(){
            session_start();
            $_SESSION['username'] = $this->getUsername();
        }
        public function logout(){
            session_start();
            unset($_SESSION['username']);
            session_destroy();
            header("Location:lab1.php");
        }
}


?>