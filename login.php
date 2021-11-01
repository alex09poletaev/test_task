<?php
require_once 'checks.php';
require_once 'checked.php';
require_once 'log_in.php';
require_once 'db.php';

$data = $_POST;

$isLogged = new CheckIsLogged;
if($isLogged->isLogged()){
    header('Location: index.php');
}

if(isset($data['submit'])){
    $CheckIs = "CheckIs";
    $keys = array_keys($data);
    $arr['db_connection'] = $db_connection;
    for($i = 0; $i < count($keys)-1; $i++){
        $arr["$keys[$i]"] = $data[$keys[$i]];
        $check = $CheckIs.$keys[$i];
        $isCheked = new Checked(new $check);
        $isCheked->checked($arr);
    }
    $password = $data['password'];
    $login = $data['login'];
    $isExist = new Checked(new CheckIsExist);
    $isExist->checked($arr);
    if($_SESSION['signup_errors'] == ""){
        $info = new LogIn;
        if($info->log_in($arr)){
            header('Location: index.php');
        }
    }
    else{
        echo '<div style="color:red;">'.$_SESSION['signup_errors'].'</div>';
        $_SESSION['signup_errors'] = "";
    }
}


?>
<form action="login.php" method="POST">
    <p>
        <p>Login or Email</p>
        <input type="text" name="login" placeholder="email or login" required value="<?=@$data['login'];?>">
    </p>
    <p>
        <p>Password</p>
        <input type="password" name="password" required>
    </p>
    <p>
        <input type="submit" name="submit">
    </p>
    <p>
        <a href="index.php">Back</a>
    </p>
    <p>
        <a href="signup.php">Sign up</a>
    </p>
</form>




