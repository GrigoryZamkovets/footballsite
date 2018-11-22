<?php
require_once 'FootballBlock.php';
use \FootballNews\FootballBlock as FootballBlock;


class FootballItem extends FootballBlock
{
    protected $football_item;
    protected $image_category;
    protected $introtext;
    protected $cat_bool;

    function __construct($football_item, $cat_bool, $subcategories) {
        parent::__construct($football_item, $cat_bool);
        $this->image_category = $this->getSubcategory($subcategories);
    }

    protected function getIntroText() {
        $football_text = '';
        $football_array = explode(' ', $this->football_item['text']);
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

    private function getSubcategory($subcategories) {
        $image_category = false;
        if (!($subcategories)) {
            $image_category = 'default.jpg';
            return $image_category;
        }
        if ($this->football_item['id_subcategory'] === $subcategories['id_subcategory']) {
            $image_category = $subcategories['img_category'];
        } else {
            foreach ($subcategories as $subcategory) {
                if ($this->football_item['id_subcategory'] === $subcategory['id_subcategory']) {
                    $image_category = $subcategory['img_category'];
                    break;
                }
            }
        }
        if ($image_category === false) {
            $image_category = 'default.jpg';
        }
        return $image_category;
    }

    public function writeShortItem() {
        echo '<div class="football-news">
                  <img src="/images/news_images/'.$this->image_category.'" 
                       alt="image football news '.$this->football_item['id'].'">
                  <p><a href="/pages/item.php?id='.$this->football_item['id'].'&amp;catbool='.
            $this->cat_bool.'">'.$this->introtext.'</a></p>
                  <span>'.date("d-m-Y H:i:s", $this->football_item['date']).'</span>
                  <hr />
              </div>';
    }

    public function writeFullText() {
        echo '<div class="football-item pt-2 mb-4 pb-4">
                  <img src="/images/news_images/'.$this->image_category.'" 
                       alt="image football news '.$this->football_item['id'].'">
                  <p>'.$this->football_item['text'].'</p>
                  <div style="clear: both;"><span>'.date("d-m-Y H:i:s", $this->football_item['date']).'</span>
                  <a class="left-link" href="../index.php">return to the main page &raquo;</a>
                  <a class="right-link" href="../index.php?cat='.$this->football_item['id_subcategory'].'">
                      read another news of this category &raquo;
                  </a></div>
              </div>';
    }
}