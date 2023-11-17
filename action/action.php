<?php
ini_set('display_errors', 'On');
session_start();
// if(empty($_SESSION['role']) && ($_SESSION['role'] != 'admin' ||  $_SESSION['role'] != 'customer')){
//     header('Location: ../index.php');
//     exit;
// }
require('function.php');
require('request.php');