<?php
include 'db_connect.php';
session_start();
extract($_GET);
?>

<div class="container-fluid">
    <form action="" id="manage-quotation">
        <div class="row form-group">
            <div class="col-md-4">
                <label for="" class="control-label">Name</label>
                <input type="text" class="form-control" name="name" value="" required>
            </div>
            <div class="col-md-4">
                <label for="" class="control-label">Email</label>
                <input type="email" class="form-control" name="email" value="" required>
            </div>
            <div class="col-md-4">
                <label for="" class="control-label">Contact</label>
                <input type="text" class="form-control" name="contact" value="" required>
            </div>

            <input type="hidden" name="house_id" value="<?php echo $id  ?>" />
            <input type="hidden" name="tenant_id" value="<?php echo $_SESSION["login_id"];  ?>" />
            <?php 
                $select_landlord = mysqli_query($conn, "SELECT landlord_id FROM houses WHERE id = '$id'");
                $res = mysqli_fetch_assoc($select_landlord)
            ?>
             <input type="hidden" name="landlord_id" value="<?php echo $res['landlord_id']  ?>" />
        </div>
        <div class="form-group row">

    </form>
</div>
<script>
    $('#manage-quotation').submit(function(e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url: 'ajax.php?action=save_quotation',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved.", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1000)
                } else {
                    console.log(resp);
                    end_load();
                }
            }
        })
    })
</script>