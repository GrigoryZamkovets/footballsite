<?php
    //connect functions for work with database
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";

    //define active nav-link
    $navItem[0] = '';
    $navItem[1] = 'active';
    $navItem[2] = '';
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
                    //  we get all id_subcategories in main_menu.php (var $subcategories)
                ?>

            </div>

            <!--            our football item is here-->
            <div class="contacts-info col-md-8 col-lg-9 col-xl-7 pb-4">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h4 class="mt-4 mb-2 mb-sm-4 text-center">Block To Communicate With Our Site</h4>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8 col-lg-6">
                        <form action="" role="form">
                            <div class="form-group mt-2 mb-4">
                                <input type="text" class="form-control" id="name"
                                       placeholder="your nickname" data-toggle="tooltip"
                                       title="enter your name!" data-placement="top">
                            </div>

                            <div class="form-group mb-4">
                                <input type="email" class="form-control" id="email"
                                       placeholder="your email" data-toggle="tooltip"
                                       title="enter correct email!" data-placement="top">
                            </div>

                            <div class="form-group mb-4">
                                <input type="text" class="form-control" id="subject"
                                       placeholder="subject" data-toggle="tooltip"
                                       title="enter subject of your message!" data-placement="top">
                            </div>

                            <div class="form-group mb-4">
                                <textarea class="form-control" id="message" placeholder="message"
                                          rows="5" style="resize: none;" data-toggle="tooltip"
                                          title="enter content of your message!" data-placement="top"></textarea>
                            </div>

                            <button type="button" id="send" class="btn btn-success mb-2">send message</button>
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

                    //get last 20 football news
                    $query = $db->query(" SELECT * FROM `football_news`
                                                            ORDER BY `date` DESC, `id` DESC LIMIT 0, 20 ");
                    $football_news = $query->fetchAll(PDO::FETCH_ASSOC);

                    closeDB();

                    //show all our news on the page
                    foreach ($football_news as $football_item) {
                        $item = new FootballItem($football_item, $cat_bool, $subcategories);
                        $item->writeShortItem();
                    }
                ?>

            </div>

            <div class="d-flex flex-wrap col-md-6 col-xl-12 justify-content-center">

                <!-- advertizing cards-->
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
    <script src="/js/contacts_jquery.js"></script>
</body>
</html>
