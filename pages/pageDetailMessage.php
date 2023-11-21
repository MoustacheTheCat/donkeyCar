<?php
require('../action/action.php');
$pageTitle = 'Message';
$message =messageRead($_GET['id'], $_SESSION['user']['id']);

include('../layout/header.php');
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
            <tr>
                <td><?= $message['messageId'] ?></td>
                <td><?= $message['messageFrom'] ?></td>
                <td><?= $message['messageSubjet'] ?></td>
                <td><?= $message['messageTo'] ?></td>
                <td><?= $message['messageText'] ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php include('../layout/footer.php');?>