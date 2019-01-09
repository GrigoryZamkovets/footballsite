<?php
    session_start();

    //logout button
    if ( isset($_POST['logout']) ) {
        unset($_SESSION['logged_user']);

        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
    }

    // check if we have reduction possibility
    if ( $_SESSION['logged_user'] ) {
        $reduct_bool = true;
    } else {
        $reduct_bool = false;
    }

    //connect functions for work with database
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/main_functions.php';
    require_once "$address_connect";

    //define active nav-link
    $navItem[0] = 'active';
    $navItem[1] = '';
    $navItem[2] = '';

    $id = htmlspecialchars($_GET['id']);

    if ($_GET['catbool'] == 1) {
        $cat_bool = true;
    } else {
        $cat_bool = false;
    }
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

            <!--            our football article is here-->
            <div class="col-md-8 col-lg-9 col-xl-7 pb-4">
                <?php if ( $reduct_bool === true ): ?>
                    <div class="logout-btn row justify-content-center mb-4">
                        <span class="mr-4 text-center">
                            Welcome to Our Football News, <?=ucfirst($_SESSION['logged_user']);?> !
                        </span>

                        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" role="form">
                            <button type="submit" id="logout" name="logout" class="btn-sm btn-success">
                                logout
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php
                    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/FootballArticle.php';
                    require_once "$address_connect";

                    $db = connectDB( $config['db']['server'],
                        $config['db']['name'],
                        $config['db']['username'],
                        $config['db']['password'] );

                    //get our football article of this category
                    $query = $db->prepare(" SELECT * FROM `football_articles` WHERE `id`=:id ");
                    $params = array ('id' => $id);
                    $query->execute($params);
                    $football_article = $query->fetch(PDO::FETCH_ASSOC);

                    closeDB();

                    if (!($football_article)) {
                        showError('we have not this article!');
                    } else {
                        $article = new FootballArticle($football_article, $cat_bool);
                        $article->writeFullText();
                    }

                ?>



            </div>

            <!--            all our football news are here-->
            <div class="col-md-6 col-xl-3 pb-4">
                <h4 class="text-center w-75 mx-0 mx-sm-auto mx-xl-0 mb-4">The Latest Football News</h4>

                <?php
                    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/FootballItem.php';
                    require_once "$address_connect";
//                    use \FootballNews\FootballItem as FootballItem;

                    $db = connectDB( $config['db']['server'],
                        $config['db']['name'],
                        $config['db']['username'],
                        $config['db']['password'] );

                    if ($cat_bool === true) {
                        //get last 20 football news of this category
                        $query = $db->prepare(" SELECT * FROM `football_news` 
                                                                  WHERE `id_subcategory`=:cat
                                                                  ORDER BY `date` DESC, `id` DESC LIMIT 0, 20");
                        $params = array ('cat' => $football_article['id_subcategory']);
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
    <script src="/js/article_js.js"></script>
</body>
</html>

