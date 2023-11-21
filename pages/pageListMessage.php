<?php
require('../action/action.php');
$pageTitle = 'Message List';
include('../layout/header.php');
$messages = getAllData('messages');
?>
<div class="container mt-5">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Message ID</th>
                <th>Message From</th>
                <th>Message Subject</th>
                <th>Message To</th>
                <th>Message Text</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($messages as $message): ?>
                <tr>
                    <td><a href="http://donkeycar.com/pages/pageDetailMessage.php?id=<?= $message['messageId'] ?>"><?= $message['messageId'] ?></a></td>
                    <td><?= $message['messageFrom'] ?></td>
                    <td><?= $message['messageSubjet'] ?></td>
                    <td><?= $message['messageTo'] ?></td>
                    <td><?= $message['messageText'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include('../layout/footer.php');?>
