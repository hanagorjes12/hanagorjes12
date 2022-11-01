<?php
include 'db_connect.php';
session_start();
extract($_GET);
?>

<div class="container-fluid">
    <form action="" id="upload-agreement" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row form-group">
            <div class="col-md-4">
                <label for="" class="control-label">Agreement</label>
                <input type="file" class="form-control" name="agreement" value="" required>
            </div>
        </div>
        <div class="form-group row">

    </form>
</div>
<script>
    $('#upload-agreement').submit(function(e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url: 'ajax.php?action=save_agreement2',
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