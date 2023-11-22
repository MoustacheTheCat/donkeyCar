<?php
require('../action/action.php');
$id = $_GET['id'];
if(!empty($id)){
    $queryM = "DELETE FROM messages WHERE messageId = $id";
    $queryCM = "DELETE FROM messageCustomer WHERE messageId = $id";
    $queryAM = "DELETE FROM messageAdmin WHERE messageId = $id";
    $dataQuery= array(
        'queryM' => $queryM,
        'queryCM' => $queryCM,
        'queryAM' => $queryAM
    );
    foreach($dataQuery as $key => $value){
        $pdo = connect_bd();
        $result = $pdo->prepare($value);
        $result->execute();
    }
    header('Location: ../../pages/pageListMessage.php');
    $_SESSION['messageSuccess'] = "The message has been deleted";
    exit;
}