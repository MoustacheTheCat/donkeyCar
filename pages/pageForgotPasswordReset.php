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
    <?php printMessageresponse()?>
        <section class="gradient-custom">
            <div class="container py-5 ">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase">Reset your password</h2>
                                    <form action ="../action/actionForgotPasswordReset.php" method="POST">
                                        <div class="form-outline form-white mb-4">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="text" class="form-control" id="email" placeholder="Enter your email" name="email" class="form-control form-control-lg">
                                        </div>
                                        <div class="form-outline form-white mb-4">
                                            <input type="password" id="typePasswordX" class="form-control form-control-lg" id="password" placeholder="Enter your new password" name="customerPassword" />
                                            <label class="form-label" for="customerPasswor">Password</label>
                                        </div>
                                        <div class="form-outline form-white mb-4">
                                            <input type="password" id="typePasswordX" class="form-control form-control-lg"  id="password" placeholder="Enter your new password Confirm" name="customerPasswordConfirm" />
                                            <label class="form-label" for="customerPasswordConfirm">Password</label>
                                        </div>
                                        <button class="btn btn-outline-light btn-lg px-5" type="submit" name="sendForgotPasswordReset">Reset your password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include('../layout/footer.php'); ?>
<?php else :?>
    <?php
        $_SESSION['messageError'] = "Method not allowed";
        header('Location: ../404.php');
    ?>
<?php endif; ?>


