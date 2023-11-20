<?php
require('../../action/action.php');
$pageTitle = 'List of all cars';
include('../../layout/header.php');
$dataMarketsGarages = getAllMarketWithGarage();
?>
<div class="container mt-5">
    <h2 class="mb-4">Car Details</h2>
    <table class="table table-bordered">
    <table class="table">
    <thead>
        <tr>
            <th>Market Name</th>
            <th>Market City</th>
            <th>Market Address</th>
            <th>Postal Code</th>
            <th>Country</th>
            <th>Garage Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($dataMarketsGarages as $dataMarketsGarage): ?>
            <tr>
                <td><a href="../admin/pageDetailMarketGarage.php?id=<?= $dataMarketsGarage['marketId'] ?>&type=market"><?= $dataMarketsGarage['marketName'] ?></a></td>
                <td><?= $dataMarketsGarage['marketCity'] ?></td>
                <td><?= $dataMarketsGarage['marketAdress'] ?></td>
                <td><?= $dataMarketsGarage['marketZip'] ?></td>
                <td><?= $dataMarketsGarage['marketCountry'] ?></td>
                <td><a href="../admin/pageDetailMarketGarage.php?id=<?= $dataMarketsGarage['garageId'] ?>&type=garage"><?= $dataMarketsGarage['garageName'] ?></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </table>
</div>
<?php include('../../layout/footer.php');?>


