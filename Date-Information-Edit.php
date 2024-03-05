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
        <!--Nav End-->
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Edit University Information</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" class="mt-3 text-center">
                                    <?php
                                    require_once 'connect.php'; // เรียกไฟล์ connect.php ไว้ด้านบนเพื่อให้สามารถเชื่อมต่อฐานข้อมูลได้

                                    if (isset($_GET['id'])) {
                                        $stmt = $conn->prepare("SELECT * FROM dateinter WHERE id = ?");
                                        $stmt->execute([$_GET['id']]);
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if ($stmt->rowCount() < 1) {
                                            header('Location: index.php');
                                            exit();
                                        }
                                    }
                                    ?>
                                    <div class="form-card text-start">
                                        <div class="row">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <input type="hidden" name="university_id" value="<?= $row['university_id']; ?>">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">University</label>
                                                    <input type="text" name="university" required value="<?= $row['university']; ?>" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Start</label>
                                                    <input type="date" name="date_s" required value="<?= $row['date_s']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">End</label>
                                                    <input type="date" name="date_e" required value="<?= $row['date_e']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Activities</label>
                                                    <input type="text" name="activity" required value="<?= $row['activity']; ?>" class="form-control" readonly>
                                                </div>
                                            </div>

                                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
                                            <?php
                                            if (isset($_GET['id'])) {
                                                require_once 'connect.php';
                                                $stmt = $conn->prepare("SELECT* FROM dateinter WHERE id=?");
                                                $stmt->execute([$_GET['id']]);
                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() < 1) {
                                                    header('Location: index.php');
                                                    exit();
                                                }
                                            } //isset
                                            ?>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Name Surname</label>
                                                    <input type="text" name="name" value="<?= $row['name']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Details</label>
                                                    <textarea class="form-control" name="details" style="height: 250px"><?= $row['details']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group float-end">
                                        <button type="submit" class="btn btn-primary" name="update">Submit</button>
                                        <a href="#" class="btn btn-danger" onclick="window.history.back();">Back</a>
                                    </div>
                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        require_once 'Date-Information-Edit-db.php';
                                        // echo '<pre>';
                                        // print_r($_POST);
                                        // echo '</pre>';
                                    }
                                    ?>
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