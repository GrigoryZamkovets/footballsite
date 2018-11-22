<?php
    $to = 'Green5050555@mail.ru';
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if ($name == '' || $email == '' || $subject == '' || $message == '') {
        echo 'fill all fields!';
        exit;
    }

    // send our message
    $subject = "=?utf-8?B?".base64_encode($subject)."?=";
    $headers = "From: $email\r\nReply-to: $email\r\n\Content-type: 
        text/plain; charset=utf-8\r\n";
    if (mail($to, $subject, $message, $headers))
        echo 'your message has been sent!';
    else
        echo 'your message has not been sent!check your data!';