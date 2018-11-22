<?php
    session_start();

    if ( $_SESSION['logged_user'] ) {
        header('Location: admin.php');
    }

    //connect functions for work with database
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";

    //define active nav-link
    $navItem[0] = '';
    $navItem[1] = '';
    $navItem[2] = 'active';
?>

<!doctype html>
<html lang="en">
<head>

    <!-- Required meta tags includes and links-->
    <?php
        $address_connect = $_SERVER['DOCUMENT_ROOT'].'/blocks/head.php';
        require_once "$address_connect";
    ?>

</head>
<body>

    <!-- main header with navigation bar -->
    <?php
        $address_connect = $_SERVER['DOCUMENT_ROOT'].'/blocks/header.php';
        require_once "$address_connect";
    ?>

    <div id="main-content-part" class="container-fluid py-4">
        <div class="d-flex flex-wrap">
            <div class="col-md-4 col-lg-3 col-xl-2 pb-4">

                <!--main-menu-->
                <?php
                    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/blocks/menu_main.php';
                    require_once "$address_connect";
                    // we get all id_subcategories in main_menu.php (var $subcategories)
                ?>

            </div>

            <!--            we can create football news and articles here-->
            <div class="authorization-form col-md-8 col-lg-9 col-xl-7 pb-4">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h4 class="mt-4 mb-2 mb-sm-4 text-center">Authorization Form</h4>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8 col-lg-6">

                        <!-- form with vue js component-->
                        <form action="" role="form" id="app-authorization-form">
                            <div class="form-group mt-2 mb-4">
                                <input type="text" class="form-control" id="username" name="username"
                                       placeholder="enter your username">
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="enter your password">
                            </div>

                            <div class="custom-control custom-checkbox mb-4">
                                <input v-on:click ="changePassword" type="checkbox"
                                                    class="custom-control-input mt-2"
                                                    id="change-password" name="change-password">
                                <label class="custom-control-label" for="change-password">
                                    Do you want to change your password?
                                </label>
                            </div>

                            <div class="form-group mb-4" v-show="show">
                                <input type="password" class="form-control" id="password1" name="password1"
                                       placeholder="enter your new password">
                            </div>

                            <div class="form-group mb-4" v-show="show">
                                <input type="password" class="form-control" id="password2" name="password2"
                                       placeholder="repeat your new password">
                            </div>

                            <button type="button" id="send" name="send" class="btn btn-success mb-2">
                                enter admin
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!--            all our football news are here-->
            <div class="col-md-6 col-xl-3 pb-4">
                <h4 class="text-center w-75 mx-0 mx-sm-auto mx-xl-0 mb-4">The Latest Football News</h4>

                <?php
                    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/FootballItem.php';
                    require_once "$address_connect";

                    $db = connectDB( $config['db']['server'],
                    $config['db']['name'],
                    $config['db']['username'],
                    $config['db']['password'] );

                    $cat_bool = false;
                    //get last 10 football news
                    $query = $db->query(" SELECT * FROM `football_news`
                                                            ORDER BY `date` DESC, `id` DESC LIMIT 0, 10 ");
                    $football_news = $query->fetchAll(PDO::FETCH_ASSOC);

                    closeDB();

                    //show all our articles on the page
                    foreach ($football_news as $football_item) {
                        $item = new FootballItem($football_item, $cat_bool, $subcategories);
                        $item->writeShortItem();
                    }
                ?>

            </div>

            <div class="d-flex flex-wrap col-md-6 col-xl-12 justify-content-center">

                <!--advertizing cards-->
                <?php
                    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/blocks/advertizing_cards.php';
                    require_once "$address_connect";
                ?>

            </div>
        </div>
    </div>

    <!-- footer -->
    <?php
        $address_connect = $_SERVER['DOCUMENT_ROOT'].'/blocks/footer.php';
        require_once "$address_connect";
    ?>

    <script src="/js/main_jquery.js"></script>
    <script src="/js/main_js.js"></script>
    <script src="/js/authorization_jquery_vuejs.js"></script>
</body>
</html>
