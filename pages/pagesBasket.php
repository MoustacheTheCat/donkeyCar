<?php
require('../action/action.php');
$pageTitle = 'Your Basket';
include('../layout/header.php');
$nbRents = null;
$datasRents = null;


if(!empty($_SESSION['nbDataRent'])){
    $nbRents = $_SESSION['nbDataRent'];
    $datasRents = $_SESSION['allDataRents'];
    print_r($datasRents);
    $_SESSION['messageRental'] = "here is your basket";
}
else {
    $_SESSION['messageRental'] = "You have not rental in your basket";
}

?>
<?php printMessageresponse(); 
    if(!empty($datasRents)){
        printBasket($datasRents, $nbRents); 
    }
?>


<?php include('../layout/footer.php');?>