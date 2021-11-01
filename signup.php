<?php

require_once 'db.php';
require_once 'checks.php';
require_once 'checked.php';
require_once 'registration.php';
$data = $_POST;
$arr1 = $data;
$CheckIs = "CheckIs";
$isLogged = new CheckIsLogged;
if($isLogged->isLogged()){
    header('Location: index.php');
}

$select = "SELECT * FROM `country` ORDER BY `name` ASC";
$countries = mysqli_query($db_connection, $select);

if(isset($data['signup'])){
    $keys = array_keys($data);
    $arr['db_connection'] = $db_connection;
    for($i = 0; $i < count($keys); $i++){
        $arr["$keys[$i]"] = $data[$keys[$i]];
    }
    for($i = 1; $i < count($keys)-4; $i++){
        $check = $CheckIs.$keys[$i];
        $isCheked = new Checked(new $check);
        $isCheked->checked($arr);
    }
    
    $uniqe_login = array('uniqe' => $data['login'], 'db_connection' => $db_connection);
    $uniqe_email = array('uniqe' => $data['email'], 'db_connection' => $db_connection);
    $isUniqe = new Checked(new CheckIsUniqe);
    if($isUniqe->checked($uniqe_login)){
        $isUniqe->checked($uniqe_email);
    }
    
    if(!isset($_SESSION['signup_errors']) || $_SESSION['signup_errors'] == ""){
        $arr['registry_date'] = time();
        $registry = new Registration;
        $registry->registr($arr);
        header('Location: index.php');
    }
    else{
        echo '<div style="color:red;">'.$_SESSION['signup_errors'].'</div>';
        $_SESSION['signup_errors'] = "";
    }
}
?>

<form action="/signup.php" method="POST">
    <p>
        <p><b>Your Email</b>:</p>
        <input type="email" name="email" required value="<?php echo @$data['email']; ?>">
    </p>
    <p>
        <p><b>Your login</b>:</p>
        <input type="text" name="login" required value="<?php echo @$data['login']; ?>">
    </p>
    <p>
        <p><b>Your name</b>:</p>
        <input type="text" name="name" required value="<?php echo @$data['name']; ?>">
    </p>
    <p>
        <p><b>Your password</b>:</p>
        <input type="password" name="password" required>
    </p>
    <p>
        <p><b>Your birth date</b>:</p>
        <input type="date" name="bdate" placeholder="dd-mm-yyyy" required value="<?php echo @$data['bdate']; ?>" min="1900-01-01" max="2010-01-01">
    </p>
    <p>
        <p><b>Your country</b>:</p>
        <select style="width: 170px" name="country" required value="<?php echo @$data['country'];?>">
            <?php while ($country = mysqli_fetch_assoc($countries)):
                if($country['id'] == @$data['country']):?>
                    <option selected="" value="<?=$country['id'];?>"><?=@$country['name'];?></option>
                <?php else: ?>
                    <option value="<?=$country['id'];?>"><?=@$country['name'];?></option>
                <?php endif; ?>
            <?php endwhile; ?>
        </select>
    </p>
    <p>
        <input type="checkbox" name="agree" required> I agree with terms and conditions.
    </p>
    <p>
        <button type="submit" name="signup" value="ok">Sign up</button>
    </p>
</form>