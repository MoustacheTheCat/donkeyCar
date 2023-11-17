<?php

function connect_bd() : PDO {
    require_once '/var/www/html/donkeyCar/config/_connect.php';
    try {
        $pdo = new \PDO(DSN, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
    }
}