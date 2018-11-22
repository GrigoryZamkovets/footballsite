<?php

class SearchItem
{
    protected $search;
    protected $db;
    protected $cat_bool = false;

    function __construct($search, $db) {
        $this->search = $search;
        $this->db = $db;
    }

    private function getNews() {
        $query = $this->db->query(" SELECT * FROM `football_news` ");
        $news = $query->fetchAll();
        return $news;
    }

    private function getArticles() {
        $query = $this->db->query(" SELECT * FROM `football_articles` ");
        $articles = $query->fetchAll();
        return $articles;
    }

    private function getImage($cat) {
        $query = $this->db->query(" SELECT * FROM `news_subcategories` WHERE `id_subcategory`=$cat ");
        $image = $query->fetch();
        if ( !(!$image['img_category']) ) {
            return $image['img_category'];
        } else {
            return 'default.jpg';
        }

    }

    private function getIntroItem($text) {
        $football_text = '';
        $football_array = explode(' ', $text);
        for ($i = 0; $i < count($football_array); $i++) {
            if (strlen($football_text) < 50) {
                $football_text .= $football_array[$i] . ' ';
            } else {
                break;
            }
        }
        $football_text .= '...';
        return $football_text;
    }

    private function getIntroArticle($text) {
        $football_text = '';
        $football_array = explode(' ', $text);
        for ($i = 0; $i < count($football_array); $i++) {
            if (strlen($football_text) < 1500) {
                $football_text .= $football_array[$i] . ' ';
            } else {
                break;
            }
        }
        $football_text .= '...';
        return $football_text;
    }

    protected function writeShortOddArticle($article, $introtext) {
        echo '<div class="info-articles p-4 mb-4">
                    <img src="/images/articles_images/'.$article['image'].'"
                         alt="image article '.$article['id'].'"
                         class="img-thumbnail mr-3"
                         style="float: left;"
                    >
                    <h4 class="mb-2">
                        <a href="/pages/article.php?id='.$article['id'].'">
                            '.$article['title'].'
                        </a>
                    </h4>
                    <p class="mb-2">'.$introtext.'</p>
                    <a href="/pages/article.php?id='.$article['id'].'&amp;catbool='.
            $this->cat_bool.'">read about it &raquo;</a>
                </div>';
    }

    protected function writeShortEvenArticle($article, $introtext) {
        echo '<div class="info-articles p-4 mb-4">
                    <img src="/images/articles_images/'.$article['image'].'"
                         alt="image article '.$article['id'].'"
                         class="img-thumbnail ml-2"
                         style="float: right;"
                    >
                    <h4 class="mb-2">
                        <a href="/pages/article.php?id='.$article['id'].'">
                            '.$article['title'].'
                        </a>
                    </h4>
                    <p class="mb-2">'.$introtext.'</p>
                    <a href="/pages/article.php?id='.$article['id'].'&amp;catbool='.
            $this->cat_bool.'">read about it &raquo;</a>
                </div>';
    }

    public function writeItems() {
        $news = $this->getNews();
        $articles = $this->getArticles();
        $is_published = false;
        $counter = 0;

        foreach ( $news as $item ) {
            $pos = strrpos($item['text'], $this->search);

            if ( $pos !== false ) {
                $is_published = true;
                $image = $this->getImage($item['id_subcategory']);
                $introtext = $this->getIntroItem($item['text']);

                echo '<div class="football-news w-75 mt-2 mx-auto" style="max-width: 540px;">
                  <img class="mb-3" src="/images/news_images/'.$image.'" 
                       alt="image football news '.$item['id'].'">
                  <p><a href="/pages/item.php?id='.$item['id'].'&amp;catbool='.
                    $this->cat_bool.'">'.$introtext.'</a></p>
                  <span>'.date("d-m-Y H:i:s", $item['date']).'</span>
                  <hr />
              </div>';
            }
        }

        foreach ( $articles as $article ) {
            $pos1 = strrpos($article['title'], $this->search);
            $pos2 = strrpos($article['text'], $this->search);

            if ( $pos1 !== false || $pos2 !== false ) {
                $is_published = true;
                $counter++;
                $introtext = $this->getIntroArticle($article['text']);

                if ( $counter % 2 == 1 ) {
                    $this->writeShortOddArticle($article, $introtext);
                } else {
                    $this->writeShortEvenArticle($article, $introtext);
                }

            }
        }

        if ( $is_published === false ) {
            echo '<div class="search-error">
                    we have not found any news or articles with this search words</div>';
        }
    }



}