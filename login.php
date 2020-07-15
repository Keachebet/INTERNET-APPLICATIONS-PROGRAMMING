<?php
include_once 'DBConnector.php';
include_once 'user.php';

$con = new DBConnector;

if(isset($_POST['btn-login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $instance = User::create();
    $instance->setPassword($password);
    $instance->setUsername($username);
    echo"Hello";


    if($instance->isPasswordCorrect()){
        $instance->login();
        $con->closeDatabase();
        $instance->createUserSession();
    }else{
        $con->closeDatabase();
        header("Location:lab1.php");
    }
    }else{
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script type="text/javascript" src="validate.js"></script>
    <link rel="stylesheet" type="text/css" href="validate.css">
</head>
<body>
    
<form method="post" name="login" id="login" action="<?php echo $_SERVER['PHP_SELF']?>">
        <table align="center">
            <tr>
                <td><input type="text" name="username" placeholder="Username" required/></td>
            </tr>
            <tr>
                <td><input type="text" name="password" placeholder="Password" required/></td>
            </tr>
            <tr>
                <td><button type="submit" name="btn-login"><strong>LOGIN</strong></button></td>
            </tr>
        </table>
    </form>


</body>
</html>