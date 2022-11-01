<?php
include 'db_connect.php';
session_start();
?>

<div class="container-fluid">
    <form action="" id="manage-agreement" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row form-group">
            <div class="col-md-4">
                <label for="" class="control-label">Agreement</label>
                <input type="file" class="form-control" name="agreement" value="" required>
            </div>
            <div class="col-md-4">
                <label for="" class="control-label">Agreement To</label>
                <select class="form-control" name="tenant_id" required>
                <option value="" disabled selected>Please Select</option>
                    <?php
                    $select_t = mysqli_query($conn, "SELECT * FROM users where type = 3");
                    while ($res_t = mysqli_fetch_assoc($select_t)) {
                    ?>
                    <option value="<?php echo $res_t['id'] ?>"><?php echo $res_t['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" name="landlord_id" value="<?php echo $_SESSION['login_id'] ?>" />
        </div>
        <div class="form-group row">

    </form>
</div>
<script>
    $('#manage-agreement').submit(function(e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url: 'ajax.php?action=save_agreement',
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
                }
            }
        })
    })
</script>