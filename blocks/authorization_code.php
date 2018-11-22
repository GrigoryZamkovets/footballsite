<?php
    session_start();

    //connect functions for work with database
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";

    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/AdminUser.php';
    require_once "$address_connect";
    use \AdminFootballDB\AdminUser as AdminUser;

    // get and cheak our variables
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $password1 = htmlspecialchars(trim($_POST['password1']));
    $password2 = htmlspecialchars(trim($_POST['password2']));

    if ( $username == '' || ($password == '' && $password1 == '') ) {
        echo 'fill all necessary fields!';
        exit();
    }

    //check our username in database
    $db = connectDB( $config['db']['server'],
        $config['db']['name'],
        $config['db']['username'],
        $config['db']['password'] );

    $admin_user = new AdminUser($username, $password, $password1, $db);

    $check_user = $admin_user->checkUser();

    if ( $check_user instanceof Exception ) {
        echo 'Выброшено исключение: ' . $check_user->getMessage();
        exit();
    }

    if ( !$check_user ) {
        echo "this username does not exist";
        exit();
    }

    if ( !$admin_user->checkEnterPurpose() ) {
        $admin_user->changePassword();
    } else {
        $result = $admin_user->enterAdmin();
        echo $result;
    }

    closeDB();

    //create session if it is neccesary
    if ($result === 'correct username and password') {
        $_SESSION['logged_user'] = $username;
    }








