<?php

require_once 'FootballBlock.php';
use \FootballNews\FootballBlock as FootballBlock;


class FootballArticle extends FootballBlock
{
    protected $football_item;
    protected $cat_bool;
    protected $introtext;

    protected function getIntroText() {
        $football_text = '';
        $football_array = explode(' ', $this->football_item['text']);
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

    public function writeShortOddArticle() {
        echo '<div class="info-articles p-4 mb-4">
                    <img src="/images/articles_images/'.$this->football_item['image'].'"
                         alt="image article '.$this->football_item['id'].'"
                         class="img-thumbnail mr-3"
                         style="float: left;"
                    >
                    <h4 class="mb-2">
                        <a href="/pages/article.php?id='.$this->football_item['id'].'">
                            '.$this->football_item['title'].'
                        </a>
                    </h4>
                    <p class="mb-2">'.$this->introtext.'</p>
                    <a href="/pages/article.php?id='.$this->football_item['id'].'&amp;catbool='.
            $this->cat_bool.'">read about it &raquo;</a>
                </div>';
    }

    public function writeShortEvenArticle() {
        echo '<div class="info-articles p-4 mb-4">
                    <img src="/images/articles_images/'.$this->football_item['image'].'"
                         alt="image article '.$this->football_item['id'].'"
                         class="img-thumbnail ml-2"
                         style="float: right;"
                    >
                    <h4 class="mb-2">
                        <a href="/pages/article.php?id='.$this->football_item['id'].'">
                            '.$this->football_item['title'].'
                        </a>
                    </h4>
                    <p class="mb-2">'.$this->introtext.'</p>
                    <a href="/pages/article.php?id='.$this->football_item['id'].'&amp;catbool='.
            $this->cat_bool.'">read about it &raquo;</a>
                </div>';
    }

    public function writeFullText() {
        echo '<div class="football-article p-4 mb-4">
                    <img src="/images/articles_images/'.$this->football_item['image'].'"
                         alt="image article '.$this->football_item['id'].'"
                         class="img-thumbnail ml-4"
                         style="float: right;"
                    >
                    <h4 class="mb-3">'.$this->football_item['title'].'</h4>
                    <p class="mb-3">'.$this->football_item['text'].'</p>
                    <div><span>'.date("d-m-Y H:i:s", $this->football_item['date']).'</span>
                        <a class="left-link" href="../index.php">return to the main page &raquo;</a>
                        <a class="right-link" href="../index.php?cat='.$this->football_item['id_subcategory'].'">
                            read another articles of this category &raquo;
                        </a></div>
                </div>';
    }

}