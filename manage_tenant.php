<?php
include 'db_connect.php';
session_start();
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM tenantss where id= " . $_GET['id']);

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
				<label for="" class="control-label">Address</label>
				<input type="text" class="form-control" name="address" value="<?php echo isset($address) ? $address : '' ?>" required>
			</div>

		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">House Rent</label>
				<select class="form-control" name="house_id" required>
					<option value="" disabled selected>Please Select A House</option>
					<?php
					$query_house = mysqli_query($conn, "SELECT * FROM houses where landlord_id = " . $_SESSION['login_id']);
					while ($res = mysqli_fetch_assoc($query_house)) {
					?>
						<option value="<?php echo $res['id'] ?>"<?php if(isset($house_id) && $house_id == $res['id']){echo "selected";}?> ><?php echo $res['house_no'] . " | " . $res['description'] ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Tenant Account</label>
				<select class="form-control" name="tenant_id" required>
					<option value="" disabled selected>Please Select A Tenant</option>
					<?php
						$query_tenant = mysqli_query($conn, "SELECT * FROM users where type = 3");
						while($res_t = mysqli_fetch_assoc($query_tenant)){
					?>
					<option value="<?php echo $res_t['id'] ?>" <?php if(isset($tenant_id) && $tenant_id == $res_t['id']){echo "selected";}?> ><?php echo $res_t['name'] ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Total Rent</label>
				<input type="number" class="form-control" name="rent" value="<?php echo isset($rent) ? $rent : '' ?>" required>
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
			url: 'ajax.php?action=save_tenant',
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
				}else{
					console.log(resp);
					end_load()
				}
			}
		})
	})
</script>