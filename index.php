<?php
    //connect functions for work with database and main functions
    require_once "functions/db_create_use.php";
    require_once "functions/main_functions.php";

    //define active nav-link
    $navItem[0] = 'active';
    $navItem[1] = '';
    $navItem[2] = '';
?>

<!doctype html>
<html lang="en">
<head>

    <!-- Required meta tags includes and links-->
    <?php require_once "blocks/head.php" ?>

</head>
<body>

    <!-- main header with navigation bar -->
    <?php require_once "blocks/header.php" ?>

    <div id="main-content-part" class="container-fluid py-4">
        <div class="d-flex flex-wrap">
            <div class="col-md-4 col-lg-3 col-xl-2 pb-4">

                <!--main-menu-->
                <?php
                    require_once "blocks/menu_main.php";
//                    we get all id_subcategories in main_menu.php (var $subcategories)
                ?>

            </div>

<!--            all our football articles are here-->
            <div class="col-md-8 col-lg-9 col-xl-7 pb-4">

                <?php
                    require_once 'functions/FootballArticle.php';

//                    check we have get['cat'] or not
                    $cat_bool = false;
                    if ($_GET['cat']) {
                        $cat = htmlspecialchars($_GET['cat']);
                        foreach ($subcategories as $subcategory) {
                            if ($subcategory['id_subcategory'] === $cat) {
                                $cat_bool = true;
                            }
                        }
                    }

                    $db = connectDB( $config['db']['server'],
                        $config['db']['name'],
                        $config['db']['username'],
                        $config['db']['password'] );

                    if ($cat_bool === true) {
                        //get last 8 football articles of this category
                        $query = $db->prepare(" SELECT * FROM `football_articles` 
                                                          WHERE `id_subcategory`=:cat 
                                                          ORDER BY `date` DESC, `id` DESC LIMIT 0, 8");
                        $params = array ('cat' => $cat);
                        $query->execute($params);
                        $football_articles = $query->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        //get last 8 football articles
                        $query = $db->query(" SELECT * FROM `football_articles` 
                                                        ORDER BY `date` DESC, `id` DESC LIMIT 0, 8 ");
                        $football_articles = $query->fetchAll(PDO::FETCH_ASSOC);
                    }

                    closeDB();

                    //show all our articles on the page if we have it
                    if (!($football_articles)) {
                        showError('we have not articles of this category!');
                    } else {
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
                    }
                ?>

            </div>

<!--            all our football news are here-->
            <div class="col-md-6 col-xl-3 pb-4">
                <h4 class="text-center w-75 mx-4 mx-sm-auto mx-xl-0 mb-4">The Latest Football News</h4>

                <?php
                    require_once 'functions/FootballItem.php';

                    $db = connectDB( $config['db']['server'],
                        $config['db']['name'],
                        $config['db']['username'],
                        $config['db']['password'] );

                    if ($cat_bool === true) {
                        //get last 20 football news of this category
                        $query = $db->prepare(" SELECT * FROM `football_news` 
                                                          WHERE `id_subcategory`=:cat
                                                          ORDER BY `date` DESC, `id` DESC LIMIT 0, 20");
                        $params = array ('cat' => $cat);
                        $query->execute($params);
                        $football_news = $query->fetchAll(PDO::FETCH_ASSOC);
                    }

                    if (!($football_news)) {
                        //get last 20 football news
                        $query = $db->query(" SELECT * FROM `football_news` 
                                                    ORDER BY `date` DESC, `id` DESC LIMIT 0, 20 ");
                        $football_news = $query->fetchAll(PDO::FETCH_ASSOC);
                    }

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
                <?php require_once "blocks/advertizing_cards.php" ?>

            </div>
        </div>
    </div>

    <!-- footer -->
    <?php require_once "blocks/footer.php" ?>

    <script src="/js/main_jquery.js"></script>
    <script src="/js/main_js.js"></script>
    <script src="/js/index_js.js"></script>
</body>
</html>
