<?php
    $search = htmlspecialchars($_POST['search']);

    if ( $search == '' ) {
        echo "enter correct search words!";
    } else {
        echo "/pages/search_result.php?search=$search";
    }