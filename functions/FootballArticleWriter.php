<?php

require_once 'FootballWriter.php';

class FootballArticleWriter extends FootballWriter
{
    protected $cat;
    protected $title;
    protected $text;
    protected $image;
    protected $db;

    function __construct($select_cat, $title, $text, $image, $db) {
        parent::__construct($select_cat, $text, $db);
        $this->title = $title;
        $this->image = $image;
    }

    private function getImages() {
        $query = $this->db->query(" SELECT `image` FROM `football_articles` ");
        $images = $query->fetchAll();
        return $images;
    }

    public function checkVariables() {
        if ( $this->cat == '' || $this->title == '' || $this->text == '' ) {
            return false;
        } else {
            return true;
        }
    }

    private function checkNameImage($name_img, $images) {
        foreach ($images as $image) {
            $img = explode('.', $image['image']);
            if ( $img[0] == $name_img ) {
                $name_img = $name_img . mt_rand(1000, 9999);
                $this->checkNameImage($name_img, $images);
            }
        }
        return $name_img;
    }

    public function checkImage() {
        if ( !$this->image ) {
            $this->image = 'default.jpg';
        } else {
            $images = $this->getImages();
            $name_image = explode('.', basename($this->image['name']) );

            $name_image[0] = $this->checkNameImage($name_image[0], $images);
            $name_image = implode('.', $name_image);

            $uploadfile = $_SERVER['DOCUMENT_ROOT'] . '/images/articles_images/' . $name_image;
            if ( move_uploaded_file($this->image['tmp_name'], $uploadfile) ) {
                $this->image = $name_image;
            } else {
                $this->image = 'default.jpg';
            }
        }
    }

    public function publish() {
        try {
            $query = $this->db->prepare(" INSERT INTO `football_articles` 
                                            SET `id_subcategory`=:id_subcategory,
                                                `title`=:title,
                                                `text`=:text,
                                                `image`=:image,
                                                `date`='".time()."'");
            $params = array ('id_subcategory' =>$this->cat,
                             'title' =>$this->title,
                             'text' =>$this->text,
                              'image' => $this->image);
            $query->execute($params);
            return true;
        } catch ( Exception $e ) {
            return $e;
        }
    }
}