<?php
    //connect functions for work with database
    $address_connect = $_SERVER['DOCUMENT_ROOT'].'/functions/db_create_use.php';
    require_once "$address_connect";

    $db = connectDB( $config['db']['server'],
        $config['db']['name'],
        $config['db']['username'],
        $config['db']['password'] );

    //get all categories of news
    $query = $db->query(" SELECT * FROM `advertizing_modal` ORDER BY `id` DESC LIMIT 0, 2 ");
    $advertizing_images = $query->fetchAll(PDO::FETCH_ASSOC);

    closeDB();
?>


<footer class="footer">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-center py-4">
                <div class="modal-js-advertizing col-sm-6 col-xl-3 order-xl-1 text-center pb-4">
                    <img src="/images/advertizing_images/<?=$advertizing_images[0]['image']?>"
                            alt="advertizing picture 1"
                            class="img-fluid footer-adv-img">
                    <div class="modal-js-content">
                        <p><?=$advertizing_images[0]['text']?>"</p>
                        <div class="text-left pl-4">
                            <span class="btn btn-success btn-sm"
                                  onclick="document.getElementById('modal-js-id').style.display='none'"> close
                            </span>
                        </div>
                    </div>
                </div>

                <div class="modal-js-advertizing col-sm-6 col-xl-3 order-xl-3 text-center pb-4">
                    <img src="/images/advertizing_images/<?=$advertizing_images[1]['image']?>"
                            alt="advertizing picture 2"
                            class="img-fluid footer-adv-img">
                    <div class="modal-js-content">
                        <p><?=$advertizing_images[1]['text']?></p>
                        <div class="text-left pl-4">
                            <span class="btn btn-success btn-sm"
                                  onclick="document.getElementById('modal-js-id').style.display='none'"> close
                            </span>
                        </div>
                    </div>
                </div>

                <!-- modal window for advertizing pictures -->
                <div id="modal-js-id" class="modal-js py-4">
                    <span class="modal-js-close" onclick="document.getElementById('modal-js-id').style.display='none'">
                        &times;
                    </span>
                    <img class="modal-js-content-img" id="modal-js-img" alt=""/>
                    <div id="modal-js-content">

                    </div>
                </div>

                <div class="col-md-9 col-xl-6 order-xl-2 pb-2">
                    <b><?=$config['site_name']?> (<?=$config['site_name_short']?>)</b> -
                    one of the most popular football sites for foreign football fans! You can find the most
                    interesting and recent information about World and European football here. Welcome to our
                    site if you want to be aware of the latest football events! <br>
                    <b><?=$config['site_name_short']?></b> - is permanent updated information resource with fresh news,
                    information and analytical articles which are published by our own authors. All you can find here
                    is only about football and is aimed at coverage and promotion of this great sport.
                    If you cared for it and you want be aware of the latest football news you are welcome! <br>
                    <b><?=$config['site_name_short']?></b> - is round-the-clock information resource with constant
                    dynamic updating of football news. There is all the latest football news, results of Champions
                    League and League of Europe matches, regional qualifying and final matches of the World
                    and European Championships, articles, reviews, video, foto and online-translations. <br>
                    <b>The news feed</b> is updating 24 hours a day, results of matches and review articles are
                    posted immediately after football matches are finished. If you can not see match online you
                    always could follow developments online at our text translations. And you will find all detailed
                    statistics and review articles on all matches immediately after this matches are finished.
                    All updates are made immediately after final whisle. <br>
                    <b><?=$config['site_name_short']?></b> - is a big football arhieve too, including information about
                    championships of England, Germany, Italy, Spain, France, Holand, Champions League, League of
                    Europe, The World and The European Championships of a few last years. You can find also information
                    and detailed statistics of the most famous football players of our planet. <br>
                    <b>Champions League, League of Europe</b>, national championships and cups, matches of national
                    teams - you can find all this current information on our website. We offer you onstantly updated
                    UEFA and FIFA ratings, betting, different social surveys and votings, comfortable search, links
                    to official football clubs sites. <br>
                    <b><?=$config['site_name_short']?></b> - is a football society also with comfortable forum where
                    you can discuss all events from world of football. Every match and every important football event
                    you can discuss on our forum.
                    <b>Our website</b> are impruved constantly, we open new sections, the number of our supporters
                    are growing, every person from them can easely take part in our site life. Plunge into our
                    football world with us and enjoy it!
                </div>
            </div>

            <div class="row justify-content-between px-2 pb-4">
                <div class="col-sm-6 col-xl-4">
                    <span>&copy; All rights are protected, <?=$config['site_name']?>, <?=date("Y")?></span><br>
                    <span>
                        <a href="https://vk.com/grigory_zamkovets"
                           target="_blank">Website development - Grigory Zamkovets</a>
                    </span>
                </div>

                <div class="col-sm-6 col-xl-4 mt-4 mt-sm-0">
                    <div class="footer-social-links mb-2">
                        <a href="https://vk.com/grigory_zamkovets" target="_blank">
                            <img src="/images/social_links/vkontakte.png" width="30" height="30" alt="vkontakte">
                        </a>
                        <a href="https://www.youtube.com/user/MrGrisha5050" target="_blank">
                            <img src="/images/social_links/youtube.png" width="30" height="30" alt="youtube">
                        </a>
                        <a href="https://www.facebook.com/grigory.zamkovets.9" target="_blank">
                            <img src="/images/social_links/facebook.png" width="25" height="25" alt="facebook">
                        </a>
                        <a href="https://www.skype.com" target="_blank">
                            <img src="/images/social_links/skype.png" width="25" height="25" alt="skype">
                        </a>
                    </div>
                    <div class="footer-email">
                        <a href="mailto:Green5050@mail.ru" target="_blank">
                            Write a letter to us (<?=$config['site_name']?>)
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>