<?php
    //connect functions for work with database
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";

    $db = connectDB( $config['db']['server'],
        $config['db']['name'],
        $config['db']['username'],
        $config['db']['password'] );

    //get all categories of news
    $query = $db->query(" SELECT * FROM `news_categories` ");
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);

    // get all subcategories of news
    $query = $db->query(" SELECT * FROM `news_subcategories` ");
    $subcategories = $query->fetchAll(PDO::FETCH_ASSOC);

    closeDB();
?>

<div id="menu-main" class="border border-light bg-secondary">
    <span class="icon-menu btn btn-sm btn-success py-0">menu &raquo;</span>
    <span class="icon-close-menu">&times;</span>
    <ul>
        <!-- show main-menu with categories and subcategories -->
        <? foreach ($categories as $category): ?>
            <? if ($category['id_category'] == 1): ?>
                <li class="menu-section mt-0"><?=$category['name_category']?></li>
            <? else: ?>
                <li class="menu-section"><?=$category['name_category']?></li>
            <? endif; ?>
            <? foreach ($subcategories as $subcategory): ?>
                <? if ($category['id_category'] == $subcategory['id_category']): ?>
                <li>
                    <? if (strtolower($subcategory['name_subcategory']) != 'archieve'): ?>
                        <a href="/index.php?cat=<?=$subcategory['id_subcategory']?>">
                            <?=$subcategory['name_subcategory']?>
                        </a>
                    <? else: ?>
                        <a href="/pages/archieve.php">
                            <?=$subcategory['name_subcategory']?>
                        </a>
                    <? endif; ?>
                </li>
                <? endif; ?>
            <? endforeach; ?>
        <? endforeach; ?>
    </ul>
</div>