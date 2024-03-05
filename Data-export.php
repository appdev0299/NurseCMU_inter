<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['export'])) {
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

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="exported_data.csv"');

        // Create a new file pointer connected to PHP output stream
        $output = fopen('php://output', 'w');

        // Write CSV header
        fputcsv($output, array('Start', 'End', 'University', 'Activity'));

        // Loop through the data and write to CSV
        foreach ($results as $row) {
            fputcsv($output, $row);
        }

        // Close the file pointer
        fclose($output);
        exit();
    }
}
