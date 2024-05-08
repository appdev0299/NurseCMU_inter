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
            <div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">University Information</h4>
                                </div>

                            </div>
                            <?php
                            if (isset($_GET['university_id'])) {
                                require_once 'connect.php';
                                $stmt = $conn->prepare("SELECT * FROM university WHERE university_id=?");
                                $stmt->execute([$_GET['university_id']]);
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                $university = $row['university'];
                            }
                            ?>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label" for="University">University</label>
                                            <input type="text" class="form-control" value="<?= $row['university']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="Department">Department</label>
                                            <input type="text" class="form-control" value="<?= $row['department']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="Country">Country</label>
                                            <input type="text" class="form-control" value="<?= $row['country']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="QS Ranking">QS Ranking</label>
                                            <input type="text" class="form-control" value="<?= $row['ranking']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="QS Ranking by Subject">QS Ranking by Subject</label>
                                            <input type="text" class="form-control" value="<?= $row['qs_suject']; ?>" readonly>
                                        </div>
                                        <div class=" form-group col-6">
                                            <label class="form-label" for="Specialization">Specialization</label>
                                            <input type="text" class="form-control" value="<?= $row['spec']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="Comments">Comments</label>
                                            <input type="text" class="form-control" value="<?= $row['comments_u']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="MOU/MOA">MOU/MOA</label>
                                            <input type="text" class="form-control" value="<?= $row['mou']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label" for="Active">Date MOU(D/M/Y)</label>
                                            <?php
                                            $signed = !empty($row['signed']) ? date('d/m/Y', strtotime($row['signed'])) : '';
                                            $expired = !empty($row['expired']) ? date('d/m/Y', strtotime($row['expired'])) : '';

                                            echo "<input type='text' class='form-control' value='$signed To $expired' readonly>";
                                            ?>
                                        </div>

                                        <div class="form-group col-6">
                                            <label class="form-label" for="expired">Expired</label>
                                            <?php
                                            if (!empty($row['expired'])) {
                                                $expiredTimestamp = strtotime($row['expired']);
                                                $currentTimestamp = time();

                                                if ($currentTimestamp < $expiredTimestamp) {
                                                    $remainingDays = ceil(($expiredTimestamp - $currentTimestamp) / (60 * 60 * 24));

                                                    // Calculate years, months, days
                                                    $years = floor($remainingDays / 365);
                                                    $remainingDays %= 365;
                                                    $months = floor($remainingDays / 30);
                                                    $days = $remainingDays % 30;

                                                    $remainingLabel = "";
                                                    if ($years > 0) {
                                                        $remainingLabel .= "$years years";
                                                    }
                                                    if ($months > 0) {
                                                        if (!empty($remainingLabel)) {
                                                            $remainingLabel .= ", ";
                                                        }
                                                        $remainingLabel .= "$months months";
                                                    }
                                                    if ($days > 0) {
                                                        if (!empty($remainingLabel)) {
                                                            $remainingLabel .= ", ";
                                                        }
                                                        $remainingLabel .= "$days days";
                                                    }

                                                    echo "<input type='text' class='form-control text-danger' value='$remainingLabel remaining' readonly>";
                                                } else {
                                                    echo "<input type='text' class='form-control text-danger' value='Expired' readonly>";
                                                }
                                            } else {
                                                echo "<input type='text' class='form-control text-danger' value='Not registered' readonly>";
                                            }
                                            ?>
                                        </div>
                                        <h8>Update : <?= $row['dateCreate']; ?></h8>
                                        <h8>by : <?= $row['reg_by']; ?></h8>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-10">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Information</h4>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdropLive">
                                        Add Information
                                    </button>
                                    <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="View" href="pdf_export_all.php?university_id=<?= isset($_GET['university_id']) ? $_GET['university_id'] : ''; ?>&ACTION=VIEW" target="_blank">
                                        Export to pdf
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="new-user-info">
                                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Start | End</th>
                                                <th style="width: 60%;">Detail</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'connect.php';
                                            $stmt = $conn->prepare("SELECT * FROM dateinter WHERE university_id = :university_id ORDER BY date_s DESC");
                                            $stmt->bindParam(':university_id', $row['university_id'], PDO::PARAM_STR);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll();
                                            $countrow = 1;
                                            foreach ($result as $t1) {
                                            ?>
                                                <tr>
                                                    <td> <?= $countrow ?></td>
                                                    <td><?= date('d M Y', strtotime($t1['date_s'])); ?> | <?= date('d M Y', strtotime($t1['date_e'])); ?>
                                                        <br>
                                                        <span class="badge bg-success"><?= ($t1['name']); ?></span>
                                                        <br>
                                                        <span class="badge bg-primary"><?= str_replace(',', '<br>', $t1['activity']); ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="flex align-items-center list-user-action">
                                                            <div class="details-cell" style="max-height: 150px; overflow-y: auto; word-wrap: break-word;">
                                                                <textarea class="form-control" name="comments_u" style="height: 150px; width: 800px; border: none; resize: none;" disabled><?= $t1['details']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="flex align-items-center list-user-action">
                                                            <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdropLive<?= $t1['id']; ?>"> <span class="btn-inner">
                                                                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7379 2.76175H8.08493C6.00493 2.75375 4.29993 4.41175 4.25093 6.49075V17.2037C4.20493 19.3167 5.87993 21.0677 7.99293 21.1147C8.02393 21.1147 8.05393 21.1157 8.08493 21.1147H16.0739C18.1679 21.0297 19.8179 19.2997 19.8029 17.2037V8.03775L14.7379 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M14.4751 2.75V5.659C14.4751 7.079 15.6231 8.23 17.0431 8.234H19.7981" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M14.2882 15.3584H8.88818" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12.2432 11.606H8.88721" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                            <div class="modal fade" id="staticBackdropLive<?= $t1['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel<?= $row['id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="staticBackdropLiveLabel<?= $t1['id']; ?>">Details</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-card text-start">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">University</label>
                                                                                            <input type="text" name="university" value="<?= $t1['university']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Activity</label>
                                                                                            <input type="text" value="<?= $t1['activity']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">date_s</label>
                                                                                            <input type="text" value="<?= $t1['date_s']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">date_e</label>
                                                                                            <input type="text" value="<?= $t1['date_e']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Name</label>
                                                                                            <input type="text" value="<?= $t1['name']; ?>" class="form-control" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label">Details</label>
                                                                                            <textarea class="form-control" name="comments_u" style="height: 400px" disabled><?= $t1['details']; ?></textarea>
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
                                                            <a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="View" href="pdf_export.php?id=<?php echo $t1['id']; ?>&university_id=<?php echo $t1['university_id']; ?>&ACTION=VIEW" target="_blank"> <span class="btn-inner">
                                                                    <svg width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M12.1221 15.436L12.1221 3.39502" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M15.0381 12.5083L12.1221 15.4363L9.20609 12.5083" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M16.7551 8.12793H17.6881C19.7231 8.12793 21.3721 9.77693 21.3721 11.8129V16.6969C21.3721 18.7269 19.7271 20.3719 17.6971 20.3719L6.55707 20.3719C4.52207 20.3719 2.87207 18.7219 2.87207 16.6869V11.8019C2.87207 9.77293 4.51807 8.12793 6.54707 8.12793L7.48907 8.12793" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                            <a class="btn btn-sm btn-icon btn-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="Date-Information-Edit.php?id=<?= $t1['id']; ?>">
                                                                <span class="btn-inner">
                                                                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                            <a class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="javascript:void(0);" onclick="confirmDelete('<?= $t1['id']; ?>')"><span class="btn-inner">
                                                                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                                        <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </span></a>
                                                            <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                                                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                                                            <script>
                                                                function confirmDelete(id) {
                                                                    swal({
                                                                            title: "Are you sure?",
                                                                            text: "Do you want to delete it? Once deleted, it cannot be recovered.",
                                                                            type: "warning",
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: "#DD6B55",
                                                                            confirmButtonText: "Yes, cancel it!",
                                                                            cancelButtonText: "No",
                                                                            closeOnConfirm: false
                                                                        },
                                                                        function(isConfirm) {
                                                                            if (isConfirm) {
                                                                                window.location = "Del-Information.php?id=" + id;
                                                                            }
                                                                        });
                                                                }
                                                            </script>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                                $countrow++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="staticBackdropLive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLiveLabel">New University</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-card text-start">
                                <div class="row">
                                    <input type="text" name="university_id" value="<?= $row['university_id']; ?>" hidden>
                                    <input type="text" name="country" value="<?= $row['country']; ?>" hidden>
                                    <input type="text" name="university_name" value="<?= $row['university']; ?>" hidden>
                                    <input type="text" name="department" value="<?= $row['department']; ?>" hidden>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Start</label>
                                            <input type="date" name="date_s" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">End</label>
                                            <input type="date" name="date_e" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Name Surname</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Select Activities</label>
                                            <select class="selectpicker form-control" multiple data-live-search="true" name="activity[]" required>
                                                <?php
                                                require_once 'connect.php';
                                                $sql = "SELECT activity FROM tage";
                                                $result = $conn->query($sql);

                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="' . $row['activity'] . '">' . $row['activity'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Details</label>
                                            <textarea class="form-control" name="details" style="height: 350px"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="reg_by" value="<?php echo $json['firstname_EN']; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="get" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <?php
                            require_once 'Date-Information-Add-db.php';
                            // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            //     echo '<pre>';
                            //     print_r($_POST);
                            //     echo '</pre>';
                            // }
                            ?>
                        </form>
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