<?php
require_once 'checks.php';
require_once 'db.php';

$isLogged = new CheckIsLogged;
if($isLogged->isLogged()):
    $id = $_SESSION['user']['user_id'];
    echo 'Email: '. $_SESSION['user']['email'] .'<br>Name: '. $_SESSION['user']['name'] .'<br>'; ?>
    <a href="logout.php">Log out</a><br>
<?php else: ?>
    <a href="login.php">Log in</a><br>
    <a href="signup.php">Sign up</a>
<?php endif; ?>

