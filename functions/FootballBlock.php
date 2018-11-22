<?php

namespace FootballNews;

abstract class FootballBlock
{
    protected $football_item;
    protected $introtext;
    protected $cat_bool;

    function __construct($football_item, $cat_bool) {
        $this->football_item = $football_item;
        $this->cat_bool = $cat_bool;
        $this->introtext = $this->getIntroText();
    }

    abstract protected function getIntroText();

    abstract public function writeFullText();
}