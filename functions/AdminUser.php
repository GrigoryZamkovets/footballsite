<?php

namespace AdminFootballDB;

class AdminUser
{
    protected $username;
    protected $password;
    protected $password1;
    private $db;

    function __construct($username, $password, $password1, $db) {
        $this->username = $username;
        $this->password = $password;
        $this->password1 = $password1;
        $this->db = $db;
    }

    private function getUsername() {
        try {
            $query = $this->db->prepare(" SELECT * FROM `users` WHERE `username`=:username ");
            $params = array ('username' =>$this->username);
            $query->execute($params);
            $exist_row = $query->fetch();
            return $exist_row;
        } catch ( Exception $e ) {
            return $e;
        }
    }

    public function checkUser() {
        $exist_username = $this->getUsername();

        if ( $exist_username instanceof Exception ) {
            return $exist_username;
        }

        if ( !$exist_username  ) {
            return false;
        } else {
            return true;
        }
    }

    public function checkEnterPurpose() {
        if ( $this->password !== '' ) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword() {
        $exist_password = $this->getUsername();
        $password1 = md5($this->password1);

        if ( $password1 === $exist_password['password'] ) {
            echo "the new password is the same as it was before";
        } else {
            try {
                $query = $this->db->prepare(" UPDATE `users` SET `password` =:password 
                                                                 WHERE `username`=:username ");
                $params = array ('password' => $password1, 'username' => $this->username);
                $query->execute($params);
                echo "your password was updated successfully!";
            } catch ( Exception $e ) {
                echo 'Выброшено исключение: ' . $e->getMessage();
            }
        }
    }

    public function enterAdmin() {
        $exist_username = $this->getUsername();
        $password = md5($this->password);

        if ( $password !== $exist_username['password'] ) {
            return "enter correct password!";
        } else {
            return "correct username and password";
        }
    }


}