<?php
require('../action/action.php');
$cars = getOnCarInGarageByCarId($_GET['id']);
$pageTitle = "Detail Car";
include('../layout/header.php');
?>
<div class="container-fluid md-2">
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <img src="https://static.vecteezy.com/system/resources/previews/000/623/239/original/auto-car-logo-template-vector-icon.jpg" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5><?= $cars['brandName'];?></h5>
                                <h5><?= $cars['carName'];?></h5>
                            </div>
                        </div>
                        <div class="p-4 text-black" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-end text-center py-1">
                                <?php if(($cars['garargeCarDisponibility'] == 0 && !empty($_SESSION['role']) && $_SESSION['role'] == 'customer')|| ($cars['garargeCarDisponibility'] == 0 && empty($_SESSION['role']))):?>
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
                                    <p class="font-italic mb-1">Year : <?= $cars['carYear'];?></p>
                                    <p class="font-italic mb-1">hourly rate : <?= $cars['carTarifHourHT']*1.2;?></p>
                                    <p class="font-italic mb-0">daily rate : <?= $cars['carTarifDayHT'] *1.2;?></p>
                                    <p class="font-italic mb-1">deposit : <?= $cars['carCaution'];?></p>
                                    <?php if($cars['garargeCarDisponibility'] == 0):?>
                                        <p class="font-italic mb-0">Disponibility : Available</p>
                                    <?php elseif($cars['garargeCarDisponibility'] == 1):?>
                                        <p class="font-italic mb-0">Disponibility : Unavailable</p>
                                    <?php endif;?>
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
