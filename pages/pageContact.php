<?php
require('../action/action.php');
$pageTitle = 'Contact Donkey Car';
include('../layout/header.php');
?>
<div class="container-fluid cont">
    <form action="../action/actionSendMessage.php" method="POST">
        <div class="row mb-4">
            <div class="col">
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="fisrtName">First name</label>
                    <input type="text" id="fisrtName" name="fisrtName" class="form-control" />
                </div>
            </div>
            <div class="col">
                <div data-mdb-input-init class="form-outline">
                    <label class="form-label" for="lastname">Last name</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" />
                </div>
            </div>
        </div>
        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" />
        </div>
        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="number">Phone</label>
            <input type="number" id="number" name="number" class="form-control" />
        </div>
        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label select-label" for="subject">Subject</label>
            <select class="form-select" aria-label="Floating label select example" name="subject">
                <option value="">Subject</option>
                <option value="Request information">Request information</option>
                <option value="Follow-up of rental request">Follow-up of rental request</option>
                <option value="Business Proposal">Business Proposale</option>
                <option value="claim">claim</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="message">Your message</label>
            <textarea class="form-control" id="message" name="message" rows="4"></textarea>
        </div>
        <div class="form-check d-flex justify-content-center mb-4">
            <input class="form-check-input me-2" type="checkbox" value="" id="sendCopie" name="sendCopie" />
            <label class="form-check-label" for="sendCopie"> Check this box if you would like a copy of your message </label>
        </div>
        <div class="form-check d-flex justify-content-center mb-4">
            <input type="submit" value="Send your message" data-mdb-ripple-init class="btn btn-primary btn-block mb-4" name="sendMessage">
        </div>
    </form>
</div>


<?php include('../layout/footer.php');?>