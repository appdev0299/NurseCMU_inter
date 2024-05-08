<?php
//require_once 'session.php'
?>
<!doctype html>
<html lang="en" dir="ltr">

<?php require_once 'head.php' ?>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <?php require_once 'sidebar.php' ?>

    <main class="main-content">
        <div class="position-relative iq-banner">
            <?php require_once 'Nav.php' ?>
        </div>
        <!--Nav End-->
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">New University</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" class="mt-3 text-center">
                                    <?php
                                    if (isset($_GET['university_id'])) {
                                        require_once 'connect.php';
                                        $stmt = $conn->prepare("SELECT * FROM university WHERE university_id=?");
                                        $stmt->execute([$_GET['university_id']]);
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $university = $row['university'];
                                    }
                                    ?>
                                    <div class="form-card text-start">
                                        <div class="row">
                                            <input type="text" name="university_id" value="<?= $row['university_id']; ?>" hidden>
                                            <input type="text" name="university_name" value="<?= $row['university']; ?>" hidden>
                                            <input type="text" name="department" value="<?= $row['department']; ?>" hidden>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Start *</label>
                                                    <input type="date" name="date_s" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">End *</label>
                                                    <input type="date" name="date_e" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Activity types *</label>
                                                    <div class="col-6 justify-content-center align-items-center">
                                                        <select name="activity[]" data-placeholder="Choose" multiple class="js-select2" tabindex="5">
                                                            <option value="" label="default"></option>
                                                            <option>Study visitors (Pay)</option>
                                                            <option>Training Course</option>
                                                            <option>Student Exchange</option>
                                                            <option>Visiting Scholar</option>
                                                            <option>Special Lecture</option>
                                                            <option>Sign MOU/MOA</option>
                                                            <option>Academic Collaboration Negotiation</option>
                                                            <option>Cooperation in foreign countries</option>
                                                            <option>Co-research</option>
                                                            <option>Seminar/meeting</option>
                                                            <option>Visiturs</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <script src="js/jquery.min.js"></script>
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
                                                <script src="js/main.js"></script>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Name Surname *</label>
                                                    <input type="text" name="name" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Details *</label>
                                                    <textarea class="form-control" name="details" style="height: 150px"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary  action-button float-end">Submit</button>
                                </form>
                                <!-- <?php echo '<pre>';
                                        print_r($_POST);
                                        echo '</pre>';
                                        ?> -->
                                <?php require_once 'Date-Information-Add-db.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Section Start -->

    </main>

    <!-- Library Bundle Script -->
    <script src="assets/js/core/libs.min.js"></script>

    <!-- External Library Bundle Script -->
    <script src="assets/js/core/external.min.js"></script>

    <!-- Widgetchart Script -->
    <script src="assets/js/charts/widgetcharts.js"></script>

    <!-- mapchart Script -->
    <script src="assets/js/charts/vectore-chart.js"></script>
    <script src="assets/js/charts/dashboard.js"></script>

    <!-- fslightbox Script -->
    <script src="assets/js/plugins/fslightbox.js"></script>

    <!-- Settings Script -->
    <script src="assets/js/plugins/setting.js"></script>

    <!-- Slider-tab Script -->
    <script src="assets/js/plugins/slider-tabs.js"></script>

    <!-- Form Wizard Script -->
    <script src="assets/js/plugins/form-wizard.js"></script>

    <!-- AOS Animation Plugin-->
    <script src="assets/vendor/aos/dist/aos.js"></script>

    <!-- App Script -->
    <script src="assets/js/hope-ui.js" defer></script>
</body>

</html>