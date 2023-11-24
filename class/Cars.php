<?php
require_once '/var/www/html/donkeyCar/class/DataBase.php';
$db = new Database();
$cars = $db->getCars();
