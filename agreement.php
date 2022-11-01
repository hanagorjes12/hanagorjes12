<?php include('db_connect.php');
?>

<div class="container-fluid">

    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Agreement List</b>
                        <?php
                        if ($_SESSION['login_type']  == "3") {
                        } else {
                        ?>
                            <span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_agreement">
                                    <i class="fa fa-plus"></i> New Agreement
                                </a></span>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Agreement Name</th>
                                    <th class="">Agreement To</th>
                                    <th>Tenant Agreement</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($_SESSION['login_type'] != 3) {
                                    $i = 1;
                                    $agreement = "SELECT * FROM agreement where landlord_id = " . $_SESSION['login_id'] . " order by id asc";
                                    $result = mysqli_query($conn, $agreement);
                                    if (mysqli_num_rows($result)) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            extract($row);
                                            $select_tenant = mysqli_query($conn, "SELECT name FROM users where id = '$tenant_id'");
                                            $res_tenant = mysqli_fetch_assoc($select_tenant);
                                ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                <td class="">
                                                    <?php echo $agreement ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $res_tenant['name']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $tenant_agreement ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="agreement/<?php echo $tenant_agreement ?>" download="" class="btn btn-outline-primary">Download Tenant Agreement</a>
                                                    <button class="btn btn-outline-danger" onclick="delete_agreement('<?php echo $id ?>')">Delete</button>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4">
                                                <center>
                                                    No Data Available
                                                </center>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    $i = 1;
                                    $agreement = "SELECT * FROM agreement where tenant_id = " . $_SESSION['login_id'] . " order by id asc";
                                    $result = mysqli_query($conn, $agreement);
                                    if (mysqli_num_rows($result)) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            extract($row);
                                            $select_tenant = mysqli_query($conn, "SELECT name FROM users where id = '$tenant_id'");
                                            $res_tenant = mysqli_fetch_assoc($select_tenant);
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++ ?></td>
                                                <td class="">
                                                    <?php echo $agreement ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $res_tenant['name']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $tenant_agreement ?>
                                                </td>
                                                <?php
                                                if ($tenant_agreement == "") {
                                                ?>
                                                    <td>
                                                        <a href="agreement/<?php echo $agreement ?>" download="" class="btn btn-outline-primary">Download</a>
                                                        <button class="btn btn-outline-warning upload_agreement" data-id="<?php echo $id ?>">Upload Agreement Signed</button>
                                                    </td>
                                                <?php } else {
                                                ?>
                                                    <td>
                                                        <a href="agreement/<?php echo $agreement ?>" download="" class="btn btn-outline-primary">Download</a>
                                                        <button class="btn btn-outline-warning upload_agreement" data-id="<?php echo $id ?>">Reupload Agreement Signed</button>
                                                    </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4">
                                                <center>
                                                    No Data Available
                                                </center>
                                            </td>
                                        </tr>
                                <?php   }
                                } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>

</div>


<style>
    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset;
        padding: unset;
        line-height: 1em;
    }
</style>
<script>
    // $('#manage-house').on('reset', function(e) {
    // 	$('#msg').html('')
    // })
    $('#new_agreement').click(function() {
        uni_modal("New Agreement", "manage_agreement.php", "mid-large")

    })
    $('.upload_agreement').click(function() {
        uni_modal("Uplaod Agreement", "upload_agreement.php?id=" + $(this).attr('data-id'), "mid-large")

    })


    function delete_agreement($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_agreement',
            method: 'POST',
            data: {
                id: $id
            },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1500)

                }
            }
        })
    }
    // $('table').dataTable()
</script>