<?php
require_once 'session.php'
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
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">View University Information</h4>
                                </div>

                            </div>
                            <?php
                            if (isset($_GET['id'])) {
                                require_once 'connect.php';
                                $stmt = $conn->prepare("SELECT* FROM dateinter WHERE id=?");
                                $stmt->execute([$_GET['id']]);
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                //ถ้าคิวรี่ผิดพลาดให้กลับไปหน้า index
                                if ($stmt->rowCount() < 1) {
                                    header('Location: index.php');
                                    exit();
                                }
                            } //isset
                            ?>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <input type="text" name="id" value="<?= $row['id']; ?>" hidden>
                                        <input type="text" name="university_id" value="<?= $row['university_id']; ?>" hidden>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="University">University</label>
                                            <input type="text" class="form-control" value="<?= $row['university']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="name">Name Surname</label>
                                            <input type="text" class="form-control" value="<?= $row['name']; ?>"" readonly>
                                        </div>
                                        <div class=" form-group col-6">
                                            <label class="form-label" for="date_s">Start</label>
                                            <input type="date" class="form-control" value="<?= $row['date_s']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="date_e">End</label>
                                            <input type="date" class="form-control" value="<?= $row['date_e']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="form-label" for="activity">Activity</label>
                                            <input type="text" class="form-control" value="<?= $row['activity']; ?>" readonly>
                                        </div>

                                        <div class=" form-group col-12">
                                            <label class="form-label" for="details">Activity details</label>
                                            <textarea readonly class="form-control" name="details" style="height: 350px"><?= $row['details']; ?></textarea>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-danger float-end" onclick="window.history.back();">Back</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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