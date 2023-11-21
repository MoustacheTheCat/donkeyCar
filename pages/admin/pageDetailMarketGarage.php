<?php
require('../../action/action.php');
if(!empty($_GET['type']) && $_GET['type'] == 'market'){
    $col = 'marketId';
}elseif(!empty($_GET['type']) && $_GET['type'] == 'garage'){
    $col = 'garageId';
}
$pageTitle = 'Detail of Market and Garage';
$datas = getOneMarketsGarages($_GET['id'], $col);
include('../../layout/header.php');
?>
<div class="container-fluid md-2">
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <img src="https://pluspng.com/img-png/user-png-icon-big-image-png-2240.png" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5><?= $datas['marketName']; ?></h5>
                            </div>
                        </div>
                        <div class="p-4 text-black" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-end text-center py-1">
                                <div>
                                    <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                        <a href="admin/pageEditMarketGarage.php?id=<?= $datas['marketId']?>">Edit Market</a>
                                    </button>
                                </div>
                                <div class="px-3">
                                    <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                    <a href="#?id=<?=$datas['marketId']?>">Delete Market</a>
                                    </button>
                                </div>  
                            </div>
                        </div>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5">
                                <h5 class="mb-3">Information</h5>
                                <div class="p-4" style="background-color: #f8f9fa;">
                                    <h6>About market</h6>
                                    <p class="font-italic mb-1"><?= $datas['marketAdress']; ?><</p>
                                    <p class="font-italic mb-1"><?= $datas['marketCity']; ?></p>
                                    <p class="font-italic mb-1"><?= $datas['marketZip']; ?></li></p>
                                    <p class="font-italic mb-1"><?= $datas['marketCountry']; ?></p>
                                </div>
                                <div class="p-4" style="background-color: #f8f9fa;">
                                    <h6>About garage</h6>
                                    <p class="font-italic mb-1">@ : <?= $datas['garageName']?></p>
                                    <div class="p-4 text-black" style="background-color: #f8f9fa;">
                                        <div class="d-flex justify-content-start text-center py-1">
                                            <div>
                                                <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                                    <a href="admin/pageEditMarketGarage.php?id=<?= $datas['garageId']?>">Edit Garage</a>
                                                </button>
                                            </div>
                                            <div class="px-3">
                                                <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                                    <a href="#?id=<?= $datas['garageId']?>">Delete Garage</a>
                                                </button>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('../../layout/footer.php');?>