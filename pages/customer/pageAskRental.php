<?php
require('../../action/action.php');
$cars = getOnCarInGarageByCarId($_GET['id']);
$pageTitle = "Rental the ".$cars['brandName']." ".$cars['carName'];
include('../../layout/header.php');
unset($_SESSION['cardatas']);
?> 
<div class="container mt-5">
    <?php if (empty($_GET['step']) || $_GET['step'] == 'type'):?>
        <form action="../../action/customer/actionAskRental.php?id=<?= $_GET['id'];?>" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <?php if(empty($_GET['step'])) :?>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email">
                <?php elseif($_GET['step'] == 'type') :?>
                    <input type="email" class="form-control" id="email" value="<?= $_SESSION['dataRents']['email'] ?>" name="email">
                <?php endif;?>
            </div>
            <div class="form-group">
                <label for="carModel">Car Model:</label>
                <input type="text" class="form-control" id="carModel" name="carModel" value="<?= $cars['brandName']." ".$cars['carName'];?>" readonly>
            </div>
            <div class="form-group" hidden>
                <label for="carId" ></label>
                <input type="text" class="form-control" id="carModel" name="carId" value="<?= $cars['carId'];?>">
                <label for="carImmatriculation" ></label>
                <input type="text" class="form-control" id="carModel" name="carImmatriculation" value="<?= $cars['carImmatriculation'];?>">
                <label for="carCaution" ></label>
                <input type="text" class="form-control" id="carModel" name="carCaution" value="<?= $cars['carCaution'];?>">
                <label for="garageId" ></label>
                <input type="text" class="form-control" id="carModel" name="garageId" value="<?= $cars['garageId'];?>">
            </div>
            <div class="form-group">
                <label for="typeRental">daily or hourly rental :</label>
                <select class="form-control" id="carModel" name="typeRental">
                    <option value="">daily or hourly</option>
                    <option value="daily">Daily</option>
                    <option value="hourly">Hourly</option>
                </select>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2"> 
                    <input type="submit" value="Rental" class="btn btn-primary" name="validerental">
                </div>
            </div>
        </form>
    <?php endif;?>
    <?php printMessageresponse()?>
    <?php if(!empty($_GET['step']) && ($_GET['step'] == 'daily' || $_GET['step'] == 'hourly')):?>
        <?php if($_GET['step'] == "daily" ):?>
            <form action="../../action/customer/actionAskRental.php?id=<?= $_GET['id'];?>&step=daily" method="POST">
                <div class="form-group">
                    <label for="reservationDateStart">Reservation Date Start:</label>
                    <input type="date" class="form-control" id="reservationDate" name="reservationDateStart"  min="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d');?>">
                </div>
                <div class="form-group">
                    <label for="reservationDateEnd">Reservation Date End:</label>
                    <input type="date" class="form-control" id="reservationDate" name="reservationDateEnd" min="<?php echo date('Y-m-d',strtotime("+1 day"));?>" value="<?php echo date('Y-m-d',strtotime("+1 day"));?>">
                </div>
                <div class="form-group" hidden>
                    <label for="carTarifDayHT" ></label>
                    <input type="text" class="form-control" id="carModel" name="carTarifDayHT" value="<?= $cars['carTarifDayHT'];?>">
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-md-2"> 
                        <input type="submit" value="Rental" class="btn btn-primary" name="validerentalDate">
                    </div>
                </div>
            </form>
        <?php elseif($_GET['step'] == "hourly"):?>
            <form action="../../action/customer/actionAskRental.php?id=<?= $_GET['id'];?>&step=hourly" method="POST">
                <div class="form-group">
                    <label for="reservationDate">Reservation Date:</label>
                    <input type="date" class="form-control" id="reservationDate" name="reservationDate"  min="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d');?>">
                </div>
                <div class="form-group">
                    <label for="reservationHourStart">Hourly Start:</label>
                    <input type="time" class="form-control" id="reservationHourStart" name="reservationHourStart"  min="00:00"  max="24:00" value="00:00">
                </div>
                <div class="form-group">
                    <label for="reservationHourEnd">Hourly End:</label>
                    <input type="time" class="form-control" id="reservationHourEnd" name="reservationHourEnd"  min="00:00" max="24:00" value="00:00">
                </div>
                <div class="form-group" hidden>
                    <label for="carTarifHourHT" ></label>
                    <input type="text" class="form-control" id="carModel" name="carTarifHourHT" value="<?= $cars['carTarifHourHT'];?>">
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-md-2"> 
                        <input type="submit" value="Rental" class="btn btn-primary" name="validerentalDate">
                    </div>
                </div>
            </form>
        <?php endif;?>
    <?php endif;?>
</div>

<?php include('../../layout/footer.php'); ?>

