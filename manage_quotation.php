<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM quotation where id= " . $_GET['id']);

	foreach ($qry->fetch_array() as $k => $val) {
		$$k = $val;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-quotation">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row form-group">
			<div class="col-md-4">
				<label for="" class="control-label">Name</label>
				<input type="text" class="form-control" name="name" value="<?php echo isset($buyer_name) ? $buyer_name : '' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Email</label>
				<input type="email" class="form-control" name="email" value="<?php echo isset($quotation_info) ? $quotation_info : '' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Quotation Info</label>
				<input type="text" class="form-control" name="quotation_info" value="<?php echo isset($email) ? $email : '' ?>" required>
			</div>


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
				} 
			}
		})
	})
</script>