<?php
require('../../action/action.php');
$id = $_GET['id'];
$data = $_SESSION['allDataRents'][$id];
$pageTitle = 'Update your rent';
include('../../layout/header.php');
?>
<style><?php include('../../css/layout.css')?></style>
<div class="container-fluid md-2">
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl">
                    <div class="card" style="background-color: #f8f9fa;">
                            <div class="card-body p-4 text-black">
                                <div class="m-5 ">
                                    <?php if(empty($_GET['type'])):?>
                                    <div class="row justify-content-center mt-5 mb-5">
                                        <div class="col-12">
                                            <h2 class="mb-3 text-center">Information about your rent</h2> 
                                        </div>
                                    </div>
                                    <div class="p-5 mt-5 mb-5 container-sm px-1" style="background-color: #f8f9fa; width: 60%;">
                                        <h5 class="text-center">Change your Email</h5>
                                        <form action="../../action/customer/actionUpdateBasket.php?type=email&id=<?=$id?>" method="POST"> 
                                            <div class="form-group">
                                                <label for="email"></label>
                                                <input type="text" name="email" id="email" class="form-control" value="<?= $data['email']?>">
                                            </div>
                                            <div class="row justify-content-center mt-3">
                                                <div class="col-6"> 
                                                    <input type="submit" value="Update your Email" class="form-control" name="updateEmail">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php $carActs = selectAllCarInGarage($data['garageId']);?>
                                    <div class="p-5" style="background-color: #f8f9fa; ">
                                        <div class="row justify-content-center">
                                            <div class="col mt-1 mb-5">
                                                <h3 class="text-center">Choise other Car</h>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="table-responsive-sm overflow-x-hidden">
                                                <table class="table table-light table-striped table-sm align-middle ">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th scope="col">Brand</th>
                                                            <th scope="col">Model</th>
                                                            <th scope="col">Type</th>
                                                            <th scope="col">Year</th>
                                                            <th scope="col">Price Hourly</th>
                                                            <th scope="col">Price Daily</th>
                                                            <th scope="col">Price Caution</th>
                                                            <th scope="col">Choise Car</th>
                                                        </tr>
                                                    </thead>
                                                    <?php $carOld = getOneRowCarWithTypeAndBrand($data['carId']);?>
                                                    <tbody>
                                                        <tr  class="table-active">
                                                            <td scope="row"><?=$carOld['brandName']?></td>
                                                            <td><?=$carOld['carName']?></td>
                                                            <td><?=$carOld['typeCarName']?></td>
                                                            <td><?=$carOld['carYear']?></td>
                                                            <td><?=$carOld['carTarifHourHT']?></td>
                                                            <td><?=$carOld['carTarifDayHT']?></td>
                                                            <td><?=$carOld['carCaution']?></td>
                                                            <td>Your actuel choise</td>
                                                        </tr>
                                                        <?php foreach($carActs as $carAct):?>
                                                            <?php if($carAct['carId'] != $data['carId'] ):?>
                                                                <tr>
                                                                    <td scope="row"><?=$carAct['brandName']?></td>
                                                                    <td><?=$carAct['carName']?></td>
                                                                    <td><?=$carAct['typeCarName']?></td>
                                                                    <td><?=$carAct['carYear']?></td>
                                                                    <td><?=$carAct['carTarifHourHT']?></td>
                                                                    <td><?=$carAct['carTarifDayHT']?></td>
                                                                    <td><?=$carAct['carCaution']?></td>
                                                                    <td scope="row" colspan="2" class="justify content" >
                                                                        <form action="../../action/customer/actionUpdateBasket.php?type=upadeteCarWithMarket&id=<?=$id?>&type=car&car=<?=$carAct['carId']?>" method="POST">
                                                                            <button type="submit"class="form-control" value="<?= $carAct['brandName'].' '.$carAct['carName']?>" name="updateCar">Choise <?= $carAct['brandName'].' '.$carAct['carName']?></button> 
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            <?php endif;?>
                                                        <?php endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-5 mt-5 mb-5 container-sm px-1" style="background-color: #f8f9fa; width: 60%;">
                                        <?php if($data['typeRental'] == "daily"):?>
                                            <h5 class="text-center">If you want Modify your Date of rents</h5>
                                            <form action="../../action/customer/actionUpdateBasket.php?type=daily&id=<?=$id?>" method="POST">
                                                <div class="form-group">
                                                    <label for="reservationDateStart">Reservation Date Start:</label>
                                                    <input type="date" class="form-control" id="reservationDate" name="reservationDateStart"  min="<?= date('Y-m-d')?>" value="<?= $data['reservationDateStart']?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="reservationDateEnd">Reservation Date End:</label>
                                                    <input type="date" class="form-control" id="reservationDate" name="reservationDateEnd" min="<?= date('Y-m-d',strtotime("+1 day"))?>" value="<?= $data['reservationDateEnd']?>">
                                                </div>
                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-6"> 
                                                        <input type="submit" value="Update Daily Rental" class="form-control" name="valideDateUpadte">
                                                    </div>
                                                </div>
                                            </form>
                                        <?php elseif($data['typeRental'] == "hourly") :?>
                                            <h5 class="text-center">If you want Modify your Hour of rent</h5>
                                            <form action="../../action/customer/actionUpdateBasket.php?type=hourly&id=<?=$id?>" method="POST">
                                                <div class="form-group">
                                                    <label for="reservationDate">Reservation Date:</label>
                                                    <input type="date" class="form-control" id="reservationDate" name="reservationDateStart"  min="<?= date('Y-m-d');?>" value="<?= $data['reservationDate']?>>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="reservationHourStart">Hourly Start:</label>
                                                    <input type="time" class="form-control" id="reservationHourStart" name="reservationHourStart"  min="00:00"  max="24:00" value="<?= $data['reservationHourStart']?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="reservationHourEnd">Hourly End:</label>
                                                    <input type="time" class="form-control" id="reservationHourEnd" name="reservationHourEnd"  min="00:00" max="24:00" value="<?= $data['reservationHourEnd']?>">
                                                </div>
                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-6"> nd
                                                        <input type="submit" value="Update Hour rent" class="form-control" name="valideHourUpdate">
                                                    </div>
                                                </div>
                                            </form>
                                        <?php endif;?>
                                    </div>
                                    <div class="p-5 mt-5 mb-5 container-sm px-1" style="background-color: #f8f9fa; width: 60%;">
                                        <h5 class="text-center">Change daily or hourly rental</h5>
                                        <form action="../../action/customer/actionUpdateBasket.php?type=typerent&id=<?=$id?>" method="POST"> 
                                            <div class="form-group">
                                                <label for="typeRental"></label>
                                                <select class="form-control" id="carModel" name="typeRental">
                                                    <option value="">daily or hourly</option>
                                                    <option value="daily">Daily</option>
                                                    <option value="hourly">Hourly</option>
                                                </select>
                                            </div>
                                            <div class="row justify-content-center mt-3">
                                                <div class="col-6"> 
                                                    <input type="submit" value="Update type of Rental" class="form-control" name="changeTypeRental">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php elseif(!empty($_GET['type']) && ($_GET['type'] == 'daily' || $_GET['type'] == 'hourly')):?>
                                        <div class="p-5 mt-5 mb-5 container-sm px-1" style="background-color: #f8f9fa; width: 60%;">
                                            <?php if($_GET['type'] == "daily"):?>
                                                <h5 class="text-center">If you want Modify your Date of rents</h5>
                                                <form action="../../action/customer/actionUpdateBasket.php?type=hourly&id=<?=$id?>" method="POST">
                                                    <div class="form-group">
                                                        <label for="reservationDateStart">Reservation Date Start:</label>
                                                        <input type="date" class="form-control" id="reservationDate" name="reservationDateStart"  min="<?php echo date('Y-m-d');?>" value="<?=date('Y-m-d')?>>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="reservationDateEnd">Reservation Date End:</label>
                                                        <input type="date" class="form-control" id="reservationDate" name="reservationDateEnd" min="<?php echo date('Y-m-d',strtotime("+1 day"));?>" value="<?php echo date('Y-m-d',strtotime("+1 day"));?>">
                                                    </div>
                                                    <div class="row justify-content-center mt-3">
                                                        <div class="col-8"> 
                                                            <input type="submit" value="Upadte Date" class="form-control" name="updateDate">
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php elseif($_GET['type'] == "hourly") :?>
                                                <h5 class="text-center">If you want Modify your Hour of your rent</h5>
                                                <form action="../../action/customer/actionUpdateBasket.php?type=daily&id=<?=$id?>" method="POST">
                                                    <div class="form-group">
                                                        <label for="reservationDate">Reservation Date:</label>
                                                        <input type="date" class="form-control" id="reservationDate" name="reservationDate"  min="<?php echo date('Y-m-d');?>" value="<?=date('Y-m-d')?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="reservationHourStart">Hourly Start:</label>
                                                        <input type="time" class="form-control" id="reservationHourStart" name="reservationHourStart"  min="00:00"  max="24:00" placeholder="00:00">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="reservationHourEnd">Hourly End:</label>
                                                        <input type="time" class="form-control" id="reservationHourEnd" name="reservationHourEnd"  min="00:00" max="24:00" placeholder="00:00">
                                                    </div>
                                                    <div class="row justify-content-center mt-3">
                                                        <div class="col-8"> 
                                                            <input type="submit" value="Update Hourly" class="form-control" name="updatelHourly">
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php endif;?>
                                        </div>
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
<?php include ('../../layout/footer.php');?>
