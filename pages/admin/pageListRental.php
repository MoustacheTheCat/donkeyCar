<?php
require('../../action/action.php');
$pageTitle = 'List of all rental';
include('../../layout/header.php');
$id = $_SESSION['user']['id'];
print_r($id);
$dataRents = getValidRent($id);

?>

<div class="container mt-5">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Location ID</th>
                <th>Customer Name</th>
                <th>Market Name</th>
                <th>Car Brand</th>
                <th>Car Model</th>
                <th>Rent Type</th>
                <th>Duration</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Hour Start</th>
                <th>Hour End</th>
                <th>Cost of VAT</th>
                <th>Total HT</th>
                <th>Total TTC</th>
                <th>Caution Cost</th>
                <th>Status</th>
                <th>Valide</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($dataRents as $dataRent) :?>
                <tr>
                    <td><a href="http://donkeycar.com/pages/pageDetailRental.php?id=<?= $dataRent['locationId'] ?>"><?= $dataRent['locationId'] ?></a></td>
                    <td><a href="http://donkeycar.com/pages/pageProfil.php?role=customer&id=<?= $dataRent['customerId']?>"><?= printCustomerName($dataRent['customerId']) ?></a></td>
                    <td> <a href="http://donkeycar.com/pages/admin/pageDetailMarketGarage.php?id=<?=$dataRent['marketId']?>&type=market"><?= printMarketName($dataRent['marketId']) ?></a></td>
                    <td><?= $dataRent['brandName'] ?></td>
                    <td><a href="http://donkeycar.com/pages/pageDetailCar.php?id=<?= $dataRent['carId'] ?>"><?= $dataRent['carName'] ?></a></td>
                    <td><?= $dataRent['locationType'] ?></td>
                    <?php if($dataRent['locationType'] == 'hourly'): ?>
                        <?php if($dataRent['locationDuration'] > 1):?>
                            <td><?= $dataRent['locationDuration'] ?> Hours</td>
                        <?php else:?>
                            <td><?= $dataRent['locationDuration'] ?> Hour</td>
                        <?php endif;?>
                        <td><?= $dataRent['locationDate'] ?></td>
                        <td>/</td>
                        <td><?= $dataRent['locationHourStart'] ?></td>
                        <td><?= $dataRent['locationHourEnd'] ?></td>
                    <?php elseif($dataRent['locationType'] == 'daily'): ?>
                        <?php if($dataRent['locationDuration'] > 1):?>
                            <td><?= $dataRent['locationDuration'] ?> days</td>
                        <?php else:?>
                            <td><?= $dataRent['locationDuration'] ?> day</td>
                        <?php endif;?>
                        <td><?= $dataRent['locationDateStart'] ?></td>
                        <td><?= $dataRent['locationDateEnd'] ?></td>
                        <td>/</td>
                        <td>/</td>
                    <?php endif;?>
                    <td><?= $dataRent['locationCostOfTVA'] ?></td>
                    <td><?= $dataRent['locationTotalHT'] ?></td>
                    <td><?= $dataRent['locationTotalTTC'] ?></td>
                    <td><?= $dataRent['locationCostCaution'] ?></td>
                    <?php if($dataRent['locationStatus'] == 0):?>
                        <td><span class="badge bg-success text-white rounded-pill cart-items">&#x2713</span></td>
                        <td></td>
                    <?php elseif($dataRent['locationStatus'] == 1):?>
                        <td><span class="badge bg-warning text-white rounded-pill cart-items">?</span></td>
                            <td>
                                <a href="../../action/admin/actionConfirmRental.php?type=yes&id=<?=$dataRent['locationId']?>">&#x2705 </a>
                                <a href="../../action/admin/actionConfirmRental.php?type=no&id=<?=$dataRent['locationId']?>"> &#x274C</a>
                            </td>
                    <?php elseif($dataRent['locationStatus'] == 2):?>
                        <td><span class="badge bg-danger text-white rounded-pill cart-items">&#x2717</span></td>
                        <td></td>
                    <?php endif;?>
                    
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>


<? include('../../layout/footer.php'); ?>
