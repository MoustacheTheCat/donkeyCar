<?php
require('../../action/action.php');
if($_GET['role'] == 'admin'){
    $pageTitle = 'List of all admin';
    $datas = getAllData('admins');
}elseif($_GET['role'] == 'customer'){
    $pageTitle = 'List of all customer';
    $datas = getAllData('customers');
}
include('../../layout/header.php');
?>
<div class="container mt-5">
    <?php if($_GET['role'] == 'customer'):?>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birth Date</th>
                    <th>Address</th>
                    <th>Zip Code</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Permit Number</th>
                    <th>Edit<th>
                    <th>Delet</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datas as $row) :?>
                    <tr>
                        <td><?= $row['customerFirstName'] ;?></td>
                        <td><?= $row['customerLastName'] ;?></td>
                        <td><?= $row['customerBirthDay'] ;?></td>
                        <td><?= $row['customerAddress'] ;?></td>
                        <td><?= $row['customerZip'] ;?></td>
                        <td><?= $row['customerCity'] ;?></td>
                        <td><?= $row['customerCountry'] ;?></td>
                        <td><?= $row['customerEmail'] ;?></td>
                        <td><?= $row['customerNumber'] ;?></td>
                        <td><?= $row['customerNumberPermit'] ;?></td>
                        <td><a href="http://donkeycar.com/pages/pageEditProfil.php?role=customer&id=<?= $row['customerId'] ;?>">Edit</a></td>
                        <td><a href="http://donkeycar.com/action/actionDelete.php?role=customer&id=<?= $row['customerId'] ;?>&step=1">Delete</a></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php elseif($_GET['role'] == 'admin'):?>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Edit<th>
                        <th>Delet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datas as $row) :?>
                        <tr>
                            <td><?= $row['adminFirstName'] ;?></td>
                            <td><?= $row['adminLastName'] ;?></td>
                            <td><?= $row['adminEmail'] ;?></td>
                            <td><a href="http://donkeycar.com/pages/pageEditProfil.php?role=admin&id=<?= $row['adminId'] ;?>">Edit</a></td>
                            <td><a href="http://donkeycar.com/action/actionDelete.php?role=admin&id=<?= $row['adminId'] ;?>&step=1">Delete</a></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        <?php endif;?>
    </div>
<?php
// [adminId] => 17 [adminFirstName] => mathieu [adminLastName] => joubert [adminPassword] => $argon2i$v=19$m=65536,t=4,p=1$aDJ4NVEyZGhNVThnRENCTw$HR+XQmRmsj52F6iKNpZYFxAXhBSMk3Xk31bIsnIvOn8 [adminEmail] => joubert.mathieu753783@gmail.com [adminRole] => 1 [createdAt] => 2023-11-20 01:22:14 [updatedAt] => 2023-11-20 01:22:14 ) 
// [customerId] => 2 [customerFirstName] => Alexandre [customerLastName] => Syla [customerBirthDay] => 2005-11-02 [customerAddress] => 29 rue du ruisseau [customerZip] => 93100 [customerCity] => Montreuil [customerCountry] => France [customerPassword] => $argon2i$v=19$m=65536,t=4,p=1$aGpQSm52a0QuRXJEbjl0cw$hGKlBJR028dn+Es671QZ6DzSVAqdW/W5tubVBxQHIt8 [customerEmail] => lacrima0@gmail.com [customerNumber] => 601010101 [customerNumberPermit] => 125356450548 [createdAt] => 2023-11-19 19:39:39 [updatedAt] => 2023-11-19 19:39:39
?>
<?php include('../../layout/footer.php'); ?>