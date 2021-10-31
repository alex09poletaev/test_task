<?php
session_start();
require_once 'IChecker.php';

class CheckIsPassword implements IChecker{
    private $pass_error = 'Password must contain at least 8 but not more 20 Latin letters, numbers and underscore <br>';
    
    public function isChecked($arr = array('password' => '')){
        if(!preg_match('(\w{8,20})', $arr['password'])){
            $_SESSION['signup_errors'] .= $this->pass_error;
            return false;
        }
        return true;
    }
}

class CheckIsLogin implements IChecker{
    private $login_error = 'Login must contain only Latin letters, numbers and underscore <br>';

    public function isChecked($arr = array('login' => '')){
        if(!preg_match('(\w{1,25})', $arr['login'])){
            $_SESSION['signup_errors'] .= $this->login_error;
            return false;
        }
        return true;
    }
}

class CheckIsName implements IChecker{
    private $name_error = 'Name must contain only Latin letters <br>';
            
    public function isChecked($arr = array('name' => '')){
        if(!preg_match('([A-Z][a-z]{1,35})', ucfirst($arr['name']))){
            $_SESSION['signup_errors'] .= $this->name_error;
            return false;
        }
        return true;
    }
}

class CheckIsLogged {
    
    public function isLogged(){
        if(isset($_SESSION['user'])){
            return true;
        }
        else{
            return false;
        }
    }
}

class CheckIsUniqe implements IChecker{
    private $mlsql = "SELECT `email`, `login` FROM users";
    private $uniqe_error = 'Mail and login must be uniqe <br>';
    
    public function isChecked($arr = array('uniqe' => "", 'db_connection' => "")){
        include_once 'db.php';
        $uniqe = $arr['uniqe'];
        $db_connection = $arr['db_connection'];
        $mlresult = mysqli_query($db_connection, $this->mlsql);
        while($ml = mysqli_fetch_assoc($mlresult)){
            if($uniqe == $ml['email'] || $uniqe == $ml['login']){
                if(!isset($arr['flag'])){
                    $_SESSION['signup_errors'] .= $this->uniqe_error;
                }
                return false;
            }
        }
        return true;
    }
}

class CheckIsExist implements IChecker{
    private $existance_error = "Some fields are wrong <br>";
    
    public function isChecked($arr = array('login' => "", 'password' => "", 'db_connection' => "")){
        $login = $arr['login'];
        $password = $arr['password'];
        $db_connection = $arr['db_connection'];
        $CheckIsUniqe = new CheckIsUniqe();
        $flag = $CheckIsUniqe->isChecked($arr = array('uniqe' => $login, 'db_connection' => $db_connection, 'flag' => "login"));
        if(!$flag){
            $pass_query = "SELECT `password` FROM users WHERE `login` = '$login' OR `email` = '$login';";
            $pass = mysqli_fetch_assoc(mysqli_query($db_connection, $pass_query));
            if($password != $pass['password']){
                $_SESSION['signup_errors'] .= $this->existance_error;
                return false;
            }
            else{
                return true;
            }
        }
        else{
            $_SESSION['signup_errors'] .= $this->existance_error;
            return false;
        }
    }
}



//function formIsEmpty($form){
//    if(trim($form) == ""){
//        $_SESSION['signup_errors'] .= 'Fill all fields. <br>';
//        return true;
//    }
//}


//function checkAgreement($agree){
//    if(!isset($agree)){
//        $_SESSION['signup_errors'] .= 'Check agreement <br>';
//    }
//}
