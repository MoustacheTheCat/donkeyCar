
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title><?php echo $pageTitle;?></title>
</head>
<body>
    <div class="container-fluid cont">
        <header class="container-fluid cont">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid cont">
                    <a class="navbar-brand" href="http://donkeycar.com/index.php" ><img src="https://www.donkeycar.com/uploads/7/8/1/7/7817903/published/donkeycar-logo-sideways.png?1557205931" alt="" srcset=""></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ms-auto nav-mr">
                            <?php if(empty($_SESSION['user']) || empty($_SESSION['user']['role'])):?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="http://donkeycar.com/pages/pageLogin.php">Login</a>
                                    </li>
                            <?php endif;?>      
                            <?php if(!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'):?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Car</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCar">
                                        <li><a class="dropdown-item" href="http://donkeycar.com/pages/admin/pageListAllCar.php?role=<?= $_SESSION['user']['role']?>">Car</a></li>
                                        <li><a class="dropdown-item" href="http://donkeycar.com/pages/admin/pageAddCar.php?id=<?= $_SESSION['user']['id']?>&role=<?= $_SESSION['user']['role']?>">Add Car</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Market</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarket">
                                        <li><a class="dropdown-item" href="http://donkeycar.com/pages/admin/pageListMarket.php?role=<?= $_SESSION['user']['role']?>">Market and Garage</a></li>
                                        <li><a class="dropdown-item" href="http://donkeycar.com/pages/admin/pageAddGarageMarket.php?id=<?= $_SESSION['user']['id']?>&role=<?= $_SESSION['user']['role']?>">Add Market and Garage</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Rental</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCar">
                                        <li><a class="dropdown-item" href="http://donkeycar.com/pages/admin/pageListRental.php?role=<?= $_SESSION['user']['role']?>">Rental</a></li>
                                    </ul>
                                </li>
                                <?php if($_SESSION['user']['roleType'] == 'superAdmin'):?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin and Customer</a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarket">
                                            <li><a class="dropdown-item" href="http://donkeycar.com/pages/admin/pageListUser.php?role=admin">List admin</a></li>
                                            <li><a class="dropdown-item" href="http://donkeycar.com/pages/pageCreateProfil.php?role=admin">Add Admin</a></li>
                                            <li><a class="dropdown-item" href="http://donkeycar.com/pages/admin/pageListUser.php?role=customer">List Customer</a></li>
                                            <li><a class="dropdown-item" href="http://donkeycar.com/pages/pageCreateProfil.php?role=customer">Add Customer</a></li>
                                        </ul>
                                    </li>
                                <?php endif;?> 
                            <?php endif;?> 
                            <?php if(!empty($_SESSION['user']['role']) && ($_SESSION['user']['role'] == 'admin' ||$_SESSION['user']['role'] == 'customer')):?>
                                <li class="nav-item dropdown mr-5 pr-5">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMarket" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Profil<?php if(countMessageNoRead() != 0):?>
                                            <span class="badge bg-dark text-white rounded-pill cart-items"><?= countMessageNoRead()?></span>
                                        <?php endif;?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarket">
                                        <?php if(empty($_SESSION)|| (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin')):?>
                                            <li>
                                                <a class="dropdown-item" href="http://donkeycar.com/pages/pageListMessage.php">
                                                <?php if(countMessageNoRead() != 0):?>
                                                    <span class="badge bg-dark text-white rounded-pill cart-items"><?= countMessageNoRead()?></span>
                                                <?php endif;?>
                                                Message
                                                </a>
                                            </li>
                                        <?php endif;?>
                                        <?php if($_SESSION['user']['role'] == 'customer') :?>
                                            <li><a class="dropdown-item" href="http://donkeycar.com/pages/pagesListRental.php?role=customer"> My Rental</a></li>
                                        <?php endif;?>
                                        <li><a class="dropdown-item" href="http://donkeycar.com/pages/pageProfil.php?role=<?= $_SESSION['user']['role']?>&id=<?= $_SESSION['user']['id']?>">Profil</a></li>
                                        <li><a class="dropdown-item" href="http://donkeycar.com/action/actionLogout.php">Logout</a></li>
                                    </ul>
                                </li>
                            <?php endif;?> 
                            <?php if(empty($_SESSION)|| (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] != 'admin') || empty($_SESSION['user']['role'])):?>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://donkeycar.com/pages/pagesBasket.php">Panier <i class="bi bi-cart"></i>
                                        <?php if(!empty($_SESSION['allDataRents'])):?>
                                            <span class="badge bg-dark text-white rounded-pill cart-items"><?= $_SESSION['nbDataRent']?></span>
                                        <?php endif;?>
                                    </a>
                                </li>
                            <?php endif;?>   
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container-fluid cont">
            <div class="row home-img">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <h1 class="text-center color-home m-5 p-5"><?php echo $pageTitle;?></h1>
                    </div>
                </div>
            </div>

    