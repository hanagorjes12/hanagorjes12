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
                        <b>Quotation List</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Name</th>
                                    <th class="">Email</th>
                                    <th class="">Contact</th>
                                    <th class="">House No</th>
                                    <th class="">Status</th>
                                    <th class="">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $quotation = mysqli_query($conn, "SELECT * FROM quotation where landlord_id =" . $_SESSION['login_id']);
                                if (mysqli_num_rows($quotation) > 0) {
                                    while ($row = mysqli_fetch_assoc($quotation)) {
                                        $house_id = $row['house_id'];
                                        $sql_house = mysqli_query($conn, "SELECT * FROM houses where id = $house_id and landlord_id = " . $_SESSION['login_id']);

                                        $res = mysqli_fetch_assoc($sql_house);
                                ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td class="">
                                                <?php echo $row['name'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['email'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['contact'] ?>
                                            </td>
                                            <td>
                                                <?php echo $res['house_no'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['status'] ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($row['status'] == "Done") {
                                                    echo "-";
                                                } else {
                                                ?>

                                                    <button class="btn btn-outline-success mark_done" data-id="<?php echo $row['id'] ?>" onclick="return confirm('Confirm to continue');">Done</button>
                                                    <!-- <button class="btn btn-outline-warning mark_complete" data-id="<?php echo $row['id'] ?>" onclick="return confirm('Please Check Before You Confirm To Mark This As Complete');">Complete</button> -->
                                                <?php } ?>
                                            </td>

                                        </tr>
                                    <?php }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">
                                            <center>
                                                No Data Available
                                            </center>
                                        </td>
                                    </tr>
                                <?php
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
    $('#new_properties').click(function() {
        uni_modal3("New properties", "manage_houses.php", "mid-large")

    })
    $('.edit_house').click(function() {
        uni_modal("Manage house Details", "manage_houses.php?id=" + $(this).attr('data-id'), "mid-large")

    })
    $('.make_quotation').click(function() {
        uni_modal("Make Quotation Of the House", "quotation.php?id=" + $(this).attr('data-id'), "mid-large")

    })
    $('.delete_house').click(function() {
        _conf("Are you sure to delete this house?", "delete_house", [$(this).attr('data-id')])
    })
    $('.mark_done').click(

        function update_quotation() {
            start_load()
            $.ajax({
                url: 'ajax.php?action=update_quotation',
                method: 'POST',
                data: {
                    id: $(this).attr('data-id')
                },
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Data successfully deleted", 'success')
                        setTimeout(function() {
                            location.reload()
                        }, 1500)

                    } else {
                        console.log(resp);
                        end_load()
                    }
                }
            })
        }
    )

    function delete_house($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_house',
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