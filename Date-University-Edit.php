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
                                    <h4 class="card-title">Edit University Information</h4>
                                </div>
                            </div>
                            <?php
                            if (isset($_GET['university_id'])) {
                                require_once 'connect.php';
                                $stmt = $conn->prepare("SELECT * FROM university WHERE university_id = ?");
                                $stmt->execute([$_GET['university_id']]);
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                if ($stmt->rowCount() < 1) {
                                    header('Location: index.php');
                                    exit();
                                }
                            } else {
                                header('Location: index.php');
                                exit();
                            }
                            ?>
                            <div class="card-body">
                                <form method="post" class="mt-3 text-center">
                                    <div class="form-card text-start">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">University:</label>
                                                    <input type="text" name="university" value="<?= $row['university']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Department of:</label>
                                                    <input type="text" name="department" value="<?= $row['department']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">QS Ranking:</label>
                                                    <input type="text" name="ranking" value="<?= $row['ranking']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">QS Ranking by Subject:</label>
                                                    <input type="text" name="qs_subject" value="<?= $row['qs_suject']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOU/MOA:</label>
                                                    <select name="mou" class="form-control">
                                                        <option value="<?= $row['mou']; ?>"><?= $row['mou']; ?></option>
                                                        <option value="YES">YES</option>
                                                        <option value="NO">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Signed:</label>
                                                    <input type="date" name="signed" value="<?= $row['signed']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Expired:</label>
                                                    <input type="date" name="expired" value="<?= $row['expired']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Country:</label>
                                                    <input type="text" name="country" value="<?= $row['country']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Specialization:</label>
                                                    <input type="text" name="spec" value="<?= $row['spec']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Comments: *</label>
                                                    <textarea class="form-control" name="comments_u" style="height: 150px"><?= $row['comments_u']; ?></textarea>
                                                </div>
                                            </div>
                                            <h8>Update : <?= $row['dateCreate']; ?></h8>
                                            <h8>by : <?= $row['reg_by']; ?></h8>
                                            <input type="hidden" name="university_id" value="<?= $row['university_id']; ?>">
                                            <input type="hidden" name="dateCreate" value="<?= date('Y-m-d H:i:s'); ?>">
                                            <input type="hidden" name="reg_by" value="Nest">
                                        </div>
                                    </div>
                                    <div class="form-group float-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" class="btn btn-danger" onclick="window.history.back();">Back</a>
                                    </div>
                                    <?php
                                    require_once 'Date-University-Edit-db.php';
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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