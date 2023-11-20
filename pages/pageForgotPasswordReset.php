<?php  if(!empty($_GET['email']) && !empty($_GET['id'])) :?>
    <?php
        require('../action/action.php');
        $pageTitle = "Reset Password";
        include('../layout/header.php');
        $tabGet = array();
        $tabGet['email'] = $_GET['email'];
        $tabGet['id'] = $_GET['id'];
        $_SESSION['tabGet'] = $tabGet;
    ?>
    <div class="container mt-5">
        <form action ="../action/actionForgotPasswordReset.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter your email" name="email">
            </div>
            <div class="form-group">
                <label for="customerPassword">Password:</label>
                <input type="password" class="form-control" id="customerPassword" name="customerPassword" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="customerPasswordConfirm">Password Confirme:</label>
                <input type="password" class="form-control" id="customerPassword" name="customerPasswordConfirm" placeholder="Enter password Confirm">
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-2">
                    <input type="submit" value="Send" class="btn btn-primary" name="sendForgotPasswordReset">
                </div>
            </div>
        </form>
    </div>
    <?php include('../layout/footer.php'); ?>
<?php else :?>
    <?php
        $_SESSION['messageResponce'] = "Method not allowed";
        header('Location: ../404.php');
    ?>
<?php endif; ?>


