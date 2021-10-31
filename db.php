<?php
$db_connection = mysqli_connect("localhost", "id17830055_alex09121999", "Alex09-poletaev", "id17830055_test_bd");

if($db_connection == false){
    echo 'Не удалось подключиться к базе данных<br>';
    echo mysqli_connect_error();
    exit();
}
