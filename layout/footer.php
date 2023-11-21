            </div>
            <footer class="bg-light text-center text-lg-start">
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                    © 2023 donkeycar.com
                    <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === "customer") : ?>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-2">
                                <a href="http://donkeycar.com/pages/pageContact.php">Contact</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </footer>
        </div>
    </body>
</html>