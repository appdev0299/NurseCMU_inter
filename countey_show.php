<?php
require_once 'connect.php';

if (isset($_POST['country']) && isset($_POST['date_s'])) {
    $countryview = $_POST['country'];
    $date_s = $_POST['date_s'];

    if (!empty($date_s)) {
        $stmt = $conn->prepare("SELECT university_id, university, country, COUNT(*) AS duplicate_count FROM dateinter WHERE country = :countryview AND YEAR(date_s) = :date_s GROUP BY university_id ORDER BY country ASC");
        $stmt->bindParam(':date_s', $date_s, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare("SELECT university_id, university, country, COUNT(*) AS duplicate_count FROM dateinter WHERE country = :countryview GROUP BY university_id ORDER BY university ASC");
    }

    $stmt->bindParam(':countryview', $countryview, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();
?>
    <table id="datatable" class="table table-striped" data-toggle="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>University/Institute</th>
                <th>Country</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $countrow = 1;
            foreach ($result as $t1) {
            ?>
                <tr>
                    <td><?= $countrow ?></td>
                    <td><?= $t1['university'] ?></td>
                    <td><?= $t1['country'] ?></td>
                    <td>
                        <div class="flex align-items-center list-user-action">
                            <a class="btn btn-sm btn-icon btn-warning" href="Date-University-View.php?university_id=<?= $t1['university_id']; ?>">
                                <span class="btn-inner">
                                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.7 11.7488H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7002 16.7498L20.6372 11.7488L12.7002 6.74776V16.7498Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php
                $countrow++;
            }
            ?>
        </tbody>
    </table>
<?php
} else {
    echo "No country data received.";
}
?>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>