<?php
require('../../action/action.php');
if(!empty($_GET['type']) && $_GET['type'] == 'market'){
    $col = 'marketId';
}elseif(!empty($_GET['type']) && $_GET['type'] == 'garage'){
    $col = 'garageId';
}
$datas = getOneMarketsGarages($_GET['id'], $col);
$pageTitle = 'DonkeyCar '.$datas['marketCity'];
include('../../layout/header.php');
?>
<div class="container-fluid md-2">
    <section class="h-100 gradient-custom-2">
        <div class="row-cols-1 row-cols-md-3 g-4 d-flex justify-content-around align-self-center flex-row text-center align-items-stretch" >
            <div class="col m-5">
                <div class="card h-100">
                    <div class="card-img-top d-flex justify-content-center text-center flex-column align-self-center  p-3" style="background-color: #f8f9fa;">
                        <img src="https://www.donkeycar.com/uploads/7/8/1/7/7817903/published/donkeycar-logo-sideways.png?1557205931"  alt="...">
                        <h2><?= $datas['marketName']?></h2>
                    </div>
                    <div class="card-body">
                        <h2 class="font-italic mb-3" style="background-color: #f8f9fa;">Address</h2>
                        <p class="font-italic mb-1"><?= $datas['marketAdress']; ?></p>
                        <p class="font-italic mb-1"><?= $datas['marketCity']; ?></p>
                        <p class="font-italic mb-1"><?= $datas['marketZip']; ?></li></p>
                        <p class="font-italic mb-1"><?= $datas['marketCountry']; ?></p>
                    </div>
                    <div class="card-footer">
                        <a type="button" href="pageEditCarMarket.php?id=<?= $datas['marketId']?>&type=market" class="btn btn-secondary m-2">Edit Market</a>
                    </div>
                    <div class="card-footer">
                        <a type="button" class="btn btn-secondary m-2" href="http://donkeycar.com/action/admin/actionDeleteCarMarketGarage.php?id=<?=$datas['marketId']?>&type=market">Delete Market</a>
                    </div>
                    <div class="card-footer card-img-top  d-flex justify-content-center text-center flex-column align-self-center  p-3" style="background-color: #f8f9fa;">
                        <h2><?= $datas['garageName']?></h2>
                    </div>
                    <div class="card-footer">
                        <a type="button" class="btn btn-secondary m-2" href="pageEditCarMarket.php?id=<?= $datas['garageId']?>&type=garage">Edit Garage</a>
                    </div>
                    <div class="card-footer">
                        <a type="button" class="btn btn-secondary m-2" href="http://donkeycar.com/action/admin/actionDeleteCarMarketGarage.php?id=<?= $datas['garageId']?>&type=garage">Delete Garage</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('../../layout/footer.php');?>