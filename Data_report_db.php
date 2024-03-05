<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Initialize filter variables
    $start_date = null;
    $end_date = null;
    $selected_activity = null;
    $selected_university = null;
    $selected_country = null;

    // Check if any filter values are set
    if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['activity']) || isset($_GET['university']) || isset($_GET['country'])) {
        // Set filter values if provided in the GET request
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;
        $selected_activity = isset($_GET['activity']) ? $_GET['activity'] : null;
        $selected_university = isset($_GET['university']) ? $_GET['university'] : null;
        $selected_country = isset($_GET['country']) ? $_GET['country'] : null;
    }

    // Build the SQL query
    $sql = "SELECT id, university, university_id, date_s, date_e, activity, country, name, details, dateCreate FROM dateinter WHERE 1=1 ";

    if (!empty($start_date)) {
        $sql .= "AND date_s >= :start_date ";
    }

    if (!empty($end_date)) {
        $sql .= "AND date_e <= :end_date ";
    }

    if (!empty($selected_activity)) {
        $sql .= "AND activity = :activity ";
    }

    if (!empty($selected_university)) {
        $sql .= "AND university = :university ";
    }
    if (!empty($selected_country)) {
        $sql .= "AND country = :country ";
    }

    require_once 'connect.php';
    $stmt = $conn->prepare($sql);

    if (!empty($start_date)) {
        $stmt->bindParam(':start_date', $start_date);
    }

    if (!empty($end_date)) {
        $stmt->bindParam(':end_date', $end_date);
    }

    if (!empty($selected_activity)) {
        $stmt->bindParam(':activity', $selected_activity);
    }

    if (!empty($selected_university)) {
        $stmt->bindParam(':university', $selected_university);
    }
    if (!empty($selected_country)) {
        $stmt->bindParam(':country', $selected_country);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($results)) {
        // Export data to Excel here...
        require_once 'vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $columns = ['University', 'Country', 'Start', 'End', 'Activity', 'Name', 'Details', 'DateCreate'];

        $col = 'A';

        foreach ($columns as $column) {
            $sheet->setCellValue($col . '1', $column);
            $col++;
        }
        $row = 2;
        foreach ($results as $result) {
            $col = 'A';
            $sheet->setCellValue($col . $row, $result['university']);
            $col++;
            $sheet->setCellValue($col . $row, $result['country']);
            $col++;
            $sheet->setCellValue($col . $row, $result['date_s']);
            $sheet->setCellValue($col . $row, date('d M Y', strtotime($result['date_s'])));
            $col++;
            $sheet->setCellValue($col . $row, date('d M Y', strtotime($result['date_e'])));
            $col++;
            $sheet->setCellValue($col . $row, $result['activity']);
            $col++;
            $sheet->setCellValue($col . $row, $result['name']);
            $col++;
            $sheet->setCellValue($col . $row, $result['details']);
            $col++;
            $sheet->setCellValue($col . $row, $result['dateCreate']);
            $col++;
            $row++;
        }

        // ตั้งค่าการส่งออกไฟล์ Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="inter.xlsx"');
        header('Cache-Control: max-age=0');

        // สร้าง Writer และส่งออกไฟล์ Excel
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    } else {
        echo "No data found.";
    }
} else {
    // If no filter values are set, export all data
    require_once 'connect.php';

    $sql = "SELECT id, university, university_id, date_s, date_e, activity, country, name, details, dateCreate FROM dateinter";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        // Export data to Excel here...
        require_once 'vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $columns = ['University', 'Country', 'Start', 'End', 'Activity', 'Name', 'Details', 'DateCreate'];

        $col = 'A';

        foreach ($columns as $column) {
            $sheet->setCellValue($col . '1', $column);
            $col++;
        }
        $row = 2;
        foreach ($results as $result) {
            $col = 'A';
            $sheet->setCellValue($col . $row, $result['university']);
            $col++;
            $sheet->setCellValue($col . $row, $result['country']);
            $col++;
            $sheet->setCellValue($col . $row, $result['date_s']);
            $sheet->setCellValue($col . $row, date('d M Y', strtotime($result['date_s'])));
            $col++;
            $sheet->setCellValue($col . $row, date('d M Y', strtotime($result['date_e'])));
            $col++;
            $sheet->setCellValue($col . $row, $result['activity']);
            $col++;
            $sheet->setCellValue($col . $row, $result['name']);
            $col++;
            $sheet->setCellValue($col . $row, $result['details']);
            $col++;
            $sheet->setCellValue($col . $row, $result['dateCreate']);
            $col++;
            $row++;
        }

        // ตั้งค่าการส่งออกไฟล์ Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="inter.xlsx"');
        header('Cache-Control: max-age=0');

        // สร้าง Writer และส่งออกไฟล์ Excel
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    } else {
        echo "No data found.";
    }
}
