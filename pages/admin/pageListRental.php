<?php
require('../../action/action.php');
$pageTitle = 'List of all rental';
include('../../layout/header.php');
$id = $_SESSION['user']['id'];
$dataRents = getValidRent($id);

?>

<div class="container mt-5">
    <table class="table table-responsive table-striped">
        <thead>
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
                <th>Summary</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataRents as $dataRent) :?>
                <tr>
                    <td><a href="http://donkeycar.com/pages/pageDetailRent.php?id=<?= $dataRent['locationId'] ?>"><?= $dataRent['locationId'] ?></a></td>
                    <td><a href="http://donkeycar.com/pages/pageProfil.php?role=customer&id=<?= $dataRent['customerId']?>"><?= printCustomerName($dataRent['customerId']) ?></a></td>
                    <td><?= printMarketName($dataRent['marketId']) ?></td>
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
                    <td><?= $dataRent['locationStatus'] ?></td>
                    <td><?= $dataRent['locationResume'] ?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>


<? include('../../layout/footer.php'); ?>
