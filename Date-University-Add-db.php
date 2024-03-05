<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php if (
    isset($_POST['university'])
    && isset($_POST['ranking'])
    && isset($_POST['signed'])
    && isset($_POST['expired'])
    && isset($_POST['department'])
    && isset($_POST['mou'])
    && isset($_POST['country'])
    && isset($_POST['comments_u'])
    && isset($_POST['spec'])
    && isset($_POST['qs_suject'])
    && isset($_POST['reg_by'])
  ) {
    // ไฟล์เชื่อมต่อฐานข้อมูล
    require_once 'connect.php';

    // เช็คว่ามีข้อมูลในฐานข้อมูลแล้วหรือไม่
    $checkStmt = $conn->prepare("SELECT * FROM university WHERE university = :university");
    $checkStmt->bindParam(':university', $_POST['university'], PDO::PARAM_STR);
    $checkStmt->execute();
    $existingData = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingData) {
      echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
      echo '<script>
    swal({
      title: "Data already exists",
      text: "Please make a new list.",
      type: "error",
      timer: 1000,
      showConfirmButton: false
    }, function(){
      window.location.href = "Date-University.php";
    });
  </script>';
    } else {
      // SQL insert
      $stmt = $conn->prepare("INSERT INTO university
(university,department, signed, expired, ranking, mou, country, comments_u ,spec ,reg_by,qs_suject)
VALUES
(:university, :department, :signed, :expired, :ranking, :mou, :country, :comments_u, :spec, :reg_by, :qs_suject)");

      // bindParam data type
      $stmt->bindParam(':university', $_POST['university'], PDO::PARAM_STR);
      $stmt->bindParam(':department', $_POST['department'], PDO::PARAM_STR);
      $stmt->bindParam(':signed', $_POST['signed'], PDO::PARAM_STR);
      $stmt->bindParam(':expired', $_POST['expired'], PDO::PARAM_STR);
      $stmt->bindParam(':ranking', $_POST['ranking'], PDO::PARAM_STR);
      $stmt->bindParam(':mou', $_POST['mou'], PDO::PARAM_STR);
      $stmt->bindParam(':country', $_POST['country'], PDO::PARAM_STR);
      $stmt->bindParam(':comments_u', $_POST['comments_u'], PDO::PARAM_STR);
      $stmt->bindParam(':spec', $_POST['spec'], PDO::PARAM_STR);
      $stmt->bindParam(':qs_suject', $_POST['qs_suject'], PDO::PARAM_STR);
      $stmt->bindParam(':reg_by', $_POST['reg_by'], PDO::PARAM_STR);
      $result = $stmt->execute();
      echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
      if ($result) {
        echo '<script>
              swal({
                title: "Add Data Success",
                text: "success",
                type: "success",
                timer: 1000,
                showConfirmButton: false
              }, function(){
                window.location.href = "Date-University.php";
              });
            </script>';
      } else {
        echo '<script>
            swal({
              title: "Add data fail",
              text: "Add data fail",
              type: "error",
              timer: 1000,
              showConfirmButton: false
            }, function(){
              window.location.href = "Date-University.php";
            });
          </script>';
      }
    }

    $conn = null; // close database connection
  } // isset
  ?>
</body>

</html>