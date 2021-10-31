<?php

class LogIn{
    private $login_sql = "SELECT * FROM `users` WHERE `login` = '";
    private $login_sql1 = "OR `email` = '";
    
    public function log_in($arr = array('login' => "", 'db_connection' => '')) {
        $user_info = mysqli_fetch_assoc(mysqli_query($arr['db_connection'], $this->login_sql. $arr['login']."' ".$this->login_sql1. $arr['login']."'"));
        if(isset($user_info)){
            $_SESSION['user'] = [
                "user_id" => $user_info['id'],
                "email" => $user_info['email'],
                "login" => $user_info['login'],
                "name" => $user_info['name'],
                "bdate" => $user_info['birth_date'],
                "country" => $user_info['country_id'],
                "registry_date" => $user_info['registration_date']
            ];
            return true;
        }
        else{
            return false;
        }
    }
}
