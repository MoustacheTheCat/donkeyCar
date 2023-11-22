<?php
require('../action/action.php');
$pageTitle = 'Message List';
include('../layout/header.php');
$messages = getAllData('messages');
?>
<div class="row">
    <div class="col">
        <?php printMessageresponse()?>
    </div>
</div>
<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center" >
            <thead>
                <tr >
                    <th>Status</th>
                    <th>ID</th>
                    <th>Message From</th>
                    <th>Message Subject</th>
                    <th>Message To</th>
                    <th>Message Date</th>
                    <th>Message response</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($messages as $message): ?>
                    <tr>
                        <td>
                            <?php if($message['messageStatus'] == 0) : ?>
                                <span class="badge bg-danger text-white rounded-pill cart-items">Not Open</span>
                            <?php elseif($message['messageStatus'] == 1) : ?>
                                <span class="badge bg-success text-white rounded-pill cart-items">Open</span>
                            <?php endif; ?>
                        </td>
                        <td><a href="http://donkeycar.com/pages/pageDetailMessage.php?id=<?= $message['messageId'] ?>"><?= $message['messageId'] ?></a></td>
                        <td><?= $message['messageFrom'] ?></td>
                        <td><?= $message['messageSubjet'] ?></td>
                        <td><?= $message['messageTo'] ?></td>
                        <td><?= $message['createdAt'] ?></td>
                        <td></td>
                        <td><a href="../action/actionDeleteMessage.php?id=<?=$message['messageId']?>"><span class="badge bg-warning text-white rounded-pill cart-items">&#x2717</span></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('../layout/footer.php');?>
