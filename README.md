# donkeyCar

step 1 create db with user adminDbDonkeyCar :

    Creation of the DonkeyCar database (see donkeyCar.sql)

    create user adminDbDonkeyCar 

        CREATE USER 'adminDbDonkeyCar'@'localhost' IDENTIFIED BY 'password';
        GRANT ALL PRIVILEGES ON donkeyCar.* TO 'adminDbDonkeyCar'@'localhost';
        FLUSH PRIVILEGES;

step 2 Creating the index.php file, the layout folder with the header.php and footer.php files 

step 3 Creating the config folder and _connect.php file, as well as the action folder and the action.php and function files.php

step 4 Creating a tree view of the DonkeyCar project interface and related files :
    layout/
        header.php
        footer.php
    css/
        style.css
    pages/
        pageLogin.php
        pageForgotPasswordRequest.php
        pageForgotPasswordReset.php
        pageProfil.php
        pageEditProfil.php
        pageCreateProfil.php
        pageDashbord.php
        pageListAllMarket.php
        pageDetailCar.php
        pageDetailMarket.php
        customer/
            pageAskRental.php
            pageFollowRental.php
        admin/
            pageListAllCar.php
            pageListGarage.php
            pageListCustomer.php
            pageConfirmRental.php
            pageCheckingBeforeAndAfterRental.php
            pageListRental.php
            pageListMessage.php
            pagedetailMessage.php
            pageSendMessage.php
        superAdmin/
            pageAddCar.php
            pageEditCar.php
            pageAddMarket.php
            pageEditMarket.php
            pageAddGarage.php
            pageEditGarage.php
            pageEditCustomer.php
            pageAddAdmin.php
            pageEditAdmin.php



To be realized -> step 5 Creating an Action Tree for the DonkeyCar Project and Related Files
