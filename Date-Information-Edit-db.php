<?php
require_once 'connect.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $university = $_POST['university'];
    $date_s = $_POST['date_s'];
    $date_e = $_POST['date_e'];
    $activity = $_POST['activity'];
    $details = $_POST['details'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE dateinter SET date_s=:date_s, date_e=:date_e, activity=:activity, name=:name, details=:details WHERE id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ปรับเป็น INT
    $stmt->bindParam(':date_s', $date_s, PDO::PARAM_STR);
    $stmt->bindParam(':date_e', $date_e, PDO::PARAM_STR);
    $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':details', $details, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // แสดง SweetAlert สำหรับการแก้ไขข้อมูลสำเร็จ
        echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
        echo '
            <script>
                swal({
                    title: "Edit Data Success",
                    text: "success",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false
                }, function(){
                    window.location = "Date-University-View.php?university_id=' . $_POST['university_id'] . '";
                });
            </script>';
    } else {
        // แสดง SweetAlert สำหรับการแก้ไขข้อมูลไม่สำเร็จ
        echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
        echo '
            <script>
                swal({
                    title: "Edit Data Fail",
                    text: "fail",
                    type: "error",
                    timer: 1500,
                    showConfirmButton: false
                }, function(){
                    window.location.href = "Date-University-View.php";
                });
            </script>';
    }
}
