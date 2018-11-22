<?php
    //connect functions for work with database and main functions
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/main_functions.php';
    require_once "$address_connect";

    //define active nav-link
    $navItem[0] = 'active';
    $navItem[1] = '';
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
                ?>

            </div>

            <div class="col-md-8 col-lg-9 col-xl-7 pb-4">

                <?php
                    //connect SearchItem class
                    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/SearchItem.php';
                    require_once "$address_connect";

                    $db = connectDB( $config['db']['server'],
                        $config['db']['name'],
                        $config['db']['username'],
                        $config['db']['password'] );

                    $search_item = new SearchItem($_GET['search'], $db);

                    $search_item->writeItems();

                    closeDB();
                ?>

            </div>

            <!--            all our football news are here-->
            <div class="col-md-6 col-xl-3 pb-4">
                <h4 class="text-center w-75 mx-0 mx-sm-auto mx-xl-0 mb-4">The Latest Football News</h4>

                <?php
                    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/FootballItem.php';
                    require_once "$address_connect";
                    // use \FootballNews\FootballItem as FootballItem;

                    $db = connectDB( $config['db']['server'],
                        $config['db']['name'],
                        $config['db']['username'],
                        $config['db']['password'] );

                    //get last 10 football news
                    $query = $db->query(" SELECT * FROM `football_news`
                                                            ORDER BY `date` DESC, `id` DESC LIMIT 0, 10 ");
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
    <script src="/js/index_js.js"></script>
</body>
</html>


