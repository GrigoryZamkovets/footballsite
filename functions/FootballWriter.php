<?php

abstract class FootballWriter
{
    protected $cat;
    protected $text;
    protected $db;

    function __construct($select_cat, $text, $db) {
        $this->cat = $select_cat;
        $this->text = $text;
        $this->db = $db;
    }

    abstract public function checkVariables();

    abstract public function publish();
}