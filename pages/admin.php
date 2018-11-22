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

    if ( !($_SESSION['logged_user']) ) {
        header('Location: authorization.php');
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
                    //  we get all id_subcategories in main_menu.php (var $subcategories)
                ?>

            </div>

            <!-- we can create football news and articles here -->
            <div class="admin-form col-md-8 col-lg-9 col-xl-7 pb-4">
                <div class="row justify-content-center mb-4">
                    <span class="mr-4 mb-4 text-center">
                        Welcome to Administrate Page, <?=ucfirst($_SESSION['logged_user']);?> !
                    </span>

                    <form action="/pages/admin.php" method="post" role="form">
                        <button type="submit" id="logout" name="logout" class="btn-sm btn-success mb-4">
                            logout
                        </button>
                    </form>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12">
                        <h4 class="my-2 mb-sm-4 text-center">Admin Block</h4>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8 col-lg-6">
                        <form action="" role="form" id="app-admin-form">
                            <div class="form-group">
                                <div class="font-weight-bold my-2">Select What Type of Item You Want to Publish:</div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-on:change = "checkCategory"
                                           name="footballRadio" id="footballArticle" value="footballArticle" checked>
                                    <label class="form-check-label" for="footballArticle">
                                        Publish Football Article
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-on:change = "checkCategory"
                                           name="footballRadio" id="footballNews" value="footballNews">
                                    <label class="form-check-label" for="footballNews">
                                        Publish Football News
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mt-4" v-show="show">
                                <div class="font-weight-bold">Check Category of Your Article:</div>
                                <select class="custom-select mt-2" id="select-id-article"
                                        style="color: rgba(0, 0, 0, 0.6);">
                                    <option value="0" selected>open this select menu</option>
                                    <option style="color: rgba(0, 0, 0, 0.6);"
                                            v-for="category in categoriesArticles"
                                            v-bind:value="category.id_subcategory">
                                        {{ category.name_subcategory | lowercase }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group mt-4" v-show="!show">
                                <div class="font-weight-bold">Check Category of Your News Item:</div>
                                <select class="custom-select mt-2" id="select-id-news"
                                        style="color: rgba(0, 0, 0, 0.6);">
                                    <option value="0" selected>open this select menu</option>
                                    <option style="color: rgba(0, 0, 0, 0.6);"
                                            v-for="category in categoriesNews"
                                            v-bind:value="category.id_subcategory">
                                        {{ category.name_subcategory | lowercase }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group mt-4" v-show="show">
                                <label class="font-weight-bold mt-2" for="headline-admin-form">
                                    Enter Headline of Your Article:
                                </label>
                                <textarea class="form-control" id="headline-admin-form"
                                          rows="3" style="resize: none;"></textarea>
                            </div>

                            <div class="form-group mt-4" v-show="show">
                                <label class="font-weight-bold mt-2" for="article-admin-form">
                                    Enter Content of Your Article:
                                </label>
                                <textarea class="form-control" id="article-admin-form"
                                          rows="15" style="resize: none;"></textarea>
                            </div>

                            <div class="form-group mt-4" v-show="!show">
                                <label class="font-weight-bold mt-2" for="news-admin-form">
                                    Enter Content of Your News Item:
                                </label>
                                <textarea class="form-control" id="news-admin-form"
                                          rows="8" style="resize: none;"></textarea>
                            </div>

                            <div class="custom-file mt-4 mb-2" v-show="show">
                                <input type="file" class="custom-file-input"
                                       onchange="labelValue(this.value, this.files[0]);"
                                       id="uploadImage">
                                <label class="custom-file-label" for="uploadImage"
                                       style="color: rgba(0, 0, 0, 0.6);">
                                    choose image for this article
                                </label>
                            </div>

                            <div class="custom-control custom-checkbox mt-4 mb-2" v-show="!show">
                                <input type="checkbox"
                                       class="custom-control-input mt-2"
                                       id="subscribe-checkbox" name="subscribe-checkbox">
                                <label class="custom-control-label" for="subscribe-checkbox">
                                    Do you want to send this news to your subscribers?
                                </label>
                            </div>

                            <button type="button" id="publish" class="btn btn-success my-4">publish</button>
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

        //modify $subcategories into 2 variables to give to javascript
        $cat_id_subcategory = $subcategories[0]['id_subcategory'];
        $cat_name_subcategory = $subcategories[0]['name_subcategory'];

        for ($i = 1; $i < count($subcategories); $i++) {
            $cat_id_subcategory .= "/";
            $cat_id_subcategory .= $subcategories[$i]['id_subcategory'];

            $cat_name_subcategory .= "/";
            $cat_name_subcategory .= $subcategories[$i]['name_subcategory'];
        }
    ?>

    <script src="/js/main_jquery.js"></script>
    <script src="/js/main_js.js"></script>
    <script>
        // get our categories from php into javascript
        var data1 = "<?php echo $cat_id_subcategory; ?>";
        var data2 = "<?php echo $cat_name_subcategory; ?>";

        data1 = data1.split('/');
        data2 = data2.split('/');

        var categories = [];

        for (var i = 0; i < data1.length; i++) {
            categories[i] = [];
            categories[i]['id_subcategory'] = data1[i];
            categories[i]['name_subcategory'] = data2[i];
        }

    </script>
    <script src="/js/admin_jquery_vuejs.js"></script>
</body>
</html>
