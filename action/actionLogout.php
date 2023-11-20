<?php
require('action.php');
$_SESSION = array();
session_destroy();
header('Location: ../index.php');
exit();
?>