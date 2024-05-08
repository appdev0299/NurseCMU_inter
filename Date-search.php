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
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Search Data</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" class="mt-3" id="clear">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="choices-single-default"><b>Country</b></label>
                                                <select class="form-control" name="country" id="country">
                                                    <option value="" data-university="" disabled <?php echo empty($_POST['country']) ? 'selected' : ''; ?>>Show All</option>
                                                    <?php
                                                    require_once 'connect.php';
                                                    $sql = "SELECT DISTINCT country FROM dateinter ORDER BY `dateinter`.`country` ASC";

                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();
                                                    $checkings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($checkings as $checking) {
                                                        $country = $checking['country'];
                                                        $selected = isset($_POST['country']) && $_POST['country'] === $country ? 'selected' : '';
                                                        echo "<option value='$country' data-university='' $selected>$country</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class a="form-label" for="choices-single-default"><b>University</b></label>
                                                <select class="form-control" name="university" id="university">
                                                    <option value="" data-country="" disabled <?php echo empty($_POST['university']) ? 'selected' : ''; ?>>Show All</option>
                                                    <?php
                                                    $sql = "SELECT DISTINCT university, country FROM dateinter";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();
                                                    $checkings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($checkings as $checking) {
                                                        $university = $checking['university'];
                                                        $country = $checking['country'];
                                                        $selected = isset($_POST['university']) && $_POST['university'] === $university ? 'selected' : '';
                                                        echo "<option value='$university' data-country='$country' $selected>$university</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var countrySelect = document.getElementById("country");
                                                var universitySelect = document.getElementById("university");

                                                countrySelect.addEventListener("change", filterUniversities);
                                                universitySelect.addEventListener("change", filterCountries);

                                                function filterUniversities() {
                                                    var selectedCountry = countrySelect.value;
                                                    var universityOptions = universitySelect.options;

                                                    for (var i = 0; i < universityOptions.length; i++) {
                                                        var option = universityOptions[i];
                                                        var optionCountry = option.getAttribute("data-country");

                                                        if (selectedCountry === "" || option.value === "" || optionCountry === selectedCountry) {
                                                            option.style.display = "block";
                                                        } else {
                                                            option.style.display = "none";
                                                        }
                                                    }
                                                }

                                                function filterCountries() {
                                                    var selectedUniversity = universitySelect.value;
                                                    var countryOptions = countrySelect.options;

                                                    for (var i = 0; i < countryOptions.length; i++) {
                                                        var option = countryOptions[i];
                                                        var optionUniversity = option.getAttribute("data-university");

                                                        if (selectedUniversity === "" || option.value === "" || optionUniversity === selectedUniversity) {
                                                            option.style.display = "block";
                                                        } else {
                                                            option.style.display = "none";
                                                        }
                                                    }
                                                }
                                            });
                                        </script>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class a="form-label" for="choices-single-default"><b>Activity Types</b></label>
                                                <select class="form-control" name="activity" id="activity">
                                                    <option value="" data-country="" disabled <?php echo empty($_POST['activity']) ? 'selected' : ''; ?>>Show All</option>
                                                    <?php
                                                    require_once 'connect.php';

                                                    $sql = "SELECT DISTINCT activity FROM tage";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();
                                                    $checkings = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    // วนลูปแสดงตัวเลือกใน dropdown
                                                    foreach ($checkings as $checking) {
                                                        $activity = $checking['activity'];
                                                        // Check if the current option matches the selected value
                                                        $selected = isset($_POST['activity']) && $_POST['activity'] === $activity ? 'selected' : '';
                                                        echo "<option value='$activity' $selected>$activity</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="choices-single-default"><b>Start</b></label>
                                                <input class="form-control" type="date" id="date_s" name="date_s" value="<?php echo isset($_POST['date_s']) ? $_POST['date_s'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="choices-single-default"><b>End</b></label>
                                                <input class="form-control" type="date" id="date_e" name="date_e" value="<?php echo isset($_POST['date_e']) ? $_POST['date_e'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="display_data" class="btn btn-primary">Submit</button>
                                            &nbsp;
                                            <button type="button" id="export_data" class="btn btn-success">Export to excel</button>
                                            &nbsp;
                                            <button type="button" id="clear_data" class="btn btn-danger">Clear</button>
                                        </div>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var clearButton = document.getElementById("clear_data");
                                                clearButton.addEventListener("click", function() {
                                                    var form = document.getElementById("clear");
                                                    var elements = form.elements;

                                                    for (var i = 0; i < elements.length; i++) {
                                                        if (elements[i].type === "text" || elements[i].type === "textarea" || elements[i].type === "date" || elements[i].type === "select-one") {
                                                            elements[i].value = ""; // ล้างค่าข้อมูลในฟิลด์
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </form>
                            <script>
                                document.getElementById("export_data").addEventListener("click", function() {
                                    var start_date = document.getElementById("date_s").value;
                                    var end_date = document.getElementById("date_e").value;
                                    var activity = document.getElementById("activity").value;
                                    var university = document.getElementById("university").value;
                                    var url = "Data_report_db.php?";
                                    if (start_date) {
                                        url += "start_date=" + encodeURIComponent(start_date) + "&";
                                    }
                                    if (end_date) {
                                        url += "end_date=" + encodeURIComponent(end_date) + "&";
                                    }
                                    if (activity) {
                                        url += "activity=" + encodeURIComponent(activity) + "&";
                                    }
                                    if (university) {
                                        url += "university=" + encodeURIComponent(university) + "&";
                                    }
                                    window.location.href = url;
                                });
                            </script>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <?php
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                        if (isset($_POST['display_data'])) {
                                            require_once 'connect.php';

                                            $sql = "SELECT * FROM dateinter WHERE 1=1 ";

                                            if (isset($_POST['date_s']) && !empty($_POST['date_s'])) {
                                                $start_date = $_POST['date_s'];
                                                $sql .= "AND date_s >= :start_date ";
                                            }

                                            if (isset($_POST['date_e']) && !empty($_POST['date_e'])) {
                                                $end_date = $_POST['date_e'];
                                                $sql .= "AND date_e <= :end_date ";
                                            }

                                            if (isset($_POST['activity']) && !empty($_POST['activity'])) {
                                                $selected_activity = $_POST['activity'];
                                                $sql .= "AND activity = :activity ";
                                            }

                                            if (isset($_POST['university']) && !empty($_POST['university'])) {
                                                $selected_university = $_POST['university'];
                                                $sql .= "AND university = :university ";
                                            }
                                            if (isset($_POST['country']) && !empty($_POST['country'])) {
                                                $selected_country = $_POST['country'];
                                                $sql .= "AND country = :country ";
                                            }

                                            $stmt = $conn->prepare($sql);

                                            if (isset($start_date)) {
                                                $stmt->bindParam(':start_date', $start_date);
                                            }

                                            if (isset($end_date)) {
                                                $stmt->bindParam(':end_date', $end_date);
                                            }

                                            if (isset($selected_activity)) {
                                                $stmt->bindParam(':activity', $selected_activity);
                                            }

                                            if (isset($selected_university)) {
                                                $stmt->bindParam(':university', $selected_university);
                                            }
                                            if (isset($selected_country)) {
                                                $stmt->bindParam(':country', $selected_country);
                                            }

                                            $stmt->execute();
                                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    ?>
                                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Start | End</th>
                                                        <th style="width: 60%;">Detail</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($results as $row) : ?>

                                                        <tr>
                                                        <td><?= date('d M Y', strtotime($row['date_s'])); ?> | <?= date('d M Y', strtotime($row['date_e'])); ?>
                                                                <br>
                                                                <?php echo $row['university']; ?>
                                                                <br>
                                                                <span class="badge bg-success"> <?php echo $row['name']; ?></span>
                                                                <br>
                                                                <span class="badge bg-primary"><?= str_replace(',', '<br>', $row['activity']); ?> </span>

                                                            </td>
                                                            <td>
                                                                <div class="flex align-items-center list-user-action">
                                                                    <div class="details-cell" style="max-height: 150px; overflow-y: auto; word-wrap: break-word;">
                                                                        <textarea class="form-control" name="details" style="height: 150px; width: 700px; border: none; resize: none;" disabled><?= $row['details']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="flex align-items-center list-user-action">
                                                                    <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdropLive<?= $row['id']; ?>">
                                                                        <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M15.7161 16.2234H8.49609" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M15.7161 12.0369H8.49609" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M11.2521 7.86011H8.49707" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.909 2.74976C15.909 2.74976 8.23198 2.75376 8.21998 2.75376C5.45998 2.77076 3.75098 4.58676 3.75098 7.35676V16.5528C3.75098 19.3368 5.47298 21.1598 8.25698 21.1598C8.25698 21.1598 15.933 21.1568 15.946 21.1568C18.706 21.1398 20.416 19.3228 20.416 16.5528V7.35676C20.416 4.57276 18.693 2.74976 15.909 2.74976Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                        </span>
                                                                    </a>
                                                                    <a class="btn btn-sm btn-icon btn-warning" href="Date-University-View.php?university_id=<?= $row['university_id']; ?>">
                                                                        <span class="btn-inner">
                                                                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M12.7 11.7488H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7002 16.7498L20.6372 11.7488L12.7002 6.74776V16.7498Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <div class="modal fade" id="staticBackdropLive<?= $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel<?= $row['id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="staticBackdropLiveLabel<?= $row['id']; ?>">Details</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-card text-start">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">University</label>
                                                                                            <input type="text" name="university" value="<?= $row['university']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Department</label>
                                                                                            <?php
                                                                                            require_once 'connect.php';
                                                                                            $universityId = $row['university_id'];
                                                                                            $universityQuery = "SELECT university,department,ranking,mou,signed,expired,country,qs_suject FROM university WHERE university_id = :university_id";
                                                                                            $universityStmt = $conn->prepare($universityQuery);
                                                                                            $universityStmt->bindParam(':university_id', $universityId);
                                                                                            $universityStmt->execute();
                                                                                            $universityRow = $universityStmt->fetch(PDO::FETCH_ASSOC);
                                                                                            $departmentName = $universityRow['department'];
                                                                                            ?>
                                                                                            <input type="text" value="<?= $departmentName; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Ranking</label>
                                                                                            <input type="text" value="<?= $universityRow['ranking']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">qs_suject</label>
                                                                                            <input type="text" value="<?= $universityRow['qs_suject']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">MOU</label>
                                                                                            <input type="text" value="<?= $universityRow['mou']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Country</label>
                                                                                            <input type="text" value="<?= $universityRow['country']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Signed</label>
                                                                                            <input type="text" value="<?= $universityRow['signed']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Expired</label>
                                                                                            <input type="text" value="<?= $universityRow['expired']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>

                                                                                    <hr>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Start</label>
                                                                                            <input type="text" name="date_s" value="<?= $row['date_s']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">End</label>
                                                                                            <input type="text" name="date_e" value="<?= $row['date_e']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Activity</label>
                                                                                            <input type="text" name="activity" value="<?= $row['activity']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Name</label>
                                                                                            <input type="text" name="name" value="<?= $row['name']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">details</label>
                                                                                            <textarea class="form-control" name="details" style="height: 250px" disabled><?= $row['details']; ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                    <?php
                                        } else {
                                            echo "No data found.";
                                        }
                                    }
                                    ?>
                                </div>
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