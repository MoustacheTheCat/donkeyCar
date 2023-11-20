<?php
require('../../action/action.php');
if(!empty($_GET['type']) && $_GET['type'] == 'market'){
    $dataMarkets = getOneRow('markets', 'marketId', $_GET['id']);
    $pageTitle = 'detail Market';
}elseif(!empty($_GET['type']) && $_GET['type'] == 'garage'){
    $dataGarages = getOneRow('garages', 'garageId', $_GET['id']);
    $dataMarkets = getOneRow('markets', 'marketId', $dataGarages['marketId']);
    $marketName = $dataMarkets['marketName'];
    $garageName = $dataGarages['garageName'];
    $pageTitle = 'detail Garage';
}
include('../../layout/header.php');

?>
<?php if(!empty($_GET['type']) && $_GET['type'] == 'market'):?>
    <div class="container mt-5">
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title"><?= $dataMarkets['marketName']; ?> </h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">City: <?= $dataMarkets['marketCity']; ?></li>
                    <li class="list-group-item">Address: <?= $dataMarkets['marketAdress']; ?></li>
                    <li class="list-group-item">Postal Code: <?= $dataMarkets['marketZip']; ?></li>
                    <li class="list-group-item">Country: <?= $dataMarkets['marketCountry']; ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-2">
            <a href="admin/pageEditMarketGarage.php?id=<?= $dataMarkets['marketId']?>">Edit Market</a>
        </div>
        <div class="col-md-2">
            <a href="#?id=<?=$dataMarkets['marketId']?>">Delete Market</a>
        </div>
    </div>
<?php elseif(!empty($_GET['type']) && $_GET['type'] == 'garage'):?>
    <div class="container mt-5">
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title"><?= $garageName; ?> </h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Market: <?= $marketName; ?></li>
                    <li class="list-group-item">City: <?= $dataMarkets['marketCity']; ?></li>
                    <li class="list-group-item">Address: <?= $dataMarkets['marketAdress']; ?></li>
                    <li class="list-group-item">Postal Code: <?= $dataMarkets['marketZip']; ?></li>
                    <li class="list-group-item">Country: <?= $dataMarkets['marketCountry']; ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-2">
            <a href="admin/pageEditMarketGarage.php?id=<?= $dataGarages['garageId']?>">Edit Garage</a>
        </div>
        <div class="col-md-2">
            <a href="#?id=<?= $dataGarages['garageId']?>">Delete Garage</a>
        </div>
    </div>
<?php endif;?>
<?php include('../../layout/footer.php');?>