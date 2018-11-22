<?php
    //connect functions for work with database
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";

    $email = htmlspecialchars(trim($_POST['email']));

    if ($email == '') {
        echo 'enter correct email!';
    } else {
        try {
            $db = connectDB( $config['db']['server'],
                $config['db']['name'],
                $config['db']['username'],
                $config['db']['password'] );

            $query = $db->query("SELECT * FROM `subscribe_email`");
            $subscribers = $query->FetchAll();
        } catch ( Exception $e ) {
            echo 'error message' . $e->getMessage();
            exit();
        }

        foreach ($subscribers as $subscriber) {
            if ( $subscriber['email'] == $email ) {
                echo 'this email is already our subscriber!';
                exit();
            }
        }

        try {
            $query = $db->prepare(" INSERT INTO `subscribe_email` 
                                            SET `email`=:email ");
            $params = array ('email' =>$email);
            $query->execute($params);
            echo 'you are our new subscriber!';
        } catch ( Exception $e ) {
            echo 'error message' . $e->getMessage();
        }

        closeDB();
    }