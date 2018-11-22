<?php

require_once 'FootballWriter.php';

class FootballItemWriter extends FootballWriter
{
    protected $cat;
    protected $text;
    protected $db;

    public function checkVariables() {
        if ( $this->cat == '' || $this->text == '' ) {
            return false;
        } else {
            return true;
        }
    }

    public function publish() {
        try {
            $query = $this->db->prepare(" INSERT INTO `football_news` 
                                            SET `id_subcategory`=:id_subcategory,
                                                `text`=:text,
                                                `date`='".time()."'");
            $params = array ('id_subcategory' =>$this->cat, 'text' =>$this->text);
            $query->execute($params);
            return true;
        } catch ( Exception $e ) {
            return $e;
        }
    }

    public function sendNews() {
        try {
            $stmt = $this->db->query(" SELECT * FROM `subscribe_email`");
            $subscribers = $stmt->fetchAll();
        } catch ( Exception $e ) {
            return false;
        }

        $email = 'Green5050555@mail.ru';
        $subject = 'our football news';
        $message = $this->text;
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        $headers = "From: $email\r\nReply-to: $email\r\n\Content-type: 
        text/plain; charset=utf-8\r\n";

        foreach ($subscribers as $subscriber) {
            $to = $subscriber['email'];
            mail($to, $subject, $message, $headers);
        }

        return true;
    }
}