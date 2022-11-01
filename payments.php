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
						<b>List of Payments</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_payment">
								<i class="fa fa-plus"></i> New Entry
							</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">House #</th>
									<th class="">Buyer / Tenant</th>
									<th class="">Payment</th>
									<th class="">Status</th>
									<th class="">Pay Date</th>
									<th class="">Landlord Verify</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$sql = mysqli_query($conn, "SELECT * FROM payment where landlord_id = '" . $_SESSION['login_id'] . "'");
								while ($row = mysqli_fetch_assoc($sql)) {
									$select_tenant = mysqli_query($conn, "SELECT * FROM tenantss where id = " . $row['tenant_id']);
									$res_t = mysqli_fetch_assoc($select_tenant);
									$select_house = mysqli_query($conn, "SELECT * FROM houses where id = " . $res_t['house_id']);
									$res_h = mysqli_fetch_assoc($select_house);
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class="">
											<p> <b><?php echo $res_h['house_no'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $res_t['firstname'] . " " . $res_t['middlename'] . " " . $res_t['lastname']; ?></b></p>
										</td>
										<td class="text-left">
											<p> <b><?php echo "RM";
													echo number_format($row['payment'], 2) ?></b></p>
										</td>
										<td class="text-left">
											<p><b><?php echo $row['status'] ?></b></p>
										</td>
										<td class="text-left">
											<p><b><?php echo $row['date'] ?></b></p>
										</td>
										<td>
											<?php
											if ($row['landlord_verify'] == "Unverified") {
												echo "<span class='badge badge-danger'>" . $row['landlord_verify'] . "</span>";
											} else {
												echo "<span class='badge badge-success'>" . $row['landlord_verify'] . "</span>";
											}
											?>
										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>">View</button>
											<?php if ($row['landlord_verify'] != "Verify") { ?>
												<button class="btn btn-sm btn-outline-danger delete_payment" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
												<button class="btn btn-sm btn-outline-success verify_payment" type="button" data-id="<?php echo $row['id'] ?>">Verify</button>
											<?php } ?>
											<a href="paymentProof/<?php echo $row['proof'] ?>" download="" class="btn btn-sm btn-outline-success">Download Proof</a>
										</td>
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
		margin: unset
	}

	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>
<script>
	$(document).ready(function() {
		$('table').dataTable()
	})

	$('#new_payment').click(function() {
		uni_modal("New payment", "manage_payment.php", "mid-large")

	})
	$('.view_payment').click(function() {
		uni_modal2("Tenants Payments", "view_payment.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_payment').click(function() {
		_conf("Are you sure to delete this payment?", "delete_payment", [$(this).attr('data-id')])
	})
	$('.verify_payment').click(function() {
		_conf("Are you sure to verify this payment? <br /> <b>You can't do changes on this payment after verify.</b>", "verify_payment", [$(this).attr('data-id')])
	})

	function delete_payment($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_payment',
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
	function verify_payment($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=verify_payment',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully verify", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>