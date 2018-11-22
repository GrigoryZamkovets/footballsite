<?php

    //connect functions for work with database and our classes
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/FootballArticleWriter.php';
    require_once "$address_connect";
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/FootballItemWriter.php';
    require_once "$address_connect";

    $purpose = $_POST['purpose'];

    if ($purpose === 'article') {
        $select_cat = htmlspecialchars(trim($_POST['selectCat']));
        $title = htmlspecialchars(trim($_POST['title']));
        $text = htmlspecialchars(trim($_POST['text']));
        if ( is_array($_FILES['img_file']) ) {
            $image = $_FILES['img_file'];
        } else {
            $image = false;
        }

        $db = connectDB( $config['db']['server'],
            $config['db']['name'],
            $config['db']['username'],
            $config['db']['password'] );

        $article = new FootballArticleWriter($select_cat, $title, $text, $image, $db);

        if ( $article->checkVariables() ) {
            $article->checkImage();
            $publish = $article->publish();

            if ( $publish === true ) {
                echo 'your article has been published!';
            } else {
                echo 'Выброшено исключение: ' . $publish->getMessage();
            }
        }

        closeDB();

    } else {
        $select_cat = htmlspecialchars(trim($_POST['selectCat']));
        $text = htmlspecialchars(trim($_POST['text']));
        $email_bool = $_POST['email_bool'];

        $db = connectDB( $config['db']['server'],
            $config['db']['name'],
            $config['db']['username'],
            $config['db']['password'] );

        $news_item = new FootballItemWriter($select_cat, $text, $db);

        if ( $news_item->checkVariables() ) {
            $publish = $news_item->publish();
        }

        if ( $publish === true ) {
            if ( $email_bool == true ) {
                if ( $news_item->sendNews() ) {
                    echo 'your news item has been published and has been sent to subscribers!';
                } else {
                    echo 'your news item has been published but has been not sent to subscribers!';
                }
            } else {
                echo 'your news item has been published!';
            }
        } else {
            echo 'Выброшено исключение: ' . $publish->getMessage();
        }

        closeDB();
    }










