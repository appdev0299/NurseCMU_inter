<?php
// //require_once 'session.php'
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
                <div class="col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="900">
                                <form method="post" class="mt-3 text-center">
                                    <div class="card-body d-flex flex-column">
                                        <label class="form-label" for="choices-single-default"><b>Year</b></label>
                                        <?php
                                        $selected_year = isset($_POST['date_s']) ? $_POST['date_s'] : '';
                                        echo $selected_year;
                                        ?>
                                        <select class="form-control" name="date_s" id="date_s">
                                            <?php
                                            require_once 'connect.php';
                                            $sql = "SELECT DISTINCT YEAR(date_s) AS year FROM dateinter ORDER BY year DESC";

                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $years = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($years as $year) {
                                                $selected = isset($_POST['date_s']) && $_POST['date_s'] === $year['year'] ? 'selected' : '';
                                                echo "<option value='" . $year['year'] . "' data-university='' $selected>" . $year['year'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
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
                                    <div id="regions_div"></div>
                                    <p>จำนวนประเทศที่แสดง: <span id="num_countries"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="staticBackdropLive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLiveLabel">
                                    <p id="selected_country_name"></p>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-card text-start">
                                        <input type="hidden" id="selected_country" name="selected_country">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table table-striped" data-toggle="data-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>University/Institute</th>
                                                            <th>Country</th>
                                                            <th>QS ranking</th>
                                                            <th>Expired</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once 'connect.php';
                                                        $countryview = "United States"; // กำหนดชื่อประเทศที่ต้องการดูข้อมูล
                                                        $stmt = $conn->prepare("SELECT university_id, university, department, ranking, expired, country FROM university WHERE country = :countryview");
                                                        $stmt->bindParam(':countryview', $countryview, PDO::PARAM_STR);
                                                        $stmt->execute();
                                                        $result = $stmt->fetchAll();
                                                        $countrow = 1;
                                                        foreach ($result as $t1) {
                                                        ?>
                                                            <!-- แสดงข้อมูลในตาราง -->
                                                            <tr>
                                                                <td><?= $countrow ?></td>
                                                                <td><?= $t1['university']; ?> - <?= $t1['department']; ?></td>
                                                                <td><?= $t1['country']; ?></td>
                                                                <td><?= $t1['ranking']; ?></td>
                                                                <?php
                                                                // ตรวจสอบว่าข้อมูลเกี่ยวกับวันหมดอายุมีหรือไม่และแสดงผล
                                                                if (!empty($t1['expired'])) {
                                                                    echo '<td>' . date('d M Y', strtotime($t1['expired'])) . '</td>';
                                                                } else {
                                                                    echo '<td></td>';
                                                                }
                                                                ?>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card" data-aos="fade-up" data-aos-delay="1600">
                                <div class="flex-wrap card-header d-flex justify-content-between">
                                    <div class="col-md-6 col-lg-6">
                                        <div id="columnchart" style="width: 100%; height: 500px;"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div id="donutchart" style="width: 100%; height: 500px;"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div id="curve_chart" style="width: 100%; height: 500px;"></div>
                                    </div>
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
            var date_s = "<?php echo isset($_POST['date_s']) ? $_POST['date_s'] : ''; ?>";
            var data = google.visualization.arrayToDataTable([
                ['Country', 'Popularity'],
                <?php
                require_once 'connect.php';
                $date_s_condition = isset($_POST['date_s']) ? "WHERE YEAR(date_s) = :date_s" : "";
                $stmtC = $conn->prepare("SELECT country, COUNT(*) AS count FROM dateinter $date_s_condition GROUP BY country");
                if (isset($_POST['date_s'])) {
                    $stmtC->bindParam(':date_s', $_POST['date_s'], PDO::PARAM_INT);
                }
                $stmtC->execute();

                $num_countries = $stmtC->rowCount();

                while ($row = $stmtC->fetch(PDO::FETCH_ASSOC)) {
                    echo "['" . $row['country'] . "', " . $row['count'] . "],";
                }
                ?>
            ]);

            var options = {
                colorAxis: {
                    colors: ['#476CFF', '#00187A']
                }
            };

            var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
            chart.draw(data, options);
            document.getElementById('num_countries').innerText = <?php echo $num_countries; ?>;

            function updateSelectedCountry(country) {
                document.getElementById('selected_country').value = country;

                // ส่งชื่อประเทศไปด้วยแบบ POST ผ่าน AJAX
                $.ajax({
                    type: "POST",
                    url: "your_php_script.php", // เปลี่ยนเป็น URL ของไฟล์ PHP ที่จะรับข้อมูล
                    data: {
                        country: country
                    }, // ส่งชื่อประเทศไปด้วยแบบ POST
                    success: function(response) {
                        // การประมวลผลหลังจากส่งข้อมูลสำเร็จ
                        console.log("Country sent successfully: " + country);
                    },
                    error: function(xhr, status, error) {
                        // กรณีเกิดข้อผิดพลาดในการส่งข้อมูล
                        console.error("Error sending country: " + error);
                    }
                });

                // เปิดโมดัล
                $('#staticBackdropLive').modal('show');
            }

            google.visualization.events.addListener(chart, 'select', function() {
                var selection = chart.getSelection();
                if (selection.length > 0) {
                    var country = data.getValue(selection[0].row, 0);
                    updateSelectedCountry(country);

                    // อัปเดตข้อความใน <p> ด้วยชื่อประเทศที่เลือก
                    document.getElementById('selected_country_name').innerText = "Country: " + country;

                    $('#staticBackdropLive').modal('show');
                }
            });
        }
    </script>

    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var date_s = "<?php echo isset($_POST['date_s']) ? $_POST['date_s'] : ''; ?>";

            var data = google.visualization.arrayToDataTable([
                ['Country', 'Number of Universities'],
                <?php
                require_once 'connect.php';
                $date_s_condition = isset($_POST['date_s']) ? "WHERE YEAR(date_s) = :date_s" : "";
                $stmtC = $conn->prepare("SELECT country, COUNT(*) AS count FROM dateinter $date_s_condition GROUP BY country");
                if (isset($_POST['date_s'])) {
                    $stmtC->bindParam(':date_s', $_POST['date_s'], PDO::PARAM_INT);
                }
                $stmtC->execute();

                while ($row = $stmtC->fetch(PDO::FETCH_ASSOC)) {
                    echo "['" . $row['country'] . "', " . $row['count'] . "],";
                }
                ?>
            ]);

            var options = {
                pieHole: 0.4,
                colors: ['#000414', '#000829', '#000c3d', '#001052', '#001466', '#B1AB95', '#3950A0', '#98AAEC', '#A9B8EF', '#BAC6F2', '#0029CC', '#002DE0', '#0031F5', '#0A3BFF', '#1F4BFF', '#335CFF', '#476CFF', '#5C7CFF', '#708DFF', '#859DFF', '#99ADFF', '#ADBEFF', '#C2CEFF', '#2B3C78', '#314387', '#364B96', '#3B52A5', '#415AB4', '#4B64BE', '#5A71C4', '#697EC9', '#788BCE', '#8798D4', '#5E5945', '#3B52A5', '#6A644E', '#6A644E', '#817A5F', '#8D8568', '#978F72', '#A0987E', '#A8A18A']
            };

            var chart = new google.visualization.PieChart(document.getElementById('columnchart'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var date_s = "<?php echo isset($_POST['date_s']) ? $_POST['date_s'] : ''; ?>";

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                <?php
                require_once 'connect.php';
                $date_s_condition = isset($_POST['date_s']) ? "WHERE YEAR(date_s) = :date_s" : "";
                $stmtC = $conn->prepare("SELECT activity, COUNT(*) AS count FROM dateinter $date_s_condition GROUP BY activity");
                if (isset($_POST['date_s'])) {
                    $stmtC->bindParam(':date_s', $_POST['date_s'], PDO::PARAM_INT);
                }
                $stmtC->execute();
                $activityCount = [];
                while ($row = $stmtC->fetch(PDO::FETCH_ASSOC)) {
                    $activities = explode(",", $row['activity']);
                    foreach ($activities as $activity) {
                        $activity = trim($activity);
                        if (isset($activityCount[$activity])) {
                            $activityCount[$activity] += $row['count'];
                        } else {
                            $activityCount[$activity] = $row['count'];
                        }
                    }
                }
                foreach ($activityCount as $activity => $count) {
                    echo "['" . $activity . "', " . $count . "],";
                }
                ?>
            ]);

            var options = {
                pieHole: 0.4,
                colors: ['#000414', '#000829', '#000c3d', '#001052', '#001466', '#B1AB95', '#3950A0', '#98AAEC', '#A9B8EF', '#BAC6F2', '#0029CC', '#002DE0', '#0031F5', '#0A3BFF', '#1F4BFF', '#335CFF', '#476CFF', '#5C7CFF', '#708DFF', '#859DFF', '#99ADFF', '#ADBEFF', '#C2CEFF', '#2B3C78', '#314387', '#364B96', '#3B52A5', '#415AB4', '#4B64BE', '#5A71C4', '#697EC9', '#788BCE', '#8798D4', '#5E5945', '#3B52A5', '#6A644E', '#6A644E', '#817A5F', '#8D8568', '#978F72', '#A0987E', '#A8A18A']
            };
            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Define your data array with the new structure
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Year');
            data.addColumn('number', 'Score');
            data.addColumn('number', 'University');

            <?php
            require_once 'connect.php';
            $stmt = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date_s, '%Y') AS year FROM dateinter ORDER BY year ASC");
            $stmt->execute();
            $years = $stmt->fetchAll();

            echo "data.addRows([";
            foreach ($years as $year) {
                $stmt = $conn->prepare("SELECT COUNT(DISTINCT university) AS num_universities FROM dateinter WHERE DATE_FORMAT(date_s, '%Y') = :year");
                $stmt->bindParam(':year', $year['year'], PDO::PARAM_STR);
                $stmt->execute();
                $num_universities = $stmt->fetch(PDO::FETCH_ASSOC)['num_universities'];

                echo "['" . $year['year'] . "', 0, " . $num_universities . "],";
            }
            echo "]);";
            ?>

            var options = {
                title: '',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Define your data array with the new structure
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Year');
            data.addColumn('number', 'Score');
            data.addColumn('number', 'University');

            <?php
            require_once 'connect.php';
            $stmt = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date_s, '%Y') AS year FROM dateinter ORDER BY year ASC");
            $stmt->execute();
            $years = $stmt->fetchAll();

            echo "data.addRows([";
            foreach ($years as $year) {
                $stmt = $conn->prepare("SELECT COUNT(DISTINCT university) AS num_universities FROM dateinter WHERE DATE_FORMAT(date_s, '%Y') = :year");
                $stmt->bindParam(':year', $year['year'], PDO::PARAM_STR);
                $stmt->execute();
                $num_universities = $stmt->fetch(PDO::FETCH_ASSOC)['num_universities'];

                echo "['" . $year['year'] . "', 0, " . $num_universities . "],";
            }
            echo "]);";
            ?>

            var options = {
                title: '',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart2'));

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