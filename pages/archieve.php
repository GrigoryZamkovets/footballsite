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

            <div class="col-md-8 col-lg-9 col-xl-7 pt-2 pb-4">

                <?php
                    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/FootballArticle.php';
                    require_once "$address_connect";

                    //set count of articles per page and number of current page
                    $per_page = 5;
                    $page = 1;
                    if (isset($_GET['page'])) {
                        $page = htmlspecialchars($_GET['page']);
                        $page = intval($page);
                    }

                    $db = connectDB( $config['db']['server'],
                        $config['db']['name'],
                        $config['db']['username'],
                        $config['db']['password'] );

                    // get count of our articles
                    $query = $db->query("SELECT COUNT(`id`) AS `total_count` FROM `football_articles` ");
                    $total_count = $query->fetch();
                    $total_count = $total_count['total_count'];

                    //definition count of pages and offset for current page
                    $total_pages = ceil($total_count/$per_page);
                    if ($page < 1 || $page > $total_pages) {
                        $page = 1;
                    }
                    $offset = $per_page * $page - $per_page;

                    //get all our football articles
                    $query = $db->query(" SELECT * FROM `football_articles` 
                                                    ORDER BY `date` DESC LIMIT $offset, $per_page");
                    $football_articles = $query->fetchAll();

                    closeDB();

                    //show all our articles on the page if we have it
                    if ( !($football_articles) ) {
                        showError('we have problems with this page! Try to go to this website later!');
                    } else {
                        //create paginator above
                        writeArchievePaginator($page, $total_pages);

                        $count_articles = 1;
                        foreach ($football_articles as $football_article) {
                            $article = new FootballArticle($football_article, $cat_bool);
                            if ($count_articles % 2 == 1) {
                                $article->writeShortOddArticle();
                            } else {
                                $article->writeShortEvenArticle();
                            }
                            $count_articles++;
                        }

                        //create paginator below
                        writeArchievePaginator($page, $total_pages);
                    }

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



