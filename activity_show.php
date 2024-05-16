<?php
require_once 'connect.php';

if (isset($_POST['activity']) && isset($_POST['date_s'])) {
    $activity = $_POST['activity'];
    $date_s = $_POST['date_s'];
    if (strlen($activity) >= 5) {
        if (!empty($date_s)) {
            $stmt = $conn->prepare("SELECT * FROM dateinter WHERE activity LIKE CONCAT('%', :activity, '%') AND YEAR(date_s) = :date_s ORDER BY university ASC");
            $stmt->bindParam(':date_s', $date_s, PDO::PARAM_INT);
        } else {
            $stmt = $conn->prepare("SELECT * FROM dateinter WHERE activity LIKE CONCAT('%', :activity, '%') ORDER BY university ASC");
        }

        $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
?>
        <table id="datatable1" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 5%;">University/Country</th>
                    <th style="width: 60%;">Detail</th>
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
                        <td><?= date('d M Y', strtotime($t1['date_s'])); ?> | <?= date('d M Y', strtotime($t1['date_e'])); ?>
                            <br>
                            <span class="badge bg-success"><?= ($t1['university']); ?> | <?= ($t1['country']); ?></span>
                            <br>
                            <span class="badge bg-primary"><?= str_replace(',', '<br>', $t1['activity']); ?></span>
                        </td>
                        <td>
                            <div class="flex align-items-center list-user-action">
                                <div class="details-cell" style="max-height: 150px; overflow-y: auto; word-wrap: break-word;">
                                    <textarea class="form-control" name="comments_u" style="height: 150px; width: 450px; border: none; resize: none;" disabled><?= $t1['details']; ?></textarea>
                                </div>
                            </div>
                        </td>
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
        echo "Activity must have at least 5 characters.";
    }
} else {
    echo "No activity data received.";
}
?>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script>
    $(document).ready(function() {
        $('#datatable1').DataTable();
    });
</script>