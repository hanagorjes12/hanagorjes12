<?php
session_start();
include 'db_connect.php';
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM payments where id= " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<?php
if ($_SESSION['login_type'] == "3") {
    $query_check = mysqli_query($conn, "SELECT * FROM tenantss where tenant_id = " . $_SESSION['login_id']);
} else if ($_SESSION['login_type'] == "2") {
    $query_check = mysqli_query($conn, "SELECT * FROM tenantss where landlord_id = " . $_SESSION['login_id']);
}
if (mysqli_num_rows($query_check) > 0) {
?>
    <div class="container-fluid">
        <form action="" id="manage-payment" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div id="msg"></div>
            <div class="form-group">
                <label for="tenant_id" class="control-label">House: </label>
                <select name="tenant_id" id="tenant_id" class="custom-select select2" required>
                    <option value=""></option>

                    <?php

                    while ($row = $query_check->fetch_assoc()) :
                        $h_id = $row['house_id'];
                        $query_house = mysqli_query($conn, "SELECT * FROM houses where id = '$h_id'");
                        $res_house = mysqli_fetch_assoc($query_house);
                        if($_SESSION['login_type'] == "2"){
                            $tenantDetails = " |".$row['firstname']." |".$row['email']." |".$row['contact'];
                        }else{
                            $tenantDetails = "";
                        }
                    ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo ucwords($res_house['house_no'] . "|" . $res_house['description']) ?><?php echo "Rental : RM" . $row['rent'] . $tenantDetails;  ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Amount Paid: </label>
                <input type="number" class="form-control text-right" step="any" name="payment" value="<?php echo isset($payment) ? $payment : '' ?>">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Date Paid: </label>
                <input type="date" class="form-control text-right" step="any" name="date" value="<?php echo isset($date) ? $date : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Paid Proof: </label>
                <input type="file" class="form-control text-right" name="proof" value="">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Status: </label>
                <select class="form-control" name="status">
                    <option value="" selected disabled>Please Select A Status</option>
                    <option value="Full Payment">Full Payment</option>
                    <option value="Partial Payment">Partial Payment</option>
                </select>
            </div>
    </div>
    </form>
    </div>
<?php } else { ?>
    <div class="container-fluid">
        <h1>You Dont Have Any Rented House</h1>
    </div>
<?php } ?>
<script>
    $('.select2').select2({
        placeholder: "Please Select Here",
        width: "100%"
    })
    $('#manage-payment').submit(function(e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url: 'ajax.php?action=save_payment',
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
                    end_load()
                }
            }
        })
    })
</script>