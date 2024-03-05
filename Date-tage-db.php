<?php
if (isset($_POST['activity'])) {
    require_once 'connect.php';
    $activity = $_POST['activity'];

    // SQL insert
    $stmt = $conn->prepare("INSERT INTO tage (activity) VALUES (:activity)");

    $result = $stmt->execute([':activity' => $activity]);

    if ($result) {
        echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
        echo '<script>
        swal({
          title: "Add Data Success",
          text: "Tage add success",
          type: "success",
          timer: 1500,
          showConfirmButton: false
        }, function(){
          window.location = "Date-tage.php";
        });
      </script>';
    } else {
        echo '<script>
        swal({
          title: "Add Data Fail",
          text: "Failed to add data",
          type: "error",
          timer: 1500,
          showConfirmButton: false
        }, function(){
          window.location.href = "Date-tage.php";
        });
      </script>';
    }
    $conn = null;
}
