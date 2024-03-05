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
            <div class="row">
                <?php
                require_once 'connect.php';
                $sqltotal_universities = "SELECT COUNT(DISTINCT university) AS total_universities FROM university";
                $stmttotal_universities = $conn->prepare($sqltotal_universities);
                $stmttotal_universities->execute();
                $resulttotal_universities = $stmttotal_universities->fetch();

                $sqltotal_country = "SELECT COUNT(DISTINCT country) AS total_country FROM university";
                $stmttotal_country = $conn->prepare($sqltotal_country);
                $stmttotal_country->execute();
                $resulttotal_country = $stmttotal_country->fetch();

                $sqltotal_dateinter = "SELECT COUNT(*) AS total_dateinter FROM dateinter";
                $stmttotal_dateinter = $conn->prepare($sqltotal_dateinter);
                $stmttotal_dateinter->execute();
                $resulttotal_dateinter = $stmttotal_dateinter->fetch();

                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
                        <div class="pb-4 border-0 card-header">
                            <div class="p-4 border border-white rounded primary-gradient-card" style="height: 120px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="font-weight-bold">University</h5>
                                        <span class="fs-5 me-2"><?php echo $resulttotal_universities['total_universities']; ?></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6></h6>
                                    <h6 class="ms-5"><a href="" data-bs-toggle="modal" data-bs-target="#UniversityList" style="color: white;">more</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="UniversityList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UniversityListLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="UniversityListLabel">University List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table id="datatable" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>University</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // ดึงข้อมูลรายชื่อมหาลัยจากฐานข้อมูล
                                        $sql_universities = "SELECT university FROM university";
                                        $stmt_universities = $conn->prepare($sql_universities);
                                        $stmt_universities->execute();
                                        $universities = $stmt_universities->fetchAll();

                                        $count = 1;
                                        foreach ($universities as $university) {
                                            echo "<tr>";
                                            echo "<td>" . $count . "</td>";
                                            echo "<td>" . $university['university'] . "</td>";
                                            echo "</tr>";
                                            $count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
                        <div class="pb-4 border-0 card-header">
                            <div class="p-4 border border-white rounded primary-gradient-card" style="height: 120px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="font-weight-bold">Country </h5>
                                        <span class="fs-5 me-2"><?php echo $resulttotal_country['total_country']; ?></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6></h6>
                                    <h6 class="ms-5"><a href="" data-bs-toggle="modal" data-bs-target="#CountryListLabel" style="color: white;">more</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="CountryListLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CountryListLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="CountryListLabelLabel">Country List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table id="datatable" class="table table-striped" data-toggle="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql_country = "SELECT DISTINCT country FROM university";
                                        $stmt_country = $conn->prepare($sql_country);
                                        $stmt_country->execute();
                                        $countries = $stmt_country->fetchAll();

                                        $count = 1;
                                        foreach ($countries as $country) {
                                            echo "<tr>";
                                            echo "<td>" . $count . "</td>";
                                            echo "<td>" . $country['country'] . "</td>";
                                            echo "</tr>";
                                            $count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
                        <div class="pb-4 border-0 card-header">
                            <div class="p-4 border border-white rounded primary-gradient-card" style="height: 120px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="font-weight-bold">Date Inter</h5>
                                        <span class="fs-5 me-2"><?php echo $resulttotal_dateinter['total_dateinter']; ?></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6></h6>
                                    <h6 class="ms-5"><a href="" style="color: white;"></a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="900">
                                <div class="card-body d-flex flex-column">
                                    <div id="regions_div" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="1600">
                                <div class="flex-wrap card-header d-flex justify-content-between">
                                    <div id="columnchart" style="width: 100%; height: 800px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="1600">
                                <div class="flex-wrap card-header d-flex justify-content-between">
                                    <div id="donutchart" style="width: 100%; height: 800px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['geochart'],
        });
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable([
                ['Country', 'Popularity'],
                <?php
                require_once 'connect.php';
                $stmtC = $conn->prepare("SELECT country, COUNT(*) AS count FROM university GROUP BY country");
                $stmtC->execute();

                while ($row = $stmtC->fetch(PDO::FETCH_ASSOC)) {
                    echo "['" . $row['country'] . "', " . $row['count'] . "],";
                }
                ?>
            ]);

            var options = {
                colorAxis: {
                    colors: ['#3379EB', '#010E40']
                } // เปลี่ยนระดับสีตรงนี้
            };

            var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                <?php
                require_once 'connect.php';

                $stmt = $conn->prepare("SELECT * FROM tage");
                $stmt->execute();
                $tageData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $dataArray = [];

                foreach ($tageData as $row) {
                    $activity = $row['activity'];
                    $stmtCount = $conn->prepare("SELECT COUNT(*) AS country FROM dateinter WHERE activity = :activity");
                    $stmtCount->bindParam(':activity', $activity);
                    $stmtCount->execute();
                    $country = $stmtCount->fetchColumn();

                    $dataArray[] = "['" . $activity . "', " . $country . "]";
                }

                $dataString = implode(',', $dataArray);
                echo $dataString;
                ?>
            ]);

            var options = {
                pieHole: 0.4,
                colors: ['#AB8CE4', '#03A9E3', '#FB9678', '#e51c23', '#4a148c', '#ab47bc', '#4fc3f7', '#01579b', '#00bcd4', '#006064', '#26a69a', '#2baf2b', '#ff6f00', '#6c2c10']
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Country', 'Number of Universities'],
                <?php
                require_once 'connect.php';

                $stmtC = $conn->prepare("SELECT country, COUNT(*) AS count FROM university GROUP BY country");
                $stmtC->execute();

                while ($row = $stmtC->fetch(PDO::FETCH_ASSOC)) {
                    echo "['" . $row['country'] . "', " . $row['count'] . "],";
                }
                ?>
            ]);

            var options = {
                pieHole: 0.4,
                colors: ['#ffca28', '#f57f17', '#FB9678', '#e51c23', '#4a148c', '#ab47bc', '#4fc3f7', '#01579b', '#afb42b', '#006064', '#26a69a', '#2baf2b', '#ff6f00', '#6c2c10', '#880e4f', '#311b92', '#e7e9fd']
            };

            var chart = new google.visualization.PieChart(document.getElementById('columnchart'));
            chart.draw(data, options);
        }
    </script>
    <script src="assets/js/core/libs.min.js"></script>
    <script src="assets/js/core/external.min.js"></script>
    <script src="assets/js/charts/vectore-chart.js"></script>
    <script src="assets/js/charts/dashboard.js"></script>
    <script src="assets/js/plugins/fslightbox.js"></script>
    <script src="assets/js/plugins/setting.js"></script>
    <script src="assets/js/plugins/slider-tabs.js"></script>
    <script src="assets/js/plugins/form-wizard.js"></script>
    <script src="assets/vendor/aos/dist/aos.js"></script>
    <script src="assets/js/hope-ui.js" defer></script>


</body>

</html>