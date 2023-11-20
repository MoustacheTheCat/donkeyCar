<?php
require('action/action.php');
$pageTitle = 'Donkey Car';
include('layout/header.php');
$marketCitys = getMarketCitys();
$marketCountrys = getMarketsCountry();
$nbMarkets = null;
$cars = null;
$marketCits = null;
if(!empty($_SESSION['nbMarkets']) && !empty($_SESSION['marketCity'])){
    $nbMarkets = $_SESSION['nbMarkets'];
    $marketCits = $_SESSION['marketCity'];
    unset($_SESSION['nbMarkets']);
    unset($_SESSION['marketCity']);
}
if(!empty($_SESSION['cars'])){
    $cars = $_SESSION['cars'];
    unset($_SESSION['cars']);
    $_SESSION['cardatas'] = $cars;
}
?>
<style><?php include('css/style.css')?></style>
<div class="row">
    <div class="col-md-12">
        <h2 class="text-center">Choose your destination</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p class="text-center">Filter your destination by a city or a country</p>
    </div>
</div>
<div class="row text-center justify-content-center">
    <?php filterCityCountry();?>
</div>

<?php printMessageresponse(); ?>
<?php if ($cars != null):?>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">List of car rental services in <?= $cars[0]['marketCountry'];?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Filter car by year or type</p>
        </div>
    </div>
    <div class="row text-center justify-content-center">
        <?php filterTypeYear();?>
    </div>
        
    <?php if ($marketCits != null):?>
        <?php $tabNameCitys = array();?>
        <?php foreach($cars as $car):?>
            <?php if(in_array($car['marketId'] , $marketCits) && !in_array($car['marketCity'] , $tabNameCitys)):?>
                <?php $tabNameCitys[] = $car['marketCity'];?>
                <h2><?= $car['marketCity'];?></h2>
                <?php printTableHome($car['marketCity'], $cars);?>
            <?php endif;?>
        <?php endforeach;?>   
    <?php else:?>
        <h2><?= $cars[0]['marketCity'];?></h2>
        <?php printTableHome($cars[0]['marketCity'], $cars);?>
    <?php endif; ?>
<?php endif; ?>

<?php include('layout/footer.php'); ?>