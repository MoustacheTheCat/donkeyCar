<?php
require('../action/action.php');
$cars = getOnCarInGarageByCarId($_GET['id']);
$pageTitle = $cars['brandName']." ".$cars['carName'];
include('../layout/header.php');
?>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Brand and Model</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Brand :<?= $cars['brandName'];?></li>
                <li class="list-group-item">Model :<?= $cars['carName'];?></li>
            </ul>
            <h3 class="card-title">Information about the car</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">type : <?= $cars['typeCarName'];?></li>
                <li class="list-group-item">Year : <?= $cars['carYear'];?></li>
                <li class="list-group-item">hourly rate : <?= $cars['carTarifHourHT']*1.2;?></li>
                <li class="list-group-item">daily rate : <?= $cars['carTarifDayHT'] *1.2;?></li>
                <li class="list-group-item">deposit : <?= $cars['carCaution'];?></li>
                <?php if($cars['garargeCarDisponibility'] == 0):?>
                    <li class="list-group-item">Disponibility : Available</li>
                <?php elseif($cars['garargeCarDisponibility'] == 1):?>
                    <li class="list-group-item">Disponibility : Unavailable </li>
                <?php endif;?>
            </ul>
        </div>
    </div>
</div>
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
                                <h5><?= $cars['brandName'].' '.$cars['carName'];?></h5>
                            </div>
                        </div>
                        <div class="p-4 text-black" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-end text-center py-1">
                                <?php if($cars['garargeCarDisponibility'] == 0 && !empty($_SESSION['role']) && $_SESSION['role'] == 'customer'):?>
                                    <div>
                                        <form action="customer/pageAskRental.php?id=<?= $cars['carId'];?>" method="POST" class="list-group list-group-flush">
                                            <input type="submit" value="Rental" name="rentalCar" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                        </form>
                                    </div>
                                <?php elseif(!empty($_SESSION['role']) && $_SESSION['role'] == 'admin'):?><div class="row justify-content-center mt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                                <a href="admin/pageEditCar.php?id=<?=$cars['carId']?>">Edit Car</a>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                                <a href="#?id=<?=$cars['carId']?>">Delete Car</a>
                                            </button>
                                        </div>  
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5">
                                <h5 class="mb-3">Information about the car</h5>
                                <div class="p-4" style="background-color: #f8f9fa;">
                                    <p class="font-italic mb-1">Type :<?= $cars['typeCarName'];?></p>
                                </div>
                                <div class="p-4" style="background-color: #f8f9fa;">
                                    <h6>Info:</h6>
                                    <p class="font-italic mb-1">@ : <?= $customer['customerEmail']?></p>
                                    <p class="font-italic mb-0"># : <?= $customer['customerNumber']?></p>
                                </div>
                                <div class="p-4" style="background-color: #f8f9fa;">
                                    <h6>Permis Number:</h6>
                                    <p class="font-italic mb-1"><?= $customer['customerNumberPermit']?></p>
                                </div>
                                <div class="p-4" style="background-color: #f8f9fa;">
                                    <h6>Address:</h6>
                                    <p class="font-italic mb-1"><?= $customer['customerAddress']?></p>
                                    <p class="font-italic mb-1"><?= $customer['customerZip'].' '.$customer['customerCity']?></p>
                                    <p class="font-italic mb-0"><?= $customer['customerCountry']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('../layout/footer.php'); ?>
