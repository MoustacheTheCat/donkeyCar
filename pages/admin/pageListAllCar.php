<?php
require('../../action/action.php');
$pageTitle = 'List of all cars';
include('../../layout/header.php');
$dataCars = getAllCarWithDetailGarageAndMarketDetail();

?>
<div class="container-fluid">
    <h2 class="mb-4">Car Details</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Immatriculation</th>
                <th>Year</th>
                <th>Hourly Rate (HT)</th>
                <th>Daily Rate (HT)</th>
                <th>Deposit</th>
                <th>Availability</th>
                <th>Rental Start</th>
                <th>Rental End</th>
                <th>Type</th>
                <th>Brand</th>
                <th>Garage</th>
                <th>Market</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dataCars as $dataCar):?>
                <tr>
                    <td><a href="../pageDetailCar.php?id=<?=$dataCar['carId']?>"><?= $dataCar['carName'] ?></a></td>
                    <td><?= $dataCar['carImmatriculation'] ?></td>
                    <td><?= $dataCar['carYear'] ?></td>
                    <td><?= $dataCar['carTarifHourHT'] ?></td>
                    <td><?= $dataCar['carTarifDayHT'] ?></td>
                    <td><?= $dataCar['carCaution'] ?></td>
                    <td><?= $dataCar['garargeCarDisponibility'] ? 'Yes' : 'No' ?></td>
                    <td><?= $dataCar['garargeCarLocationDateStart'] ?: '-' ?></td>
                    <td><?= $dataCar['garargeCarLocationDateEnd'] ?: '-' ?></td>
                    <td><?= $dataCar['typeCarName'] ?></td>
                    <td><?= $dataCar['brandName'] ?></td>
                    <td><?= $dataCar['garageName'] ?></td>
                    <td><a href="../admin/pageDetailMarketGarage.php?id=<?= $dataCar['marketId']?>&type=market"><?= $dataCar['marketName'] ?></a></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<?php include('../../layout/footer.php');?>


