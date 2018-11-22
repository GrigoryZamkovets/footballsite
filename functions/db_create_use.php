<?php

    require_once "config.php";

    $db = false;
    $query = false;

    function createDB ($host, $nameDB, $user, $password) {
        try {
            $conn = new PDO("mysql:host=$host", $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE $nameDB";
            $conn->exec($sql);
        } catch (PDOException $e) {
            die('Can\'t connect to localhost. Error: ' . $e->getMessage());
        }
    }

    function connectDB ($host, $nameDB, $user, $password) {
        try {
            $db = new PDO ("mysql:host=$host;dbname=$nameDB", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("SET NAMES UTF8");
            return $db;
        } catch (PDOException $e) {
            die('Can\'t connect to localhost. Error: ' . $e->getMessage());
        }
    }

    function createTable ($db, $sql) {
        global $db;
        $db->exec($sql);
    }

    function closeDB () {
        global $db;
        global $query;
        $db = null;
        $query = null;
    }








