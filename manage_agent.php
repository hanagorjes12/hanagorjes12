<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM tenants where id= " . $_GET['id']);

	foreach ($qry->fetch_array() as $k => $val) {
		$$k = $val;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-tenant">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row form-group">
			<div class="col-md-4">
				<label for="" class="control-label">Last Name</label>
				<input type="text" class="form-control" name="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">First Name</label>
				<input type="text" class="form-control" name="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Middle Name</label>
				<input type="text" class="form-control" name="middlename" value="<?php echo isset($middlename) ? $middlename : '' ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">Email</label>
				<input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : '' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Phone Number</label>
				<input type="text" class="form-control" name="contact" value="<?php echo isset($contact) ? $contact : '' ?>" required>
			</div>
			<div class="col-md-4">
				<?php if (isset($company_id)) { ?>
					<label for="" class="control-label">Company</label>
					<select class="form-control" name="company_id">
						<?php $sql = mysqli_query($conn, "SELECT * FROM company where id = $company_id");
						$res = mysqli_fetch_assoc($sql);
						?>
						<option value="<?php echo $res['id']; ?>"><?php echo $res['company_name'] ?></option>
						<?php $sql2 = mysqli_query($conn, "SELECT * FROM company where id != $company_id");
						while ($ress = mysqli_fetch_assoc($sql2)) { ?>
							<option value="<?php echo $ress['id']; ?>"><?php echo $ress['company_name'] ?></option>
						<?php }
					} else { ?>
						<label for="" class="control-label">Company</label>
						<select class="form-control" name="company_id">
							<?php $sql = mysqli_query($conn, "SELECT * FROM company");
							while ($res = mysqli_fetch_assoc($sql)) {
							?>
								<option value="<?php echo $res['id']; ?>"><?php echo $res['company_name'] ?></option>
						<?php }
						} ?>
						</select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">Agent REN</label>
				<input type="text" class="form-control" name="address" value="<?php echo isset($address) ? $address : '' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Username</label>
				<input type="text" class="form-control" name="username" value="<?php echo isset($username) ? $username : '' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Date</label>
				<input type="date" class="form-control" name="date_in" value="<?php echo isset($date_in) ? date("Y-m-d", strtotime($date_in)) : '' ?>" required>
			</div>
		</div>

	</form>
</div>
<script>
	$('#manage-tenant').submit(function(e) {
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url: 'ajax.php?action=save_agent',
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