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
                        <b>Rented House List</b>
                       
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Tenant Name</th>
                                    <th class="">Landlord Name</th>
                                    <th class="">House No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $cnt = 1;
                                    $tenant = mysqli_query($conn, "SELECT * FROM tenantss where tenant_id = ".$_SESSION['login_id']);
                                    while($res = mysqli_fetch_assoc($tenant)){
                                        $landlord = mysqli_query($conn , "SELECT * FROM users where id = ".$res['landlord_id']);
                                        $res_landlord = mysqli_fetch_assoc($landlord);
                                        $house = mysqli_query($conn, "SELECT * FROM houses where id = ".$res['house_id']);
                                        $res_house = mysqli_fetch_assoc($house);
                                ?>
                                    <tr>
                                        <td><?php echo $cnt++; ?></td>
                                        <td><?php echo $res['firstname'] . $res['middlename'] . $res['lastname']; ?></td>
                                        <td><?php echo $res_landlord['name']; ?></td>
                                        <td><?php echo $res_house['house_no']; ?></td>
                                    </tr>
                                <?php } ?>
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