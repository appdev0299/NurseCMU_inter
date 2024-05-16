<?php
// //require_once 'session.php'
?>
<!doctype html>
<html lang="en" dir="ltr">

<?php require_once 'head.php' ?>

<body class=" ">
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
                                    <div class="card-body d-flex flex-column"></div>
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
                                    <p>Show : <span id="num_countries"></span> Country</p>
                                    <p>Year : <?php
                                                $selected_year = isset($_POST['date_s']) ? $_POST['date_s'] : '';
                                                echo $selected_year;
                                                ?> </span></p>
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
                <div class="modal fade" id="activity" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="activityLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="activityLabel">
                                    <p id="selected_activity_name"></p>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-card text-start">
                                        <input type="hidden" id="selected_activity" name="selected_activity">
                                        <div class="card-body">
                                            <div class="table-responsive">

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

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
                colors: ['#C5C2F2', '#8744ac']
            }
        };
        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        chart.draw(data, options);
        document.getElementById('num_countries').innerText = <?php echo $num_countries; ?>;

        function updateSelectedCountry(country) {
            var date_s = "<?php echo isset($_POST['date_s']) ? $_POST['date_s'] : ''; ?>";
            document.getElementById('selected_country').value = country;
            $.ajax({
                type: "POST",
                url: "countey_show.php",
                data: {
                    country: country,
                    date_s: date_s
                },
                success: function(response) {
                    console.log("Country data received successfully: " + country);
                    $('.table-responsive').html(response);
                    $('#staticBackdropLive').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error receiving country data: " + error);
                }
            });
        }

        google.visualization.events.addListener(chart, 'select', function() {
            var selection = chart.getSelection();
            if (selection.length > 0) {
                var country = data.getValue(selection[0].row, 0);
                updateSelectedCountry(country);
                document.getElementById('selected_country_name').innerText = "Country: " + country;
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
            colors: ['#f8f4fb', '#f0e6f5', '#e7d8f0', '#d6bce5', '#ceaedf', '#c5a0d9', '#b484ce', '#a368c3', '#9a5abe', '#914cb8', '#914cb8', '#7c3e9e', '#713990', '#663382', '#5b2e74', '#502866', '#452358', '#ffb914', '#ffbf27', '#ffc53b', '#ffca4e', '#ffd062', '#ffd676', '#ffe29d', '#ffb300', '#eba500', '#eba500', '#c48a00', '#ff8a14', '#ff9427', '#ff9d3b', '#ffb162', '#ffbb76', '#ffc489', '#ffd8b1', '#ff8000', '#eb7600', '#d86c00', '#c46200', '#8D8568', '#978F72', '#13A6AE', '#4cc9f0', '#4cc9f0', '#a0c4ff', '#ff006e', '#faa307']
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
            colors: ['#f8f4fb', '#f0e6f5', '#e7d8f0', '#d6bce5', '#ceaedf', '#c5a0d9', '#b484ce', '#a368c3', '#9a5abe', '#914cb8', '#914cb8', '#7c3e9e', '#713990', '#663382', '#5b2e74', '#502866', '#452358', '#ffb914', '#ffbf27', '#ffc53b', '#ffca4e', '#ffd062', '#ffd676', '#ffe29d', '#ffb300', '#eba500', '#eba500', '#c48a00', '#ff8a14', '#ff9427', '#ff9d3b', '#ffb162', '#ffbb76', '#ffc489', '#ffd8b1', '#ff8000', '#eb7600', '#d86c00', '#c46200', '#8D8568', '#978F72', '#13A6AE', '#4cc9f0', '#4cc9f0', '#a0c4ff', '#ff006e', '#faa307']
        };
        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);

        google.visualization.events.addListener(chart, 'select', function() {
            var selection = chart.getSelection();
            if (selection.length > 0) {
                var activity = data.getValue(selection[0].row, 0);
                updateSelectedActivity(activity);
                document.getElementById('selected_activity_name').innerText = "Activity: " + activity;
            }
        });
    }

    function updateSelectedActivity(activity) {
        var date_s = "<?php echo isset($_POST['date_s']) ? $_POST['date_s'] : ''; ?>";

        document.getElementById('selected_activity').value = activity;
        $.ajax({
            type: "POST",
            url: "activity_show.php",
            data: {
                activity: activity,
                date_s: date_s
            },
            success: function(response) {
                console.log("Activity data received successfully: " + activity);
                $('.table-responsive').html(response);
                $('#activity').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error receiving activity data: " + error);
            }
        });
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

            echo "['" . $year['year'] . "', " . $num_universities . "],";
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