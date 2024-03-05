<?php
if (
  isset($_POST['date_s'])
  && isset($_POST['university_id'])
  && isset($_POST['date_e'])
  && isset($_POST['activity'])
  && isset($_POST['name'])
  && isset($_POST['details'])
  && isset($_POST['reg_by'])
  && isset($_POST['country'])
) {
  require_once 'connect.php';
  $university = $_POST['university_name'];
  $university_id = $_POST['university_id'];
  $date_s = $_POST['date_s'];
  $date_e = $_POST['date_e'];
  $activity = implode(", ", $_POST['activity']);
  $name = $_POST['name'];
  $details = $_POST['details'];
  $reg_by = $_POST['reg_by'];
  $country = $_POST['country'];

  // SQL insert
  $stmt = $conn->prepare("INSERT INTO dateinter (university, university_id, date_s, date_e, activity, reg_by, name, country, details)
    VALUES (:university, :university_id, :date_s, :date_e, :activity, :reg_by, :name, :country, :details)");

  $stmt->bindParam(':university', $university, PDO::PARAM_STR);
  $stmt->bindParam(':university_id', $university_id, PDO::PARAM_STR);
  $stmt->bindParam(':date_s', $date_s, PDO::PARAM_STR);
  $stmt->bindParam(':date_e', $date_e, PDO::PARAM_STR);
  $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':details', $details, PDO::PARAM_STR);
  $stmt->bindParam(':reg_by', $reg_by, PDO::PARAM_STR);
  $stmt->bindParam(':country', $country, PDO::PARAM_STR);

  $result = $stmt->execute();

  if ($result) {
    // Fetch university_id
    $stmt = $conn->prepare("SELECT university_id FROM university WHERE university = :university");
    $stmt->bindParam(':university', $university, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $university_id = $result['university_id'];

    echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script>
        swal({
          title: "Add Data Success",
          text: "University add success",
          type: "success",
          timer: 1500,
          showConfirmButton: false
        }, function(){
          window.location = "Date-University-View.php?university_id=' . $university_id . '";
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
          window.location.href = "Date-University-View.php";
        });
      </script>';
  }
  $conn = null;
}
