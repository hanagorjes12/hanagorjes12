<?php
include('db_connect.php');
if (isset($_GET['id'])) {
    extract($_GET);

?>
    <table class="table table-condensed table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="">Agent Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $sql = mysqli_query($conn, "SELECT * FROM tenants where company_id = $id");
            while ($result = mysqli_fetch_assoc($sql)) {
            ?>
                <tr>
                    <td class="text-center"><?php echo $i++ ?></td>
                    <td>
                        <?php echo $result['firstname'] . " " . $result['middlename'] . " " . $result['lastname']; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php

}
?>