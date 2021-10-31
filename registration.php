<?php

class Registration{
    private $user_sql = "SELECT `id` FROM `users` WHERE `email` = '";
    
    public function registr($arr = array('email' => '', 'login' => '', 'name' => '', 'password' => '', 'bdate' => '', 'country' => '', 'registry_date' => '')){
        $email = $arr['email'];
        $login = $arr['login'];
        $name = $arr['name'];
        $password = $arr['password'];
        $bdate = $arr['bdate'];
        $country = $arr['country'];
        $registry_date = $arr['registry_date'];
        $result = mysqli_query($arr['db_connection'], "INSERT INTO `users` (`email`, `login`, `name`, `password`, `birth_date`, `country_id`, `registration_date`) VALUES ('$email', '$login', '$name', '$password', '$bdate', '$country', '$registry_date');");
        $user_info = mysqli_fetch_assoc(mysqli_query($arr['db_connection'], $this->user_sql. $email."'"));
        if(isset($user_info)){
            $_SESSION['user'] = [
                "user_id" => $user_info['id'],
                "email" => $email,
                "login" => $login,
                "name" => $name,
                "bdate" => $bdate,
                "country" => $country,
                "registry_date" => $registry_date
            ];
            return true;
        }
        else{
            return false;
        }
    }
}